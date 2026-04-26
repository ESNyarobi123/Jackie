<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

test('student can open an active lesson player and stream private media', function () {
    Storage::fake('local');
    Storage::disk('local')->put('lesson-videos/protected.mp4', 'private video');

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->published()->for($course)->create([
        'title' => 'Protected Pronunciation',
        'video_provider' => 'local',
        'video_asset' => 'lesson-videos/protected.mp4',
        'resource_url' => null,
    ]);

    Enrollment::factory()->active()->for($student)->for($course)->create([
        'access_expires_at' => now()->addDay(),
    ]);

    $this->actingAs($student)
        ->get(route('student.lessons.show', $lesson))
        ->assertOk()
        ->assertSee('Protected Pronunciation')
        ->assertSee(route('student.lessons.media', $lesson), false);

    $response = $this->actingAs($student)
        ->get(route('student.lessons.media', $lesson))
        ->assertOk();

    expect($response->headers->get('Cache-Control'))
        ->toContain('private')
        ->toContain('max-age=300');
});

test('student cannot open lesson player or media after access expires', function () {
    Storage::fake('local');
    Storage::disk('local')->put('lesson-videos/expired.mp4', 'private video');

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->published()->for($course)->create([
        'video_provider' => 'local',
        'video_asset' => 'lesson-videos/expired.mp4',
    ]);

    Enrollment::factory()->active()->for($student)->for($course)->create([
        'access_expires_at' => now()->subMinute(),
    ]);

    $this->actingAs($student)
        ->get(route('student.lessons.show', $lesson))
        ->assertNotFound();

    $this->actingAs($student)
        ->get(route('student.lessons.media', $lesson))
        ->assertNotFound();
});

test('draft lessons are hidden from students even with course access', function () {
    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();

    Enrollment::factory()->active()->for($student)->for($course)->create([
        'access_expires_at' => now()->addDay(),
    ]);

    $this->actingAs($student)
        ->get(route('student.lessons.show', $lesson))
        ->assertNotFound();
});
