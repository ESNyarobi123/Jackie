<?php

namespace App\Livewire\Admin\Students;

use App\Enums\UserRole;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 20;

    protected function queryString(): array
    {
        return [
            'search' => ['except' => ''],
            'perPage' => ['except' => 20],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = User::query()
            ->where('role', UserRole::Student->value)
            ->withCount(['enrollments', 'subscriptions', 'payments'])
            ->when($this->search !== '', function (Builder $query): void {
                $query->where(function (Builder $query): void {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.admin.students.index', [
            'students' => $students,
        ]);
    }
}
