<?php

use App\Enums\CourseStatus;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Livewire\Student\Catalog;
use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(LazilyRefreshDatabase::class);

test('student can initiate clickpesa payment from catalog', function () {
    $student = User::factory()->student()->create([
        'phone' => '255712345678',
    ]);

    $course = Course::factory()->create([
        'status' => CourseStatus::Published,
        'price_amount' => 15000,
        'currency' => 'TZS',
    ]);

    Http::fake([
        '*generate-token*' => Http::response(['token' => 'token-123'], 200),
        '*preview-ussd-push-request*' => Http::response(['ok' => true], 200),
        '*initiate-ussd-push-request*' => Http::response([
            'id' => 'gw-1',
            'paymentReference' => 'gw-1',
            'status' => 'PENDING',
            'channel' => 'MPESA',
        ], 200),
    ]);

    \Livewire\Livewire::actingAs($student)
        ->test(Catalog::class)
        ->call('openSubscribe', $course->id)
        ->set('selectedNetwork', 'mpesa')
        ->set('phoneNumber', '0712345678')
        ->call('startClickPesaPayment')
        ->assertSet('showSubscribeModal', true)
        ->assertNotSet('activePayment', null);

    $payment = Payment::query()->latest()->first();
    expect($payment)->not->toBeNull();
    expect($payment->user_id)->toBe($student->id);
    expect($payment->course_id)->toBe($course->id);
    expect($payment->provider)->toBe(PaymentProvider::ClickPesa);
    expect($payment->status)->toBe(PaymentStatus::Pending);
    expect($payment->metadata['phone_number'])->toBe('255712345678');
});
