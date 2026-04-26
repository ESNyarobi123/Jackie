<?php

namespace App\Livewire\Admin\Students;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $student;

    public function mount(User $student): void
    {
        abort_unless($student->isStudent(), 404);

        $this->student = $student->loadCount(['enrollments', 'subscriptions', 'payments']);
    }

    public function render()
    {
        return view('livewire.admin.students.show');
    }
}
