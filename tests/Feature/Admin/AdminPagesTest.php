<?php

use App\Livewire\Admin\Courses\Show;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LiveClass;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(LazilyRefreshDatabase::class);

test('admin can visit admin pages', function () {
    $admin = User::factory()->admin()->create();

    $course = Course::factory()->create(['created_by' => $admin->id]);
    $payment = Payment::factory()->create();
    $liveClass = LiveClass::factory()->create(['created_by' => $admin->id]);
    $student = User::factory()->student()->create();
    $user = User::factory()->create();

    $this->actingAs($admin)
        ->get(route('admin.courses.index'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.courses.create'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.courses.show', $course))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.courses.edit', $course))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.students.index'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.students.show', $student))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.payments.index'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.payments.show', $payment))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.live-classes.index'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.live-classes.create'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.live-classes.show', $liveClass))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.live-classes.edit', $liveClass))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.live-classes.join', $liveClass))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.users.create'))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.users.show', $user))
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.users.edit', $user))
        ->assertOk();
});

test('students are forbidden from visiting admin pages', function () {
    $student = User::factory()->student()->create();

    $course = Course::factory()->create();
    $payment = Payment::factory()->create();
    $liveClass = LiveClass::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($student)
        ->get(route('admin.courses.index'))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('admin.courses.show', $course))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('admin.payments.index'))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('admin.live-classes.index'))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('admin.users.index'))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('admin.users.show', $user))
        ->assertForbidden();
});

test('admin can create and edit lesson video media from the course page', function () {
    Storage::fake('local');

    $admin = User::factory()->admin()->create();
    $course = Course::factory()->published()->create(['created_by' => $admin->id]);

    Livewire::actingAs($admin)
        ->test(Show::class, ['course' => $course])
        ->call('openCreateLesson')
        ->set('lesson_title', 'Fast Pronunciation')
        ->set('lesson_slug', 'fast-pronunciation')
        ->set('lesson_content_type', 'video')
        ->set('lesson_status', 'draft')
        ->set('lesson_media_source', 'upload')
        ->set('lesson_video_file', UploadedFile::fake()->create('pronunciation.mp4', 128, 'video/mp4'))
        ->set('lesson_duration_seconds', 240)
        ->set('lesson_sort_order', 1)
        ->call('saveLesson')
        ->assertHasNoErrors();

    $lesson = Lesson::query()->where('slug', 'fast-pronunciation')->firstOrFail();

    expect($lesson->video_provider)->toBe('local')
        ->and($lesson->video_asset)->toStartWith('lesson-videos/');

    Storage::disk('local')->assertExists($lesson->video_asset);

    Livewire::actingAs($admin)
        ->test(Show::class, ['course' => $course->fresh()])
        ->call('openEditLesson', $lesson->id)
        ->set('lesson_media_source', 'url')
        ->set('lesson_resource_url', 'https://videos.example.test/fast-pronunciation.mp4')
        ->call('saveLesson')
        ->assertHasNoErrors();

    $lesson->refresh();

    expect($lesson->video_provider)->toBe('url')
        ->and($lesson->video_asset)->toBeNull()
        ->and($lesson->resource_url)->toBe('https://videos.example.test/fast-pronunciation.mp4');
});
