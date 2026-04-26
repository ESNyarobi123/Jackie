<?php

use App\Enums\EnrollmentStatus;
use App\Enums\LiveClassProvider;
use App\Enums\LiveClassStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LiveClass;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('admin can create a jitsi live class', function () {
    config()->set('services.jitsi.domain', 'meet.jit.si');
    config()->set('services.jitsi.room_prefix', 'jackie-lms');

    $admin = User::factory()->admin()->create();
    $course = Course::factory()->published()->create([
        'title' => 'Conversational English',
        'slug' => 'conversational-english',
    ]);

    $response = $this->actingAs($admin)->postJson('/api/v1/admin/live-classes', [
        'course_id' => $course->id,
        'title' => 'Saturday Speaking Lab',
        'description' => 'Weekly live speaking practice.',
        'scheduled_at' => now()->addDay()->toISOString(),
        'duration_minutes' => 90,
        'settings' => [
            'configOverwrite' => [
                'startWithAudioMuted' => true,
            ],
        ],
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.provider', 'jitsi')
        ->assertJsonPath('data.status', 'scheduled')
        ->assertJsonPath('data.course.id', $course->id)
        ->assertJsonPath('data.duration_minutes', 90);

    $liveClass = LiveClass::query()->firstOrFail();

    expect($liveClass->provider)->toBe(LiveClassProvider::Jitsi)
        ->and($liveClass->status)->toBe(LiveClassStatus::Scheduled)
        ->and($liveClass->room_name)->toStartWith('jackie-lms-conversational-english-saturday-speaking-lab')
        ->and($liveClass->join_url)->toStartWith('https://meet.jit.si/')
        ->and($liveClass->created_by)->toBe($admin->id);
});

test('student can list and join jitsi classes for active enrollments', function () {
    config()->set('services.jitsi.domain', 'meet.jit.si');
    config()->set('services.jitsi.external_api_url', null);
    config()->set('services.jitsi.join_window_before_minutes', 15);
    config()->set('services.jitsi.join_window_after_minutes', 30);

    $student = User::factory()->student()->create([
        'name' => 'Jackie Student',
        'email' => 'student@example.test',
    ]);
    $course = Course::factory()->published()->create();
    $otherCourse = Course::factory()->published()->create();

    Enrollment::factory()->active()->for($student)->for($course)->create([
        'access_expires_at' => now()->addDays(10),
    ]);

    $liveClass = LiveClass::factory()->joinable()->for($course)->create([
        'title' => 'Joinable Speaking Class',
        'room_name' => 'jackie-lms-joinable-speaking-class',
        'join_url' => 'https://meet.jit.si/jackie-lms-joinable-speaking-class',
    ]);

    LiveClass::factory()->joinable()->for($otherCourse)->create([
        'title' => 'Other Course Class',
    ]);

    $this->actingAs($student)->getJson('/api/v1/student/live-classes')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $liveClass->id)
        ->assertJsonMissingPath('data.0.room_name')
        ->assertJsonMissingPath('data.0.join_url');

    $response = $this->actingAs($student)
        ->getJson("/api/v1/student/live-classes/{$liveClass->id}/join");

    $response->assertOk()
        ->assertJsonPath('data.room_name', 'jackie-lms-joinable-speaking-class')
        ->assertJsonPath('data.join_url', 'https://meet.jit.si/jackie-lms-joinable-speaking-class')
        ->assertJsonPath('data.meeting.provider', 'jitsi')
        ->assertJsonPath('data.meeting.domain', 'meet.jit.si')
        ->assertJsonPath('data.meeting.external_api_url', 'https://meet.jit.si/external_api.js')
        ->assertJsonPath('data.meeting.iframe.options.roomName', 'jackie-lms-joinable-speaking-class')
        ->assertJsonPath('data.meeting.iframe.options.userInfo.displayName', 'Jackie Student')
        ->assertJsonPath('data.meeting.iframe.options.userInfo.email', 'student@example.test')
        ->assertJsonPath('data.meeting.iframe.options.configOverwrite.startWithAudioMuted', true)
        ->assertJsonPath('data.meeting.iframe.options.configOverwrite.disableInviteFunctions', true)
        ->assertJsonPath('data.meeting.mobile.ios_url', 'org.jitsi.meet://meet.jit.si/jackie-lms-joinable-speaking-class');
});

test('student cannot join a live class without active course access', function () {
    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create();
    $liveClass = LiveClass::factory()->joinable()->for($course)->create();

    $this->actingAs($student)
        ->getJson("/api/v1/student/live-classes/{$liveClass->id}/join")
        ->assertNotFound();
});

test('student cannot join before the configured jitsi join window opens', function () {
    config()->set('services.jitsi.join_window_before_minutes', 15);

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create();
    $liveClass = LiveClass::factory()->for($course)->create([
        'status' => LiveClassStatus::Scheduled,
        'scheduled_at' => now()->addHour(),
    ]);

    Enrollment::factory()->for($student)->for($course)->create([
        'status' => EnrollmentStatus::Active,
        'access_expires_at' => now()->addDays(10),
    ]);

    $this->actingAs($student)
        ->getJson("/api/v1/student/live-classes/{$liveClass->id}/join")
        ->assertForbidden();
});

test('student can open the protected jitsi iframe page with active access', function () {
    config()->set('services.jitsi.domain', 'meet.jit.si');

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create([
        'title' => 'Speaking Lab',
    ]);
    $liveClass = LiveClass::factory()->joinable()->for($course)->create([
        'title' => 'Pronunciation Room',
    ]);

    Enrollment::factory()->active()->for($student)->for($course)->create([
        'access_expires_at' => now()->addDay(),
    ]);

    $this->actingAs($student)
        ->get("/live-classes/{$liveClass->id}/join")
        ->assertOk()
        ->assertSee('Pronunciation Room')
        ->assertSee('🔴 Live');
});
