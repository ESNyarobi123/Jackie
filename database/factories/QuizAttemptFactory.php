<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuizAttempt>
 */
class QuizAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $score = fake()->numberBetween(40, 100);

        return [
            'quiz_id' => Quiz::factory()->published(),
            'user_id' => User::factory()->student(),
            'score_percentage' => $score,
            'passed' => $score >= 80,
            'answers' => [],
            'started_at' => now()->subMinutes(5),
            'completed_at' => now(),
        ];
    }
}
