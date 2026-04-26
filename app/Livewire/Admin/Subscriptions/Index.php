<?php

namespace App\Livewire\Admin\Subscriptions;

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public string $status = '';
    public int $perPage = 20;

    protected function queryString(): array
    {
        return [
            'status' => ['except' => ''],
            'perPage' => ['except' => 20],
        ];
    }

    public function render()
    {
        $subscriptions = Subscription::query()
            ->with(['user:id,name,email', 'course:id,title,slug', 'payment:id,reference,status,amount,currency'])
            ->when($this->status !== '', fn (Builder $query) => $query->where('status', $this->status))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.subscriptions.index', [
            'subscriptions' => $subscriptions,
            'statusOptions' => collect(SubscriptionStatus::cases())->map(fn ($c) => $c->value)->all(),
        ]);
    }
}
