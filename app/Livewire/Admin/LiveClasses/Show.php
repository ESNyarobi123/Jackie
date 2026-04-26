<?php

namespace App\Livewire\Admin\LiveClasses;

use App\Models\LiveClass;
use Livewire\Component;

class Show extends Component
{
    public LiveClass $liveClass;

    public function mount(LiveClass $liveClass): void
    {
        $this->liveClass = $liveClass->load(['course:id,title,slug', 'creator:id,name,email']);
    }

    public function render()
    {
        return view('livewire.admin.live-classes.show');
    }
}
