<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Payment;
use App\Services\Payment\ClickPesaService;
use App\Services\Payment\PaymentAccessService;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Throwable;

class PaymentStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        Payment $payment,
        ClickPesaService $clickPesa,
        PaymentAccessService $paymentAccess,
    ): JsonResponse {
        abort_if($payment->user_id !== $request->user()->id, Response::HTTP_NOT_FOUND);

        if ($payment->provider === PaymentProvider::ClickPesa && $payment->status === PaymentStatus::Pending) {
            $statusPayload = Cache::remember(
                $this->statusCacheKey($payment),
                now()->addSeconds(15),
                fn (): array => $clickPesa->queryPaymentStatus($payment->reference),
            );
            $record = $clickPesa->latestPaymentRecord($statusPayload);

            if ($record !== null) {
                $payment = $this->updatePaymentFromClickPesaRecord($payment, $record, $statusPayload, $clickPesa);
            } else {
                $payment->forceFill([
                    'gateway_payload' => [
                        ...($payment->gateway_payload ?? []),
                        'status_query' => $statusPayload,
                    ],
                ])->save();
            }
        }

        $payment = $paymentAccess->apply($payment);

        return response()->json([
            'message' => 'Payment status retrieved successfully.',
            'data' => PaymentResource::make($payment)->resolve(),
        ]);
    }

    /**
     * Update the local payment record from a ClickPesa status record.
     *
     * @param  array<string, mixed>  $record
     * @param  array<string|int, mixed>  $statusPayload
     */
    private function updatePaymentFromClickPesaRecord(
        Payment $payment,
        array $record,
        array $statusPayload,
        ClickPesaService $clickPesa,
    ): Payment {
        $status = $clickPesa->mapPaymentStatus($record['status'] ?? null);
        $timestamp = $this->timestampFromRecord($record);

        $payment->forceFill([
            'provider_reference' => $record['paymentReference'] ?? $record['id'] ?? $payment->provider_reference,
            'status' => $status,
            'amount' => $record['collectedAmount'] ?? $payment->amount,
            'currency' => $record['collectedCurrency'] ?? $payment->currency,
            'paid_at' => $status === PaymentStatus::Paid ? ($payment->paid_at ?? $timestamp ?? now()) : $payment->paid_at,
            'failed_at' => $status === PaymentStatus::Failed ? ($payment->failed_at ?? $timestamp ?? now()) : $payment->failed_at,
            'gateway_payload' => [
                ...($payment->gateway_payload ?? []),
                'status_query' => $statusPayload,
            ],
            'metadata' => [
                ...($payment->metadata ?? []),
                'clickpesa_status' => $record['status'] ?? null,
                'payment_phone_number' => $record['paymentPhoneNumber'] ?? null,
                'message' => $record['message'] ?? null,
            ],
        ])->save();

        return $payment;
    }

    /**
     * Resolve the best available ClickPesa timestamp from a status record.
     *
     * @param  array<string, mixed>  $record
     */
    private function timestampFromRecord(array $record): ?CarbonInterface
    {
        $timestamp = $record['updatedAt'] ?? $record['createdAt'] ?? null;

        if (! is_string($timestamp) || $timestamp === '') {
            return null;
        }

        try {
            return Carbon::parse($timestamp);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Build a short-lived cache key for ClickPesa polling.
     */
    private function statusCacheKey(Payment $payment): string
    {
        return sprintf('payments.clickpesa.status.%s', $payment->reference);
    }
}
