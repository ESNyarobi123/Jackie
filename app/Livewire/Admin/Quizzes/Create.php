<?php

namespace App\Livewire\Admin\Quizzes;

use App\Enums\QuizStatus;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public int $course_id = 0;
    public int $lesson_id = 0;
    public string $title = '';
    public string $status = 'draft';
    public int $pass_percentage = 80;

    /** @var array<int, array{id:int,title:string}> */
    public array $courses = [];

    /** @var array<int, array{id:int,title:string}> */
    public array $lessons = [];

    public function mount(): void
    {
        $this->courses = Course::query()->orderBy('title')->get(['id', 'title'])->toArray();
    }

    public function updatedCourseId(): void
    {
        $this->lesson_id = 0;
        $this->lessons = Lesson::query()
            ->where('course_id', $this->course_id)
            ->orderBy('sort_order')
            ->get(['id', 'title'])
            ->toArray();
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'lesson_id' => ['nullable', 'integer', 'exists:lessons,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::enum(QuizStatus::class)],
            'pass_percentage' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $quiz = Quiz::query()->create([
            'course_id' => $validated['course_id'],
            'lesson_id' => $validated['lesson_id'] ?: null,
            'title' => $validated['title'],
            'status' => $validated['status'],
            'pass_percentage' => $validated['pass_percentage'],
            'published_at' => $validated['status'] === QuizStatus::Published->value ? now() : null,
        ]);

        $this->redirectRoute('admin.quizzes.show', $quiz, navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.quizzes.create');
    }
}
