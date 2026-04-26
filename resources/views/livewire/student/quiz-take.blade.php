<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-2xl font-bold text-(--color-smoke)">{{ $quiz->title }}</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ $quiz->course->title ?? 'Course' }}
                @if($quiz->lesson)
                    · {{ $quiz->lesson->title }}
                @endif
                · Pass {{ (int) $quiz->pass_percentage }}%
            </p>
        </div>

        <div class="shrink-0">
            <a href="{{ route('student.tasks') }}" class="btn-glass-outline text-sm">
                Back
            </a>
        </div>
    </div>

    @if($submitted)
        <div class="glass-card p-6 glass-soft-shadow">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <div class="text-sm text-[rgba(30,41,59,0.65)]">Your result</div>
                    <div class="text-3xl font-bold mt-1 {{ $passed ? 'text-green-600' : 'text-amber-600' }}">
                        {{ $score }}%
                    </div>
                    <div class="text-sm mt-1 text-[rgba(30,41,59,0.65)]">
                        {{ $passed ? 'Passed' : 'Not passed yet' }}
                    </div>
                </div>
                <div class="px-4 py-2 rounded-lg {{ $passed ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">
                    {{ $passed ? '✅ Great job' : '⏳ Try again later' }}
                </div>
            </div>
        </div>
    @endif

    <div class="glass-card p-6 glass-soft-shadow">
        <div class="space-y-5">
            @error('answers')
                <div class="glass-outline rounded-lg p-3 text-sm text-amber-700 bg-amber-50">
                    {{ $message }}
                </div>
            @enderror

            @foreach($questions as $question)
                <div class="glass-outline rounded-lg p-4">
                    <div class="text-xs text-[rgba(30,41,59,0.55)]">Question {{ $loop->iteration }}</div>
                    <div class="font-semibold text-(--color-smoke) mt-1">{{ $question->question }}</div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach(($question->options ?? []) as $idx => $opt)
                            <label class="flex items-start gap-3 p-3 rounded-lg cursor-pointer border border-[rgba(30,41,59,0.08)] hover:bg-[rgba(245,130,32,0.04)] transition">
                                <input
                                    type="radio"
                                    name="q{{ $question->id }}"
                                    value="{{ $idx }}"
                                    wire:model="answers.{{ $question->id }}"
                                    class="mt-1"
                                    @disabled($submitted)
                                />
                                <div class="text-sm text-[rgba(30,41,59,0.78)]">
                                    <span class="font-semibold">{{ chr(65 + $idx) }}.</span>
                                    {{ $opt }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="pt-2 flex justify-end">
                @if(!$submitted)
                    <button class="btn-premium text-sm" wire:click="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove>Submit</span>
                        <span wire:loading>Submitting…</span>
                    </button>
                @else
                    <a class="btn-glass-outline text-sm" href="{{ route('student.courses') }}">
                        Continue learning
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
