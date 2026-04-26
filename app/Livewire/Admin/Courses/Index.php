<?php

namespace App\Livewire\Admin\Courses;

use App\Enums\CourseStatus;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    /** @var string */
    public string $status = '';

    public int $perPage = 15;

    protected function queryString(): array
    {
        return [
            'search' => ['except' => ''],
            'status' => ['except' => ''],
            'perPage' => ['except' => 15],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public function statusOptions(): array
    {
        return [
            ['value' => '', 'label' => 'All statuses'],
            ...collect(CourseStatus::cases())
                ->map(fn (CourseStatus $status) => ['value' => $status->value, 'label' => ucfirst($status->value)])
                ->all(),
        ];
    }

    public function render()
    {
        $courses = Course::query()
            ->with(['creator:id,name,email'])
            ->withCount(['lessons', 'enrollments', 'subscriptions'])
            ->when($this->status !== '', function (Builder $query): void {
                $query->where('status', $this->status);
            })
            ->when($this->search !== '', function (Builder $query): void {
                $query->where(function (Builder $query): void {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('slug', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.courses.index', [
            'courses' => $courses,
        ]);
    }
}
