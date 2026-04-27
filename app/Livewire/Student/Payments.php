<?php

namespace App\Livewire\Student;

use Livewire\Component;

class Payments extends Component
{
    public $subscription = null;

    public $subscriptions = [];

    public $payments = [];

    public $stats = [];

    public $showAllPayments = false;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $user = auth()->user();

        $enrollments = $user->enrollments()
            ->with(['course', 'subscription'])
            ->latest('enrolled_at')
            ->get();

        $this->subscriptions = $enrollments
            ->where('status', 'active')
            ->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'course' => [
                        'title' => $enrollment->course?->title ?? 'Course',
                    ],
                    'access_ends_at' => $enrollment->access_expires_at?->toIso8601String(),
                ];
            })->toArray();

        $this->subscription = ! empty($this->subscriptions);

        $this->payments = $enrollments
            ->filter(fn ($e) => $e->paid_at !== null)
            ->sortByDesc('paid_at')
            ->when(! $this->showAllPayments, fn ($c) => $c->take(5))
            ->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'course' => [
                        'title' => $enrollment->course?->title ?? 'Course Payment',
                    ],
                    'amount' => $enrollment->amount ?? 0,
                    'paid_at' => $enrollment->paid_at?->toIso8601String(),
                    'provider' => $enrollment->payment_provider ?? 'M-Pesa',
                    'status' => $enrollment->payment_status ?? 'completed',
                ];
            })->values()->toArray();

        $totalPaid = $enrollments->sum('amount');
        $thisMonth = $enrollments
            ->where('paid_at', '>=', now()->startOfMonth())
            ->sum('amount');

        $this->stats = [
            'total_paid' => $totalPaid,
            'active_subscriptions' => count($this->subscriptions),
            'total_payments' => $enrollments->where('paid_at', '!=', null)->count(),
            'this_month' => $thisMonth,
        ];
    }

    public function toggleShowAll()
    {
        $this->showAllPayments = ! $this->showAllPayments;
        $this->loadData();
    }

    public function renewSubscription($id)
    {
        $this->dispatch('notify', message: 'Renewal initiated. Redirecting to catalog...');
        $this->redirectRoute('student.catalog', navigate: true);
    }

    public function downloadReceipt($id)
    {
        $this->dispatch('notify', message: 'Receipt download coming soon!');
    }

    public function render()
    {
        return view('livewire.student.payments');
    }
}
