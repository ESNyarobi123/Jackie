<?php

namespace App\Http\Controllers\Api\V1\Webhooks;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Webhooks\StorePaymentWebhookRequest;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Payment;
use App\Services\Payment\ClickPesaService;
use App\Services\Payment\PaymentAccessService;
use Carbon\CarbonInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        StorePaymentWebhookRequest $request,
        ClickPesaService $clickPesa,
        PaymentAccessService $paymentAccess,
    ): JsonResponse {
        $provider = PaymentProvider::from((string) $request->route('provider'));
        $validated = $request->validated();
        $rawPayload = $request->all();
        $attributes = $this->paymentAttributes($provider, $validated, $rawPayload, $clickPesa);

        $payment = DB::transaction(function () use ($provider, $attributes, $rawPayload): Payment {
            $payment = Payment::query()->firstOrNew([
                'reference' => $attributes['reference'],
            ]);

            $payment->forceFill([
                'user_id' => $attributes['user_id'] ?? $payment->user_id,
                'course_id' => $attributes['course_id'] ?? $payment->course_id,
                'provider' => $provider,
                'status' => $attributes['status'],
                'provider_reference' => $attributes['provider_reference'] ?? $payment->provider_reference,
                'amount' => $attributes['amount'] ?? $payment->amount,
                'currency' => $attributes['currency'] ?? $payment->currency ?? 'TZS',
                'paid_at' => $attributes['paid_at'] ?? $payment->paid_at,
                'failed_at' => $attributes['failed_at'] ?? $payment->failed_at,
                'description' => $attributes['description'] ?? $payment->description,
                'gateway_payload' => [
                    ...($payment->gateway_payload ?? []),
                    'webhook' => $rawPayload,
                ],
                'metadata' => [
                    ...($payment->metadata ?? []),
                    ...($attributes['metadata'] ?? []),
                ],
            ])->save();

            return $payment;
        });

        $payment = $paymentAccess->apply($payment);

        return response()->json([
            'message' => 'Payment webhook processed successfully.',
            'data' => PaymentResource::make($payment)->resolve(),
        ], Response::HTTP_OK);
    }

    /**
     * Normalize webhook payloads into local payment attributes.
     *
     * @param  array<string, mixed>  $validated
     * @param  array<string, mixed>  $rawPayload
     * @return array<string, mixed>
     */
    private function paymentAttributes(
        PaymentProvider $provider,
        array $validated,
        array $rawPayload,
        ClickPesaService $clickPesa,
    ): array {
        if ($provider === PaymentProvider::ClickPesa) {
            return $this->clickPesaPaymentAttributes($validated, $rawPayload, $clickPesa);
        }

        $status = PaymentStatus::tryFrom((string) ($validated['status'] ?? '')) ?? PaymentStatus::Pending;

        return [
            'reference' => $validated['reference'],
            'user_id' => $validated['user_id'] ?? null,
            'course_id' => $validated['course_id'] ?? null,
            'provider_reference' => $validated['provider_reference'] ?? null,
            'status' => $status,
            'amount' => $validated['amount'] ?? 0,
            'currency' => $validated['currency'] ?? 'TZS',
            'paid_at' => $status === PaymentStatus::Paid ? $this->parseTimestamp($validated['paid_at'] ?? null) ?? now() : null,
            'failed_at' => $status === PaymentStatus::Failed ? $this->parseTimestamp($validated['failed_at'] ?? null) ?? now() : null,
            'description' => $validated['description'] ?? null,
            'metadata' => [
                'source' => 'webhook',
                'provider' => $provider->value,
            ],
        ];
    }

    /**
     * Normalize ClickPesa collection webhook/status payloads.
     *
     * @param  array<string, mixed>  $validated
     * @param  array<string, mixed>  $rawPayload
     * @return array<string, mixed>
     */
    private function clickPesaPaymentAttributes(
        array $validated,
        array $rawPayload,
        ClickPesaService $clickPesa,
    ): array {
        $record = $this->clickPesaRecord($rawPayload);
        $status = $clickPesa->mapPaymentStatus($record['status'] ?? $validated['status'] ?? null);
        $timestamp = $this->parseTimestamp($record['updatedAt'] ?? $record['createdAt'] ?? null);

        return [
            'reference' => (string) ($record['orderReference'] ?? $validated['reference'] ?? $validated['orderReference']),
            'user_id' => $validated['user_id'] ?? null,
            'course_id' => $validated['course_id'] ?? null,
            'provider_reference' => $record['paymentReference'] ?? $record['id'] ?? $validated['provider_reference'] ?? null,
            'status' => $status,
            'amount' => $record['collectedAmount'] ?? $validated['amount'] ?? $validated['collectedAmount'] ?? 0,
            'currency' => $record['collectedCurrency'] ?? $validated['currency'] ?? $validated['collectedCurrency'] ?? 'TZS',
            'paid_at' => $status === PaymentStatus::Paid ? $timestamp ?? now() : null,
            'failed_at' => $status === PaymentStatus::Failed ? $timestamp ?? now() : null,
            'description' => $validated['description'] ?? ($record['message'] ?? null),
            'metadata' => [
                'source' => 'webhook',
                'provider' => PaymentProvider::ClickPesa->value,
                'clickpesa_status' => $record['status'] ?? null,
                'payment_phone_number' => $record['paymentPhoneNumber'] ?? null,
                'message' => $record['message'] ?? null,
            ],
        ];
    }

    /**
     * Resolve a ClickPesa record whether the provider sends it nested or flat.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function clickPesaRecord(array $payload): array
    {
        $record = $payload['data'] ?? $payload;

        return is_array($record) ? $record : $payload;
    }

    /**
     * Parse a timestamp safely.
     */
    private function parseTimestamp(mixed $timestamp): ?CarbonInterface
    {
        if (! is_string($timestamp) || $timestamp === '') {
            return null;
        }

        try {
            return Carbon::parse($timestamp);
        } catch (Throwable) {
            return null;
        }
    }
}
