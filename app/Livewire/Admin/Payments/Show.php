<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
use Livewire\Component;

class Show extends Component
{
    public Payment $payment;

    public function mount(Payment $payment): void
    {
        $this->payment = $payment->load(['user:id,name,email', 'course:id,title,slug', 'subscription.course:id,title,slug']);
    }

    public function render()
    {
        return view('livewire.admin.payments.show');
    }
}
