<?php

namespace App\Livewire\Admin\Subscriptions;

use App\Models\Subscription;
use Livewire\Component;

class Show extends Component
{
    public Subscription $subscription;

    public function mount(Subscription $subscription): void
    {
        $this->subscription = $subscription->load([
            'user:id,name,email,phone',
            'course:id,title,slug',
            'payment:id,reference,status,amount,currency,paid_at',
            'enrollment:id,subscription_id,status,enrolled_at',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.subscriptions.show');
    }
}
