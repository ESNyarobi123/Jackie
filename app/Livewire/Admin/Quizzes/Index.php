<?php

namespace App\Livewire\Admin\Quizzes;

use App\Enums\QuizStatus;
use App\Models\Quiz;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
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

    public function render()
    {
        $quizzes = Quiz::query()
            ->with(['course:id,title,slug', 'lesson:id,title,slug'])
            ->withCount(['questions', 'attempts'])
            ->when($this->status !== '', fn (Builder $q) => $q->where('status', $this->status))
            ->when($this->search !== '', function (Builder $q): void {
                $q->where('title', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.quizzes.index', [
            'quizzes' => $quizzes,
            'statusOptions' => collect(QuizStatus::cases())->map(fn ($c) => $c->value)->all(),
        ]);
    }
}
