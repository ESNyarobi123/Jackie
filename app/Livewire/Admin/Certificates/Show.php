<?php

namespace App\Livewire\Admin\Certificates;

use App\Models\Certificate;
use Livewire\Component;

class Show extends Component
{
    public Certificate $certificate;

    public function mount(Certificate $certificate): void
    {
        $this->certificate = $certificate->load(['user:id,name,email', 'course:id,title,slug']);
    }

    public function render()
    {
        return view('livewire.admin.certificates.show');
    }
}
