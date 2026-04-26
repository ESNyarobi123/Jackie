<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Enums\CourseStatus;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Student\InitiateClickPesaPaymentRequest;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Course;
use App\Models\Payment;
use App\Services\Payment\ClickPesaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClickPesaPaymentController extends Controller
{
    /**
     * Create a local order and initiate a ClickPesa USSD push payment.
     */
    public function store(
        InitiateClickPesaPaymentRequest $request,
        Course $course,
        ClickPesaService $clickPesa,
    ): JsonResponse {
        abort_if($course->status !== CourseStatus::Published, Response::HTTP_NOT_FOUND);

        $amount = number_format((float) $course->price_amount, 0, '.', '');
        $currency = $course->currency;
        $orderReference = $clickPesa->makeOrderReference();
        $phoneNumber = $request->string('phone_number')->toString();
        $fetchSenderDetails = $request->boolean('fetch_sender_details', true);

        $payment = Payment::query()->create([
            'user_id' => $request->user()->id,
            'course_id' => $course->id,
            'provider' => PaymentProvider::ClickPesa,
            'status' => PaymentStatus::Pending,
            'reference' => $orderReference,
            'amount' => $course->price_amount,
            'currency' => $currency,
            'description' => "ClickPesa payment for {$course->title}",
            'metadata' => [
                'phone_number' => $phoneNumber,
                'fetch_sender_details' => $fetchSenderDetails,
            ],
        ]);

        $previewPayload = $clickPesa->previewUssdPush(
            amount: $amount,
            currency: $currency,
            orderReference: $orderReference,
            phoneNumber: $phoneNumber,
            fetchSenderDetails: $fetchSenderDetails,
        );

        $initiationPayload = $clickPesa->initiateUssdPush(
            amount: $amount,
            currency: $currency,
            orderReference: $orderReference,
            phoneNumber: $phoneNumber,
        );

        $payment->forceFill([
            'provider_reference' => $initiationPayload['paymentReference'] ?? $initiationPayload['id'] ?? null,
            'status' => $clickPesa->mapPaymentStatus($initiationPayload['status'] ?? null),
            'gateway_payload' => [
                'preview' => $previewPayload,
                'initiation' => $initiationPayload,
            ],
            'metadata' => [
                ...($payment->metadata ?? []),
                'channel' => $initiationPayload['channel'] ?? null,
                'clickpesa_status' => $initiationPayload['status'] ?? null,
            ],
        ])->save();

        return response()->json([
            'message' => 'ClickPesa payment order created successfully. Customer should approve the USSD push.',
            'data' => PaymentResource::make($payment->load(['course', 'subscription']))->resolve(),
        ], Response::HTTP_CREATED);
    }
}
