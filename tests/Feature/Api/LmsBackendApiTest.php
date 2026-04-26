<?php

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Jobs\ExpireSubscriptions;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

test('admin can create update and delete a course through the api', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->postJson('/api/v1/admin/courses', [
        'title' => 'Advanced Spoken English',
        'slug' => 'advanced-spoken-english',
        'excerpt' => 'A premium speaking course.',
        'description' => 'Build fluency with guided speaking drills.',
        'status' => 'published',
        'price_amount' => 45000,
        'currency' => 'TZS',
        'duration_days' => 60,
        'is_featured' => true,
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.title', 'Advanced Spoken English')
        ->assertJsonPath('data.status', 'published');

    $courseId = $response->json('data.id');

    $this->actingAs($admin)->patchJson("/api/v1/admin/courses/{$courseId}", [
        'price_amount' => 55000,
        'duration_days' => 90,
    ])->assertOk()
        ->assertJsonPath('data.price_amount', 55000)
        ->assertJsonPath('data.duration_days', 90);

    $this->actingAs($admin)->deleteJson("/api/v1/admin/courses/{$courseId}")
        ->assertNoContent();

    expect(Course::query()->find($courseId))->toBeNull();
});

test('students cannot access admin apis', function () {
    $student = User::factory()->student()->create();

    $this->actingAs($student)
        ->getJson('/api/v1/admin/courses')
        ->assertForbidden();
});

test('student dashboard returns only the authenticated students data', function () {
    $student = User::factory()->student()->create();
    $otherStudent = User::factory()->student()->create();
    $course = Course::factory()->published()->create();

    Enrollment::factory()->for($student)->for($course)->active()->create([
        'progress_percentage' => 42,
    ]);

    Enrollment::factory()->for($otherStudent)->for($course)->active()->create([
        'progress_percentage' => 88,
    ]);

    Payment::factory()->for($student)->for($course)->create([
        'reference' => 'PAY-STUDENT-0001',
    ]);

    $response = $this->actingAs($student)
        ->getJson('/api/v1/student/dashboard');

    $response->assertOk()
        ->assertJsonPath('data.summary.active_enrollments', 1)
        ->assertJsonCount(1, 'data.active_enrollments')
        ->assertJsonCount(1, 'data.recent_payments')
        ->assertJsonPath('data.active_enrollments.0.course.id', $course->id);
});

test('payment webhook creates course access for a paid transaction', function () {
    config()->set('services.payment_webhooks.allow_manual', true);
    config()->set('services.payment_webhooks.secret', 'test-webhook-secret');

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create([
        'duration_days' => 30,
    ]);

    $response = $this
        ->withHeader('X-Webhook-Secret', 'test-webhook-secret')
        ->postJson('/api/v1/webhooks/payments/manual', [
        'reference' => 'PAY-WEBHOOK-0001',
        'provider_reference' => 'MANUAL-0001',
        'user_id' => $student->id,
        'course_id' => $course->id,
        'amount' => 25000,
        'currency' => 'TZS',
        'status' => 'paid',
        'paid_at' => now()->toISOString(),
        'payload' => [
            'channel' => 'manual',
        ],
        ]);

    $response->assertOk()
        ->assertJsonPath('data.reference', 'PAY-WEBHOOK-0001')
        ->assertJsonPath('data.status', 'paid');

    $payment = Payment::query()->where('reference', 'PAY-WEBHOOK-0001')->firstOrFail();
    $subscription = Subscription::query()->where('payment_id', $payment->id)->firstOrFail();
    $enrollment = Enrollment::query()
        ->where('user_id', $student->id)
        ->where('course_id', $course->id)
        ->firstOrFail();

    expect($payment->status)->toBe(PaymentStatus::Paid)
        ->and($subscription->status)->toBe(SubscriptionStatus::Active)
        ->and($enrollment->status)->toBe(EnrollmentStatus::Active)
        ->and($enrollment->subscription_id)->toBe($subscription->id);
});

test('manual payment webhook is rejected without the configured secret', function () {
    config()->set('services.payment_webhooks.allow_manual', true);
    config()->set('services.payment_webhooks.secret', 'test-webhook-secret');

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create();

    $this->postJson('/api/v1/webhooks/payments/manual', [
        'reference' => 'PAY-WEBHOOK-REJECTED',
        'user_id' => $student->id,
        'course_id' => $course->id,
        'amount' => 25000,
        'currency' => 'TZS',
        'status' => 'paid',
    ])->assertUnprocessable()
        ->assertJsonValidationErrors('signature');

    expect(Payment::query()->where('reference', 'PAY-WEBHOOK-REJECTED')->exists())->toBeFalse();
});

test('student courses require active unexpired access and hide protected lesson assets', function () {
    $student = User::factory()->student()->create();
    $activeCourse = Course::factory()->published()->create();
    $expiredCourse = Course::factory()->published()->create();

    Lesson::factory()->published()->for($activeCourse)->create([
        'video_asset' => 'private-video-asset',
        'resource_url' => 'https://cdn.example.test/private.pdf',
    ]);

    Enrollment::factory()->active()->for($student)->for($activeCourse)->create([
        'access_expires_at' => now()->addDay(),
    ]);

    Enrollment::factory()->active()->for($student)->for($expiredCourse)->create([
        'access_expires_at' => now()->subMinute(),
    ]);

    $this->actingAs($student)->getJson('/api/v1/student/courses')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.course.id', $activeCourse->id)
        ->assertJsonMissingPath('data.0.course.lessons.0.video_asset')
        ->assertJsonMissingPath('data.0.course.lessons.0.resource_url');

    $this->actingAs($student)
        ->getJson("/api/v1/student/courses/{$expiredCourse->id}")
        ->assertNotFound();
});

test('admin can upload a private lesson video through the api', function () {
    Storage::fake('local');

    $admin = User::factory()->admin()->create();
    $course = Course::factory()->published()->create();

    $response = $this->actingAs($admin)->post('/api/v1/admin/courses/'.$course->id.'/lessons', [
        'title' => 'Intro Speaking Drill',
        'slug' => 'intro-speaking-drill',
        'summary' => 'Short warm up.',
        'content_type' => 'video',
        'status' => 'draft',
        'media_source' => 'upload',
        'video_file' => UploadedFile::fake()->create('intro.mp4', 128, 'video/mp4'),
        'duration_seconds' => 180,
        'sort_order' => 1,
        'is_preview' => false,
    ], [
        'Accept' => 'application/json',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.video_provider', 'local')
        ->assertJsonPath('data.resource_url', null);

    $lesson = Lesson::query()->where('slug', 'intro-speaking-drill')->firstOrFail();

    expect($lesson->video_provider)->toBe('local')
        ->and($lesson->video_asset)->toStartWith('lesson-videos/');

    Storage::disk('local')->assertExists($lesson->video_asset);
});

test('admin can replace an uploaded lesson video with a url through the api', function () {
    Storage::fake('local');

    $admin = User::factory()->admin()->create();
    $lesson = Lesson::factory()->for(Course::factory()->published())->create([
        'video_provider' => 'local',
        'video_asset' => 'lesson-videos/old-video.mp4',
        'resource_url' => null,
    ]);

    Storage::disk('local')->put('lesson-videos/old-video.mp4', 'old');

    $response = $this->actingAs($admin)->patchJson('/api/v1/admin/lessons/'.$lesson->id, [
        'media_source' => 'url',
        'resource_url' => 'https://videos.example.test/intro.mp4',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.video_provider', 'url')
        ->assertJsonPath('data.video_asset', null)
        ->assertJsonPath('data.resource_url', 'https://videos.example.test/intro.mp4');

    Storage::disk('local')->assertMissing('lesson-videos/old-video.mp4');
});

test('student can create a clickpesa mobile payment order', function () {
    Cache::forget('clickpesa.token');

    config()->set('services.clickpesa.base_url', 'https://api.clickpesa.test/third-parties');
    config()->set('services.clickpesa.client_id', 'client-id');
    config()->set('services.clickpesa.api_key', 'api-key');
    config()->set('services.clickpesa.checksum_enabled', false);

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create([
        'title' => 'Fluent English Starter',
        'price_amount' => 25000,
        'currency' => 'TZS',
    ]);

    Http::fake(function (Request $request) {
        if (str_ends_with($request->url(), '/generate-token')) {
            expect($request->header('client-id')[0] ?? null)->toBe('client-id')
                ->and($request->header('api-key')[0] ?? null)->toBe('api-key');

            return Http::response([
                'success' => true,
                'token' => 'TEST_TOKEN',
            ]);
        }

        if (str_ends_with($request->url(), '/payments/preview-ussd-push-request')) {
            expect($request->header('Authorization')[0] ?? null)->toBe('Bearer TEST_TOKEN')
                ->and($request->data()['amount'])->toBe('25000')
                ->and($request->data()['currency'])->toBe('TZS')
                ->and($request->data()['phoneNumber'])->toBe('255712345678')
                ->and($request->data()['fetchSenderDetails'])->toBeTrue();

            return Http::response([
                'activeMethods' => [
                    [
                        'name' => 'M-PESA',
                        'status' => 'AVAILABLE',
                    ],
                ],
                'sender' => [
                    'accountName' => 'Test Student',
                    'accountNumber' => '255712345678',
                    'accountProvider' => 'M-PESA',
                ],
            ]);
        }

        if (str_ends_with($request->url(), '/payments/initiate-ussd-push-request')) {
            expect($request->header('Authorization')[0] ?? null)->toBe('Bearer TEST_TOKEN')
                ->and($request->data()['amount'])->toBe('25000')
                ->and($request->data()['currency'])->toBe('TZS')
                ->and($request->data()['phoneNumber'])->toBe('255712345678');

            return Http::response([
                'id' => 'cp_txn_001',
                'status' => 'PROCESSING',
                'channel' => 'M-PESA',
                'orderReference' => $request->data()['orderReference'],
                'collectedAmount' => '25000',
                'collectedCurrency' => 'TZS',
                'createdAt' => now()->toISOString(),
                'clientId' => 'client-id',
            ]);
        }

        return Http::response([], 404);
    });

    $response = $this->actingAs($student)->postJson(
        "/api/v1/student/courses/{$course->id}/payments/clickpesa",
        ['phone_number' => '255712345678']
    );

    $response->assertCreated()
        ->assertJsonPath('data.provider', 'clickpesa')
        ->assertJsonPath('data.status', 'pending')
        ->assertJsonPath('data.provider_reference', 'cp_txn_001');

    $payment = Payment::query()->where('provider_reference', 'cp_txn_001')->firstOrFail();

    expect($payment->provider)->toBe(PaymentProvider::ClickPesa)
        ->and($payment->status)->toBe(PaymentStatus::Pending)
        ->and($payment->reference)->toStartWith('CP-')
        ->and($payment->metadata['phone_number'])->toBe('255712345678')
        ->and($payment->gateway_payload['preview']['sender']['accountProvider'])->toBe('M-PESA');

    Http::assertSentCount(3);
});

test('student can poll clickpesa payment status and receive course access', function () {
    Cache::forget('clickpesa.token');

    config()->set('services.clickpesa.base_url', 'https://api.clickpesa.test/third-parties');
    config()->set('services.clickpesa.client_id', 'client-id');
    config()->set('services.clickpesa.api_key', 'api-key');

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create([
        'duration_days' => 45,
        'price_amount' => 25000,
    ]);
    $payment = Payment::factory()->pending()->for($student)->for($course)->create([
        'provider' => PaymentProvider::ClickPesa,
        'reference' => 'CP-STATUS-0001',
        'amount' => 25000,
        'currency' => 'TZS',
    ]);

    Http::fake(function (Request $request) {
        if (str_ends_with($request->url(), '/generate-token')) {
            return Http::response([
                'success' => true,
                'token' => 'TEST_TOKEN',
            ]);
        }

        if (str_ends_with($request->url(), '/payments/CP-STATUS-0001')) {
            expect($request->header('Authorization')[0] ?? null)->toBe('Bearer TEST_TOKEN');

            return Http::response([
                [
                    'id' => 'cp_txn_status_001',
                    'status' => 'SUCCESS',
                    'paymentReference' => 'CP-PAY-STATUS-0001',
                    'paymentPhoneNumber' => '255712345678',
                    'orderReference' => 'CP-STATUS-0001',
                    'collectedAmount' => 25000,
                    'collectedCurrency' => 'TZS',
                    'message' => 'Payment successful',
                    'updatedAt' => now()->toISOString(),
                    'createdAt' => now()->subMinute()->toISOString(),
                    'clientId' => 'client-id',
                ],
            ]);
        }

        return Http::response([], 404);
    });

    $response = $this->actingAs($student)
        ->getJson("/api/v1/student/payments/{$payment->id}/status");

    $response->assertOk()
        ->assertJsonPath('data.status', 'paid')
        ->assertJsonPath('data.provider_reference', 'CP-PAY-STATUS-0001');

    $payment->refresh();
    $subscription = Subscription::query()->where('payment_id', $payment->id)->firstOrFail();
    $enrollment = Enrollment::query()
        ->where('user_id', $student->id)
        ->where('course_id', $course->id)
        ->firstOrFail();

    expect($payment->status)->toBe(PaymentStatus::Paid)
        ->and($payment->paid_at)->not->toBeNull()
        ->and($subscription->status)->toBe(SubscriptionStatus::Active)
        ->and($subscription->access_ends_at->isSameDay($payment->paid_at->copy()->addDays(45)))->toBeTrue()
        ->and($enrollment->status)->toBe(EnrollmentStatus::Active);

    Http::assertSentCount(2);
});

test('student payment status polling reuses a short clickpesa cache', function () {
    Cache::forget('clickpesa.token');
    Cache::forget('payments.clickpesa.status.CP-CACHED-0001');

    config()->set('services.clickpesa.base_url', 'https://api.clickpesa.test/third-parties');
    config()->set('services.clickpesa.client_id', 'client-id');
    config()->set('services.clickpesa.api_key', 'api-key');

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create();
    $payment = Payment::factory()->pending()->for($student)->for($course)->create([
        'provider' => PaymentProvider::ClickPesa,
        'reference' => 'CP-CACHED-0001',
    ]);

    Http::fake(function (Request $request) {
        if (str_ends_with($request->url(), '/generate-token')) {
            return Http::response([
                'success' => true,
                'token' => 'TEST_TOKEN',
            ]);
        }

        if (str_ends_with($request->url(), '/payments/CP-CACHED-0001')) {
            return Http::response([]);
        }

        return Http::response([], 404);
    });

    $this->actingAs($student)
        ->getJson("/api/v1/student/payments/{$payment->id}/status")
        ->assertOk()
        ->assertJsonPath('data.status', 'pending');

    $this->actingAs($student)
        ->getJson("/api/v1/student/payments/{$payment->id}/status")
        ->assertOk()
        ->assertJsonPath('data.status', 'pending');

    Http::assertSentCount(2);
});

test('clickpesa webhook settles an existing payment and grants course access', function () {
    config()->set('services.clickpesa.checksum_enabled', false);

    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create([
        'duration_days' => 30,
        'price_amount' => 25000,
    ]);
    $payment = Payment::factory()->pending()->for($student)->for($course)->create([
        'provider' => PaymentProvider::ClickPesa,
        'reference' => 'CP-WEBHOOK-0001',
        'amount' => 25000,
        'currency' => 'TZS',
    ]);

    $response = $this->postJson('/api/v1/webhooks/payments/clickpesa', [
        'event' => 'payment.updated',
        'data' => [
            'id' => 'cp_txn_webhook_001',
            'status' => 'SETTLED',
            'paymentReference' => 'CP-PAY-WEBHOOK-0001',
            'paymentPhoneNumber' => '255712345678',
            'orderReference' => 'CP-WEBHOOK-0001',
            'collectedAmount' => 25000,
            'collectedCurrency' => 'TZS',
            'message' => 'Payment settled',
            'updatedAt' => now()->toISOString(),
            'createdAt' => now()->subMinute()->toISOString(),
            'clientId' => 'client-id',
        ],
    ]);

    $response->assertOk()
        ->assertJsonPath('data.status', 'paid')
        ->assertJsonPath('data.provider_reference', 'CP-PAY-WEBHOOK-0001');

    $payment->refresh();

    expect($payment->status)->toBe(PaymentStatus::Paid)
        ->and($payment->metadata['clickpesa_status'])->toBe('SETTLED')
        ->and(Subscription::query()->where('payment_id', $payment->id)->exists())->toBeTrue()
        ->and(Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $course->id)
            ->where('status', EnrollmentStatus::Active)
            ->exists())->toBeTrue();
});

test('expire subscriptions job marks expired access correctly', function () {
    $student = User::factory()->student()->create();
    $course = Course::factory()->published()->create();
    $payment = Payment::factory()->for($student)->for($course)->create([
        'reference' => 'PAY-EXPIRE-0001',
    ]);

    $subscription = Subscription::factory()
        ->active()
        ->for($student)
        ->for($course)
        ->for($payment)
        ->create([
            'access_ends_at' => now()->subHour(),
        ]);

    Enrollment::factory()
        ->active()
        ->for($student)
        ->for($course)
        ->create([
            'subscription_id' => $subscription->id,
            'access_expires_at' => now()->subHour(),
        ]);

    app(ExpireSubscriptions::class)->handle();

    expect($subscription->fresh()->status)->toBe(SubscriptionStatus::Expired)
        ->and($subscription->fresh()->expired_at)->not->toBeNull()
        ->and(
            Enrollment::query()->where('subscription_id', $subscription->id)->firstOrFail()->status
        )->toBe(EnrollmentStatus::Expired);
});
