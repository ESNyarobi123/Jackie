<?php

namespace Database\Factories;

use App\Enums\CourseStatus;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Str::title(fake()->unique()->words(3, true)),
            'slug' => fake()->unique()->slug(3),
            'excerpt' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'status' => CourseStatus::Draft,
            'price_amount' => fake()->randomElement([15000, 25000, 35000, 50000]),
            'currency' => 'TZS',
            'duration_days' => fake()->randomElement([30, 45, 60, 90]),
            'is_featured' => false,
            'published_at' => null,
            'created_by' => User::factory()->admin(),
        ];
    }

    /**
     * Indicate that the course is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => CourseStatus::Published,
            'published_at' => now(),
        ]);
    }
}
