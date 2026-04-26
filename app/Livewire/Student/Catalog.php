<?php

namespace App\Livewire\Student;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\Payment\ClickPesaService;
use App\Services\Payment\PaymentAccessService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Catalog extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 12;

    public bool $showSubscribeModal = false;
    public ?Course $selectedCourse = null;
    public ?SubscriptionPlan $selectedPlan = null;
    public string $phoneNumber = '';
    public string $selectedNetwork = '';

    public ?Payment $activePayment = null;
    public ?string $paymentMessage = null;

    protected function queryString(): array
    {
        return [
            'search' => ['except' => ''],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openSubscribe(int $courseId): void
    {
        $this->resetSubscribeState();

        $course = Course::query()->published()->findOrFail($courseId);
        $this->selectedCourse = $course;

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->phoneNumber = $user->phone ?? '';

        $this->showSubscribeModal = true;
    }

    public function startFreeTrial(int $courseId): void
    {
        $course = Course::query()->where('has_free_trial', true)->published()->findOrFail($courseId);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check if already has active subscription/enrollment
        $existingSub = Subscription::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', SubscriptionStatus::Active->value)
            ->exists();

        if ($existingSub) {
            $this->redirectRoute('student.courses', navigate: true);

            return;
        }

        // Create trial subscription (no payment_id)
        $trialDays = $course->free_trial_days ?: 7;

        Subscription::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => SubscriptionStatus::Active->value,
            'access_starts_at' => now(),
            'access_ends_at' => now()->addDays($trialDays),
            'metadata' => ['type' => 'free_trial', 'trial_days' => $trialDays],
        ]);

        // Create enrollment
        Enrollment::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => EnrollmentStatus::Active->value,
            'enrolled_at' => now(),
            'access_expires_at' => now()->addDays($trialDays),
            'progress_percentage' => 0,
        ]);

        $this->redirectRoute('student.courses', navigate: true);
    }

    public function startClickPesaPayment(ClickPesaService $clickPesa): void
    {
        if (! $this->selectedCourse && ! $this->selectedPlan) {
            return;
        }

        $this->validate([
            'selectedNetwork' => ['required', 'string', 'in:mpesa,airtel,tigo,halotel'],
        ], [
            'selectedNetwork.required' => 'Please select a mobile network.',
            'selectedNetwork.in' => 'Please select a valid mobile network.',
        ]);

        $phoneNumber = $this->normalizePhoneNumber($this->phoneNumber);

        if (! preg_match('/^255[0-9]{9}$/', $phoneNumber)) {
            $this->addError('phoneNumber', 'Enter a valid phone number in Tanzania format (e.g. 2557XXXXXXXX).');

            return;
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($this->selectedPlan) {
            $priceAmount = $this->selectedPlan->price_amount;
            $currency = (string) $this->selectedPlan->currency;
            $description = "ClickPesa payment for {$this->selectedPlan->name} plan";
            $courseId = null;
            $planId = $this->selectedPlan->id;
        } else {
            $priceAmount = $this->selectedCourse->price_amount;
            $currency = (string) $this->selectedCourse->currency;
            $description = "ClickPesa payment for {$this->selectedCourse->title}";
            $courseId = $this->selectedCourse->id;
            $planId = null;
        }

        $amount = number_format((float) $priceAmount, 0, '.', '');
        $orderReference = $clickPesa->makeOrderReference();

        $payment = Payment::query()->create([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'provider' => PaymentProvider::ClickPesa,
            'status' => PaymentStatus::Pending,
            'reference' => $orderReference,
            'amount' => $priceAmount,
            'currency' => $currency,
            'description' => $description,
            'metadata' => [
                'phone_number' => $phoneNumber,
                'fetch_sender_details' => true,
                'plan_id' => $planId,
                'network' => $this->selectedNetwork,
            ],
        ]);

        try {
            // Clear cached token to force fresh generation in case it expired or is invalid
            Cache::forget(config('services.clickpesa.token_cache_key', 'clickpesa.token'));

            $previewPayload = $clickPesa->previewUssdPush(
                amount: $amount,
                currency: $currency,
                orderReference: $orderReference,
                phoneNumber: $phoneNumber,
                fetchSenderDetails: true,
            );

            $initiationPayload = $clickPesa->initiateUssdPush(
                amount: $amount,
                currency: $currency,
                orderReference: $orderReference,
                phoneNumber: $phoneNumber,
            );

            $payment->forceFill([
                'provider_reference' => $initiationPayload['paymentReference'] ?? $initiationPayload['id'] ?? null,
                'status' => $clickPesa->mapPaymentStatus($initiationPayload['status'] ?? null),
                'gateway_payload' => [
                    'preview' => $previewPayload,
                    'initiation' => $initiationPayload,
                ],
                'metadata' => [
                    ...($payment->metadata ?? []),
                    'channel' => $initiationPayload['channel'] ?? null,
                    'clickpesa_status' => $initiationPayload['status'] ?? null,
                ],
            ])->save();

            $this->activePayment = $payment->fresh();
            $this->paymentMessage = 'USSD push sent. Approve on your phone, then tap “Check status”.';
        } catch (\Throwable $e) {
            $errorBody = '';
            if ($e instanceof \Illuminate\Http\Client\RequestException) {
                $errorBody = $e->response?->body() ?? '';
            }

            Log::warning('ClickPesa initiation failed', [
                'payment_id' => $payment->id,
                'reference' => $payment->reference,
                'message' => $e->getMessage(),
                'status' => $e instanceof \Illuminate\Http\Client\RequestException ? $e->response?->status() : null,
                'body' => $errorBody,
                'network' => $this->selectedNetwork,
                'phone' => $phoneNumber,
            ]);

            $payment->forceFill([
                'status' => PaymentStatus::Failed,
                'failed_at' => now(),
                'metadata' => [
                    ...($payment->metadata ?? []),
                    'error' => $e->getMessage(),
                    'error_body' => $errorBody ?: null,
                ],
            ])->save();

            $this->activePayment = $payment->fresh();

            // Show user-friendly message based on error type
            if (str_contains($e->getMessage(), '401')) {
                $this->paymentMessage = 'Payment service authentication failed. Please contact support.';
            } elseif (str_contains($e->getMessage(), '403')) {
                $this->paymentMessage = 'Payment service access denied. Please contact support.';
            } else {
                $this->paymentMessage = 'Payment could not be initiated. Please try again or contact support.';
            }
        }
    }

    public function retryPayment(): void
    {
        $this->activePayment = null;
        $this->paymentMessage = null;
        $this->resetErrorBag();
    }

    public function checkPaymentStatus(
        ClickPesaService $clickPesa,
        PaymentAccessService $paymentAccess,
    ): void {
        if (! $this->activePayment) {
            return;
        }

        $payment = Payment::query()->findOrFail($this->activePayment->id);

        if ($payment->user_id !== auth()->id()) {
            abort(404);
        }

        if ($payment->provider === PaymentProvider::ClickPesa && $payment->status === PaymentStatus::Pending) {
            $statusPayload = $clickPesa->queryPaymentStatus($payment->reference);
            $record = $clickPesa->latestPaymentRecord($statusPayload);

            if ($record) {
                $status = $clickPesa->mapPaymentStatus($record['status'] ?? null);
                $timestamp = $this->timestampFromRecord($record);

                $payment->forceFill([
                    'provider_reference' => $record['paymentReference'] ?? $record['id'] ?? $payment->provider_reference,
                    'status' => $status,
                    'amount' => $record['collectedAmount'] ?? $payment->amount,
                    'currency' => $record['collectedCurrency'] ?? $payment->currency,
                    'paid_at' => $status === PaymentStatus::Paid ? ($payment->paid_at ?? $timestamp ?? now()) : $payment->paid_at,
                    'failed_at' => $status === PaymentStatus::Failed ? ($payment->failed_at ?? $timestamp ?? now()) : $payment->failed_at,
                    'gateway_payload' => [
                        ...($payment->gateway_payload ?? []),
                        'status_query' => $statusPayload,
                    ],
                    'metadata' => [
                        ...($payment->metadata ?? []),
                        'clickpesa_status' => $record['status'] ?? null,
                        'payment_phone_number' => $record['paymentPhoneNumber'] ?? null,
                        'message' => $record['message'] ?? null,
                    ],
                ])->save();
            } else {
                $payment->forceFill([
                    'gateway_payload' => [
                        ...($payment->gateway_payload ?? []),
                        'status_query' => $statusPayload,
                    ],
                ])->save();
            }
        }

        $payment = $paymentAccess->apply($payment);
        $this->activePayment = $payment->fresh(['course', 'subscription']);

        if ($payment->status === PaymentStatus::Paid) {
            $this->paymentMessage = 'Payment confirmed. Course access is now active.';
        } elseif ($payment->status === PaymentStatus::Failed) {
            $this->paymentMessage = 'Payment failed. You can try again.';
        } else {
            $this->paymentMessage = 'Still pending. If you approved, wait a moment and check again.';
        }
    }

    public function openPlanSubscribe(int $planId): void
    {
        $this->resetSubscribeState();

        $plan = SubscriptionPlan::query()->where('is_active', true)->findOrFail($planId);
        $this->selectedPlan = $plan;

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->phoneNumber = $user->phone ?? '';

        $this->showSubscribeModal = true;
    }

    public function startFreeTrialPlan(int $planId): void
    {
        $plan = SubscriptionPlan::query()->where('is_active', true)->where('is_free_trial', true)->findOrFail($planId);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $trialDays = $plan->trial_days ?: 7;

        // Create trial subscription
        Subscription::query()->create([
            'user_id' => $user->id,
            'course_id' => null,
            'status' => SubscriptionStatus::Active->value,
            'access_starts_at' => now(),
            'access_ends_at' => now()->addDays($trialDays),
            'metadata' => ['type' => 'free_trial', 'plan_id' => $plan->id, 'plan_name' => $plan->name, 'trial_days' => $trialDays],
        ]);

        // Enroll in all published courses
        $courses = Course::query()->published()->get();
        foreach ($courses as $course) {
            $alreadyEnrolled = Enrollment::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->exists();

            if (! $alreadyEnrolled) {
                Enrollment::query()->create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'status' => EnrollmentStatus::Active->value,
                    'enrolled_at' => now(),
                    'access_expires_at' => now()->addDays($trialDays),
                    'progress_percentage' => 0,
                ]);
            }
        }

        $this->redirectRoute('student.courses', navigate: true);
    }

    private function resetSubscribeState(): void
    {
        $this->resetErrorBag();
        $this->selectedCourse = null;
        $this->selectedPlan = null;
        $this->phoneNumber = '';
        $this->selectedNetwork = '';
        $this->activePayment = null;
        $this->paymentMessage = null;
    }

    private function normalizePhoneNumber(string $input): string
    {
        $phone = preg_replace('/\D+/', '', $input) ?? '';

        if (str_starts_with($phone, '0') && strlen($phone) === 10) {
            return '255'.substr($phone, 1);
        }

        if (str_starts_with($phone, '255') && strlen($phone) === 12) {
            return $phone;
        }

        if (str_starts_with($phone, '7') && strlen($phone) === 9) {
            return '255'.$phone;
        }

        return $phone;
    }

    /**
     * @param  array<string, mixed>  $record
     */
    private function timestampFromRecord(array $record): ?\Carbon\CarbonInterface
    {
        $timestamp = $record['updatedAt'] ?? $record['createdAt'] ?? null;

        if (! is_string($timestamp) || $timestamp === '') {
            return null;
        }

        try {
            return Carbon::parse($timestamp);
        } catch (\Throwable) {
            return null;
        }
    }

    public function render()
    {
        $user = auth()->user();

        $enrolledCourseIds = $user->enrollments()->pluck('course_id');

        $courses = Course::query()
            ->published()
            ->when($this->search !== '', function (Builder $query): void {
                $query->where(function (Builder $query): void {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('slug', 'like', "%{$this->search}%");
                });
            })
            ->withCount(['lessons'])
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate($this->perPage);

        $plans = SubscriptionPlan::query()
            ->active()
            ->ordered()
            ->get();

        return view('livewire.student.catalog', [
            'courses' => $courses,
            'enrolledCourseIds' => $enrolledCourseIds,
            'plans' => $plans,
        ]);
    }
}
