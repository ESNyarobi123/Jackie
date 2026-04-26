<?php

namespace App\Livewire\Student;

use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Livewire\Component;

class QuizTake extends Component
{
    public Quiz $quiz;

    /** @var array<int, int> */
    public array $answers = [];

    public bool $submitted = false;
    public int $score = 0;
    public bool $passed = false;

    public ?QuizAttempt $attempt = null;

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz->load(['course', 'lesson', 'questions']);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $hasAccess = Enrollment::query()
            ->where('user_id', $user->id)
            ->where('course_id', $this->quiz->course_id)
            ->whereIn('status', ['active', 'completed'])
            ->exists();

        abort_unless($hasAccess, 403);

        $this->attempt = QuizAttempt::query()
            ->where('quiz_id', $this->quiz->id)
            ->where('user_id', $user->id)
            ->whereNull('completed_at')
            ->latest()
            ->first();

        if (! $this->attempt) {
            $this->attempt = QuizAttempt::query()->create([
                'quiz_id' => $this->quiz->id,
                'user_id' => $user->id,
                'score_percentage' => 0,
                'passed' => false,
                'answers' => [],
                'started_at' => now(),
            ]);
        }
    }

    public function submit(): void
    {
        $questions = $this->quiz->questions->sortBy('sort_order')->values();

        foreach ($questions as $question) {
            if (! array_key_exists($question->id, $this->answers)) {
                $this->addError('answers', 'Please answer all questions.');

                return;
            }
        }

        $correct = 0;
        foreach ($questions as $question) {
            $selected = (int) ($this->answers[$question->id] ?? -1);
            if ($selected === (int) $question->correct_option_index) {
                $correct++;
            }
        }

        $total = max(1, $questions->count());
        $this->score = (int) round(($correct / $total) * 100);
        $this->passed = $this->score >= (int) $this->quiz->pass_percentage;
        $this->submitted = true;

        if ($this->attempt) {
            $this->attempt->update([
                'score_percentage' => $this->score,
                'passed' => $this->passed,
                'answers' => $this->answers,
                'completed_at' => now(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.student.quiz-take', [
            'questions' => $this->quiz->questions->sortBy('sort_order'),
        ]);
    }
}
