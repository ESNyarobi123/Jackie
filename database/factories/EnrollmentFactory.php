<?php

namespace Database\Factories;

use App\Enums\EnrollmentStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
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
            'status' => EnrollmentStatus::Pending,
            'enrolled_at' => now(),
            'access_expires_at' => now()->addDays(30),
            'progress_percentage' => 0,
            'completed_at' => null,
        ];
    }

    /**
     * Indicate that the enrollment is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EnrollmentStatus::Active,
            'progress_percentage' => fake()->numberBetween(5, 75),
        ]);
    }

    /**
     * Indicate that the enrollment is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EnrollmentStatus::Completed,
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);
    }

    /**
     * Indicate that the enrollment has expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EnrollmentStatus::Expired,
            'access_expires_at' => now()->subDay(),
        ]);
    }
}
