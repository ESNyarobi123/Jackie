<?php

namespace App\Livewire\Admin\Subscriptions;

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Subscription $subscription;

    public string $status = 'pending';
    public ?string $access_starts_at = null;
    public ?string $access_ends_at = null;

    public function mount(Subscription $subscription): void
    {
        $this->subscription = $subscription;

        $this->status = $subscription->status?->value ?? (string) $subscription->status;
        $this->access_starts_at = $subscription->access_starts_at?->format('Y-m-d\TH:i');
        $this->access_ends_at = $subscription->access_ends_at?->format('Y-m-d\TH:i');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(SubscriptionStatus::class)],
            'access_starts_at' => ['nullable', 'date'],
            'access_ends_at' => ['nullable', 'date', 'after:access_starts_at'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $this->subscription->update([
            'status' => $validated['status'],
            'access_starts_at' => $validated['access_starts_at'],
            'access_ends_at' => $validated['access_ends_at'],
        ]);

        $this->redirectRoute('admin.subscriptions.show', $this->subscription->fresh(), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.subscriptions.edit');
    }
}
