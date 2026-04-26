<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user->loadCount(['enrollments', 'subscriptions', 'payments', 'createdCourses', 'createdLiveClasses']);
    }

    public function delete(): void
    {
        if ((int) auth()->id() === (int) $this->user->id) {
            abort(422);
        }

        $this->user->delete();

        $this->redirectRoute('admin.users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.users.show');
    }
}
