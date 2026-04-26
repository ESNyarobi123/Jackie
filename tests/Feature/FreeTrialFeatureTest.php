<?php

use App\Enums\CourseStatus;
use App\Enums\EnrollmentStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;

test('course has free trial fields', function () {
    $course = Course::factory()->create([
        'has_free_trial' => true,
        'free_trial_days' => 7,
        'status' => CourseStatus::Published,
    ]);

    expect($course->has_free_trial)->toBeTrue();
    expect($course->free_trial_days)->toBe(7);
});

test('course defaults to no free trial', function () {
    $course = Course::factory()->create(['status' => CourseStatus::Published]);
    $course = $course->fresh();

    expect($course->has_free_trial)->toBeFalse();
    expect($course->free_trial_days)->toBe(0);
});

test('welcome page shows published courses with trial info', function () {
    Course::factory()->create([
        'title' => 'Test Course with Trial',
        'has_free_trial' => true,
        'free_trial_days' => 7,
        'status' => CourseStatus::Published,
        'price_amount' => 25000,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Test Course with Trial');
    $response->assertSee('7-Day Free Trial');
});

test('admin can toggle free trial on course edit', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $course = Course::factory()->create([
        'status' => CourseStatus::Draft,
        'has_free_trial' => false,
        'free_trial_days' => 0,
    ]);

    $response = $this->actingAs($admin)
        ->get(route('admin.courses.edit', $course));

    $response->assertStatus(200);
    $response->assertSee('Free Trial');
});

test('admin dashboard shows trial subscription stats', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->actingAs($admin)
        ->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Free Trials');
});

test('student can start free trial from catalog', function () {
    $student = User::factory()->create(['role' => UserRole::Student]);
    $course = Course::factory()->create([
        'has_free_trial' => true,
        'free_trial_days' => 7,
        'status' => CourseStatus::Published,
    ]);

    Livewire::actingAs($student)
        ->test(\App\Livewire\Student\Catalog::class)
        ->call('startFreeTrial', $course->id);

    // Verify subscription was created
    $subscription = Subscription::query()
        ->where('user_id', $student->id)
        ->where('course_id', $course->id)
        ->first();

    expect($subscription)->not->toBeNull();
    expect($subscription->status)->toBe(SubscriptionStatus::Active);
    expect($subscription->payment_id)->toBeNull();
    expect($subscription->access_ends_at)->not->toBeNull();

    // Verify enrollment was created
    $enrollment = Enrollment::query()
        ->where('user_id', $student->id)
        ->where('course_id', $course->id)
        ->first();

    expect($enrollment)->not->toBeNull();
    expect($enrollment->status)->toBe(EnrollmentStatus::Active);
});

test('catalog page shows subscription plans with free trial', function () {
    $student = User::factory()->create(['role' => UserRole::Student]);

    SubscriptionPlan::query()->create([
        'name' => 'Free Trial',
        'slug' => 'free-trial',
        'is_free_trial' => true,
        'trial_days' => 7,
        'price_amount' => 0,
        'duration_days' => 7,
        'is_active' => true,
        'sort_order' => 1,
        'features' => ['Access to all courses', '7-day free trial'],
    ]);

    $response = $this->actingAs($student)
        ->get(route('student.catalog'));

    $response->assertStatus(200);
    $response->assertSee('Choose Your Plan');
    $response->assertSee('Free Trial');
    $response->assertSee('Start Free Trial');
});
