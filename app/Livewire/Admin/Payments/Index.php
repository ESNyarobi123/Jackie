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
    public int $perPage = 20;

    protected function queryString(): array
    {
        return [
            'status' => ['except' => ''],
            'provider' => ['except' => ''],
            'perPage' => ['except' => 20],
        ];
    }

    public function render()
    {
        $payments = Payment::query()
            ->with(['user:id,name,email', 'course:id,title,slug'])
            ->when($this->status !== '', fn (Builder $query) => $query->where('status', $this->status))
            ->when($this->provider !== '', fn (Builder $query) => $query->where('provider', $this->provider))
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
