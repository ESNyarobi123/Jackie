<?php

namespace App\Jobs;

use App\Enums\EnrollmentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Enrollment;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class ExpireSubscriptions implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 1;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 60;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $timestamp = now();

        Subscription::query()
            ->active()
            ->whereNotNull('access_ends_at')
            ->where('access_ends_at', '<=', $timestamp)
            ->chunkById(100, function ($subscriptions) use ($timestamp): void {
                $subscriptionIds = $subscriptions->modelKeys();

                Subscription::query()
                    ->whereKey($subscriptionIds)
                    ->update([
                        'status' => SubscriptionStatus::Expired->value,
                        'expired_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ]);

                Enrollment::query()
                    ->whereIn('subscription_id', $subscriptionIds)
                    ->where('status', '!=', EnrollmentStatus::Completed->value)
                    ->update([
                        'status' => EnrollmentStatus::Expired->value,
                        'updated_at' => $timestamp,
                    ]);
            });

        Enrollment::query()
            ->active()
            ->whereNull('subscription_id')
            ->whereNotNull('access_expires_at')
            ->where('access_expires_at', '<=', $timestamp)
            ->update([
                'status' => EnrollmentStatus::Expired->value,
                'updated_at' => $timestamp,
            ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        if ($exception !== null) {
            report($exception);
        }
    }
}
