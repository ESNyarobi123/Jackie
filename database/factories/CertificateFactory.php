<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course = Course::factory()->published();
        $user = User::factory()->student();

        return [
            'user_id' => $user,
            'course_id' => $course,
            'enrollment_id' => Enrollment::factory()->completed()->state([
                'user_id' => $user,
                'course_id' => $course,
            ]),
            'score_percentage' => fake()->numberBetween(80, 100),
            'certificate_number' => Str::upper('CERT-'.fake()->bothify('??##??##??')),
            'pdf_path' => null,
            'issued_at' => now(),
            'metadata' => [],
        ];
    }
}
