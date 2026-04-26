<?php

namespace Database\Factories;

use App\Enums\SubscriptionStatus;
use App\Models\Course;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->student(),
            'course_id' => Course::factory()->published(),
            'payment_id' => null,
            'status' => SubscriptionStatus::Pending,
            'access_starts_at' => now(),
            'access_ends_at' => now()->addDays(30),
            'renewal_reminder_sent_at' => null,
            'expired_at' => null,
            'metadata' => [],
        ];
    }

    /**
     * Indicate that the subscription is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatus::Active,
        ]);
    }

    /**
     * Indicate that the subscription has expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatus::Expired,
            'access_ends_at' => now()->subDay(),
            'expired_at' => now()->subDay(),
        ]);
    }
}
