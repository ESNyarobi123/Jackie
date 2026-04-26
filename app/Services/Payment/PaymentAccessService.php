<?php

namespace App\Services\Payment;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class PaymentAccessService
{
    /**
     * Apply the current payment state to course access records.
     */
    public function apply(Payment $payment): Payment
    {
        return DB::transaction(function () use ($payment): Payment {
            if (
                $payment->status !== PaymentStatus::Paid
                || $payment->user_id === null
                || $payment->course_id === null
            ) {
                return $payment->load(['course', 'subscription']);
            }

            $course = Course::query()->find($payment->course_id);
            $accessStartsAt = $payment->paid_at ?? now();
            $accessEndsAt = $accessStartsAt->copy()->addDays($course?->duration_days ?? 30);

            $subscription = Subscription::query()->updateOrCreate(
                ['payment_id' => $payment->id],
                [
                    'user_id' => $payment->user_id,
                    'course_id' => $payment->course_id,
                    'status' => SubscriptionStatus::Active,
                    'access_starts_at' => $accessStartsAt,
                    'access_ends_at' => $accessEndsAt,
                    'expired_at' => null,
                    'metadata' => [
                        'source' => $payment->provider?->value,
                        'payment_reference' => $payment->reference,
                    ],
                ],
            );

            $payment->forceFill([
                'subscription_id' => $subscription->id,
            ])->save();

            Enrollment::query()->updateOrCreate(
                [
                    'user_id' => $payment->user_id,
                    'course_id' => $payment->course_id,
                ],
                [
                    'subscription_id' => $subscription->id,
                    'status' => EnrollmentStatus::Active,
                    'enrolled_at' => $accessStartsAt,
                    'access_expires_at' => $accessEndsAt,
                ],
            );

            return $payment->load(['course', 'subscription.course']);
        });
    }
}
