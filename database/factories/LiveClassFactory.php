<?php

namespace Database\Factories;

use App\Enums\LiveClassProvider;
use App\Enums\LiveClassStatus;
use App\Models\Course;
use App\Models\LiveClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<LiveClass>
 */
class LiveClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roomName = 'jackie-lms-'.Str::lower((string) Str::ulid());

        return [
            'course_id' => Course::factory()->published(),
            'created_by' => User::factory()->admin(),
            'provider' => LiveClassProvider::Jitsi,
            'status' => LiveClassStatus::Scheduled,
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'room_name' => $roomName,
            'join_url' => "https://meet.jit.si/{$roomName}",
            'scheduled_at' => now()->addDay(),
            'duration_minutes' => 60,
            'settings' => [],
        ];
    }

    /**
     * Indicate that the class is joinable right now.
     */
    public function joinable(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LiveClassStatus::Scheduled,
            'scheduled_at' => now()->addMinutes(5),
        ]);
    }

    /**
     * Indicate that the class is live.
     */
    public function live(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LiveClassStatus::Live,
            'scheduled_at' => now()->subMinutes(10),
        ]);
    }
}
