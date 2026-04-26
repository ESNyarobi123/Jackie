<?php

namespace App\Livewire\Admin\SubscriptionPlans;

use App\Models\SubscriptionPlan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public int $perPage = 20;

    public function delete(int $planId): void
    {
        $plan = SubscriptionPlan::query()->findOrFail($planId);
        $plan->delete();

        $this->dispatch('notify', 'Plan deleted.');
    }

    public function toggleActive(int $planId): void
    {
        $plan = SubscriptionPlan::query()->findOrFail($planId);
        $plan->update(['is_active' => ! $plan->is_active]);

        $this->dispatch('notify', 'Plan status updated.');
    }

    public function render()
    {
        $plans = SubscriptionPlan::query()
            ->ordered()
            ->paginate($this->perPage);

        return view('livewire.admin.subscription-plans.index', [
            'plans' => $plans,
        ]);
    }
}
