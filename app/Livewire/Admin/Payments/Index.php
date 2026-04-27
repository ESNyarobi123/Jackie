<?php

namespace App\Livewire\Admin\Payments;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public string $status = '';

    public string $provider = '';

    public string $search = '';

    public int $perPage = 20;

    public array $stats = [];

    protected function queryString(): array
    {
        return [
            'status' => ['except' => ''],
            'provider' => ['except' => ''],
            'search' => ['except' => ''],
            'perPage' => ['except' => 20],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedProvider(): void
    {
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->calculateStats();
    }

    public function calculateStats(): void
    {
        $this->stats = [
            'total' => Payment::count(),
            'paid' => Payment::where('status', PaymentStatus::Paid)->count(),
            'pending' => Payment::where('status', PaymentStatus::Pending)->count(),
            'failed' => Payment::where('status', PaymentStatus::Failed)->count(),
            'refunded' => Payment::where('status', PaymentStatus::Refunded)->count(),
            'total_revenue' => Payment::where('status', PaymentStatus::Paid)->sum('amount') ?? 0,
            'this_month' => Payment::where('status', PaymentStatus::Paid)
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount') ?? 0,
        ];
    }

    public function render()
    {
        $payments = Payment::query()
            ->with(['user:id,name,email', 'course:id,title,slug'])
            ->when($this->status !== '', fn (Builder $query) => $query->where('status', $this->status))
            ->when($this->provider !== '', fn (Builder $query) => $query->where('provider', $this->provider))
            ->when($this->search !== '', function (Builder $query): void {
                $query->where(function (Builder $query): void {
                    $query->where('reference', 'like', "%{$this->search}%")
                        ->orWhereHas('user', fn (Builder $q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%"))
                        ->orWhereHas('course', fn (Builder $q) => $q->where('title', 'like', "%{$this->search}%"));
                });
            })
            ->latest('paid_at')
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.payments.index', [
            'payments' => $payments,
            'statusOptions' => collect(PaymentStatus::cases())->map(fn ($c) => $c->value)->all(),
            'providerOptions' => collect(PaymentProvider::cases())->map(fn ($c) => $c->value)->all(),
        ]);
    }
}
