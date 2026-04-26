<?php

namespace App\Livewire\Admin\LiveClasses;

use App\Enums\LiveClassStatus;
use App\Models\Course;
use App\Models\LiveClass;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public int $courseId = 0;
    public int $perPage = 15;

    protected function queryString(): array
    {
        return [
            'search' => ['except' => ''],
            'status' => ['except' => ''],
            'courseId' => ['except' => 0],
            'perPage' => ['except' => 15],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $liveClasses = LiveClass::query()
            ->with(['course:id,title,slug', 'creator:id,name,email'])
            ->when($this->status !== '', fn (Builder $query) => $query->where('status', $this->status))
            ->when($this->courseId > 0, fn (Builder $query) => $query->where('course_id', $this->courseId))
            ->when($this->search !== '', function (Builder $query): void {
                $query->where('title', 'like', "%{$this->search}%");
            })
            ->latest('scheduled_at')
            ->paginate($this->perPage);

        $courses = Course::query()->orderBy('title')->get(['id', 'title']);

        return view('livewire.admin.live-classes.index', [
            'liveClasses' => $liveClasses,
            'courses' => $courses,
            'statusOptions' => collect(LiveClassStatus::cases())->map(fn ($c) => $c->value)->all(),
        ]);
    }
}
