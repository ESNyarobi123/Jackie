<?php

namespace App\Livewire\Admin\Quizzes;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Show extends Component
{
    public Quiz $quiz;

    public bool $showQuestionModal = false;

    public int $question_id = 0;
    public string $question_text = '';

    /** @var array<int, string> */
    public array $question_options = ['', '', '', ''];

    public int $correct_option_index = 0;
    public ?string $explanation = null;
    public int $sort_order = 1;

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz->load(['course:id,title,slug', 'lesson:id,title,slug', 'questions']);
    }

    public function openCreateQuestion(): void
    {
        $this->resetQuestionForm();
        $this->showQuestionModal = true;
    }

    public function openEditQuestion(int $questionId): void
    {
        $question = QuizQuestion::query()
            ->where('quiz_id', $this->quiz->id)
            ->findOrFail($questionId);

        $this->question_id = $question->id;
        $this->question_text = (string) $question->question;
        $this->question_options = array_values($question->options ?? []);
        $this->question_options = array_pad($this->question_options, 4, '');
        $this->correct_option_index = (int) $question->correct_option_index;
        $this->explanation = $question->explanation;
        $this->sort_order = (int) $question->sort_order;

        $this->showQuestionModal = true;
    }

    /**
     * @return array<string, mixed>
     */
    protected function questionRules(): array
    {
        return [
            'question_text' => ['required', 'string', 'min:3'],
            'question_options' => ['required', 'array', 'min:2'],
            'question_options.*' => ['required', 'string', 'min:1', 'max:255'],
            'correct_option_index' => ['required', 'integer', 'min:0', 'max:3'],
            'explanation' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:1'],
        ];
    }

    public function saveQuestion(): void
    {
        $validated = $this->validate($this->questionRules());

        $options = array_values(array_map('trim', $validated['question_options']));

        QuizQuestion::query()->updateOrCreate(
            ['id' => $this->question_id, 'quiz_id' => $this->quiz->id],
            [
                'quiz_id' => $this->quiz->id,
                'question' => $validated['question_text'],
                'options' => $options,
                'correct_option_index' => $validated['correct_option_index'],
                'explanation' => $validated['explanation'],
                'sort_order' => $validated['sort_order'],
            ],
        );

        $this->quiz = $this->quiz->fresh()->load(['course:id,title,slug', 'lesson:id,title,slug', 'questions']);
        $this->showQuestionModal = false;
        $this->resetQuestionForm();
    }

    public function deleteQuestion(int $questionId): void
    {
        QuizQuestion::query()
            ->where('quiz_id', $this->quiz->id)
            ->whereKey($questionId)
            ->delete();

        $this->quiz = $this->quiz->fresh()->load(['course:id,title,slug', 'lesson:id,title,slug', 'questions']);
    }

    public function deleteQuiz(): void
    {
        $this->quiz->delete();

        $this->redirectRoute('admin.quizzes.index', navigate: true);
    }

    private function resetQuestionForm(): void
    {
        $this->question_id = 0;
        $this->question_text = '';
        $this->question_options = ['', '', '', ''];
        $this->correct_option_index = 0;
        $this->explanation = null;
        $this->sort_order = max(1, (int) $this->quiz->questions()->max('sort_order') + 1);
    }

    public function render()
    {
        return view('livewire.admin.quizzes.show');
    }
}
