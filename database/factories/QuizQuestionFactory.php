<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuizQuestion>
 */
class QuizQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question' => fake()->sentence(8),
            'options' => [
                fake()->sentence(3),
                fake()->sentence(3),
                fake()->sentence(3),
                fake()->sentence(3),
            ],
            'correct_option_index' => fake()->numberBetween(0, 3),
            'explanation' => fake()->boolean(50) ? fake()->sentence(10) : null,
            'sort_order' => 1,
        ];
    }
}
