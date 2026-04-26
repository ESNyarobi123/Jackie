<?php

namespace Database\Factories;

use App\Enums\QuizStatus;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory()->published(),
            'lesson_id' => null,
            'title' => fake()->sentence(4),
            'status' => QuizStatus::Draft,
            'pass_percentage' => 80,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => QuizStatus::Published,
            'published_at' => now(),
        ]);
    }
}
