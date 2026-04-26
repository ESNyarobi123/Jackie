<?php

namespace Database\Factories;

use App\Enums\LessonContentType;
use App\Enums\LessonStatus;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
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
            'title' => Str::title(fake()->unique()->words(4, true)),
            'slug' => fake()->unique()->slug(4),
            'summary' => fake()->sentence(),
            'content_type' => LessonContentType::Video,
            'status' => LessonStatus::Draft,
            'video_provider' => fake()->randomElement(['bunny', 'cloudflare-stream', 'vimeo']),
            'video_asset' => fake()->uuid(),
            'resource_url' => fake()->url(),
            'duration_seconds' => fake()->numberBetween(300, 2400),
            'sort_order' => fake()->numberBetween(1, 12),
            'is_preview' => false,
            'published_at' => null,
        ];
    }

    /**
     * Indicate that the lesson is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LessonStatus::Published,
            'published_at' => now(),
        ]);
    }

    /**
     * Indicate that the lesson can be previewed publicly.
     */
    public function preview(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_preview' => true,
        ]);
    }
}
