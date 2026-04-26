<?php

namespace Database\Factories;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
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
            'subscription_id' => null,
            'provider' => PaymentProvider::Manual,
            'status' => PaymentStatus::Paid,
            'reference' => 'PAY-'.strtoupper(fake()->bothify('??##??##')),
            'provider_reference' => 'GW-'.strtoupper(fake()->bothify('??##??##')),
            'amount' => fake()->randomElement([15000, 25000, 35000, 50000]),
            'currency' => 'TZS',
            'paid_at' => now(),
            'failed_at' => null,
            'description' => fake()->sentence(),
            'gateway_payload' => ['source' => 'factory'],
            'metadata' => ['channel' => 'seed'],
        ];
    }

    /**
     * Indicate that the payment is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentStatus::Pending,
            'paid_at' => null,
        ]);
    }

    /**
     * Indicate that the payment has failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentStatus::Failed,
            'paid_at' => null,
            'failed_at' => now(),
        ]);
    }
}
