<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.quizzes.index') }}" wire:navigate>
                Quizzes
            </a>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">{{ $quiz->title }}</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ $quiz->course->title ?? '—' }}
                @if($quiz->lesson)
                    · {{ $quiz->lesson->title }}
                @endif
                · Pass {{ (int) $quiz->pass_percentage }}%
            </p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.quizzes.edit', $quiz) }}" wire:navigate>
                Edit
            </flux:button>
            <flux:button variant="primary" wire:click="openCreateQuestion">
                Add question
            </flux:button>
            <flux:button variant="ghost" wire:click="deleteQuiz" wire:confirm="Delete this quiz?">
                Delete
            </flux:button>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow">
        <div class="flex items-center justify-between gap-3 mb-4">
            <h2 class="text-lg font-semibold text-[var(--color-smoke)]">Questions</h2>
            <div class="text-sm text-[rgba(30,41,59,0.6)]">{{ $quiz->questions->count() }} total</div>
        </div>

        <div class="space-y-3">
            @forelse($quiz->questions->sortBy('sort_order') as $question)
                <div class="glass-outline rounded-lg p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="text-xs text-[rgba(30,41,59,0.55)]">#{{ $question->sort_order }}</div>
                            <div class="font-medium text-[var(--color-smoke)] mt-1">{{ $question->question }}</div>
                            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                                @foreach(($question->options ?? []) as $idx => $opt)
                                    <div class="rounded-md px-3 py-2 {{ (int) $question->correct_option_index === (int) $idx ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-[rgba(30,41,59,0.04)] text-[rgba(30,41,59,0.78)]' }}">
                                        {{ chr(65 + $idx) }}. {{ $opt }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <flux:button size="sm" variant="ghost" wire:click="openEditQuestion({{ $question->id }})">
                                Edit
                            </flux:button>
                            <flux:button size="sm" variant="ghost" wire:click="deleteQuestion({{ $question->id }})" wire:confirm="Delete this question?">
                                Delete
                            </flux:button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-[rgba(30,41,59,0.55)]">
                    No questions yet.
                </div>
            @endforelse
        </div>
    </div>

    <flux:modal wire:model="showQuestionModal">
        <flux:heading>{{ $question_id ? 'Edit question' : 'Add question' }}</flux:heading>

        <div class="mt-4 space-y-4">
            <flux:field>
                <flux:label>Question</flux:label>
                <flux:textarea wire:model.blur="question_text" rows="3" />
                <flux:error name="question_text" />
            </flux:field>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach([0,1,2,3] as $i)
                    <flux:field>
                        <flux:label>Option {{ chr(65 + $i) }}</flux:label>
                        <flux:input wire:model.blur="question_options.{{ $i }}" />
                        <flux:error name="question_options.{{ $i }}" />
                    </flux:field>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <flux:field>
                    <flux:label>Correct option</flux:label>
                    <flux:select wire:model.live="correct_option_index">
                        <option value="0">A</option>
                        <option value="1">B</option>
                        <option value="2">C</option>
                        <option value="3">D</option>
                    </flux:select>
                    <flux:error name="correct_option_index" />
                </flux:field>

                <flux:field>
                    <flux:label>Sort order</flux:label>
                    <flux:input type="number" min="1" wire:model.blur="sort_order" />
                    <flux:error name="sort_order" />
                </flux:field>

                <flux:field>
                    <flux:label>Explanation (optional)</flux:label>
                    <flux:input wire:model.blur="explanation" />
                    <flux:error name="explanation" />
                </flux:field>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <flux:button variant="ghost" wire:click="$set('showQuestionModal', false)">
                Cancel
            </flux:button>
            <flux:button variant="primary" wire:click="saveQuestion" wire:loading.attr="disabled">
                <span wire:loading.remove>Save</span>
                <span wire:loading>Saving…</span>
            </flux:button>
        </div>
    </flux:modal>
</div>
