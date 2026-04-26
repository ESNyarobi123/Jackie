<div class="space-y-5">
    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('student.courses') }}" wire:navigate>
                My courses
            </a>
            <h1 class="mt-2 text-2xl font-black tracking-tight text-[var(--color-smoke)]">{{ $lesson->title }}</h1>
            <p class="mt-1 text-sm text-[rgba(30,41,59,0.62)]">{{ $lesson->course?->title }}</p>
        </div>

        <div class="flex gap-2">
            @if($previousLesson)
                <flux:button variant="ghost" href="{{ route('student.lessons.show', $previousLesson) }}" wire:navigate>
                    Previous
                </flux:button>
            @endif
            @if($nextLesson)
                <flux:button variant="ghost" href="{{ route('student.lessons.show', $nextLesson) }}" wire:navigate>
                    Next
                </flux:button>
            @endif
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_320px]">
        <div class="glass-card overflow-hidden p-0 glass-soft-shadow">
            @if($this->isVideo && $this->mediaUrl)
                <video class="aspect-video w-full bg-black" controls controlsList="nodownload" preload="metadata">
                    <source src="{{ $this->mediaUrl }}">
                </video>
            @elseif($this->mediaUrl)
                <div class="flex min-h-[360px] items-center justify-center p-8 text-center">
                    <div>
                        <div class="mx-auto mb-4 h-16 w-16 rounded-2xl bg-[rgba(245,130,32,0.12)]"></div>
                        <h2 class="text-xl font-black text-[var(--color-smoke)]">Resource ready</h2>
                        <a class="btn-premium mt-5 inline-flex" href="{{ $this->mediaUrl }}" target="_blank">
                            Open
                        </a>
                    </div>
                </div>
            @else
                <div class="flex min-h-[360px] items-center justify-center p-8 text-center">
                    <div>
                        <div class="mx-auto mb-4 h-16 w-16 rounded-2xl bg-[rgba(30,41,59,0.08)]"></div>
                        <h2 class="text-xl font-black text-[var(--color-smoke)]">Media pending</h2>
                        <p class="mt-2 text-sm text-[rgba(30,41,59,0.62)]">Admin has not attached playable media yet.</p>
                    </div>
                </div>
            @endif
        </div>

        <aside class="space-y-4">
            <div class="glass-card p-5 glass-soft-shadow">
                <div class="text-xs text-[rgba(30,41,59,0.55)]">Progress</div>
                <div class="mt-2 text-3xl font-black text-[var(--color-terra)]">{{ $enrollment->progress_percentage }}%</div>
                <div class="mt-3 h-2 rounded-full bg-[rgba(30,41,59,0.08)]">
                    <div class="h-full rounded-full bg-[var(--color-terra)]" style="width: {{ $enrollment->progress_percentage }}%"></div>
                </div>
            </div>

            <div class="glass-card p-5 glass-soft-shadow">
                <div class="text-xs text-[rgba(30,41,59,0.55)]">Lesson</div>
                <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ ucfirst($lesson->content_type?->value ?? 'lesson') }}</div>
                <div class="mt-1 text-sm text-[rgba(30,41,59,0.62)]">
                    {{ $lesson->duration_seconds > 0 ? floor($lesson->duration_seconds / 60).' min' : 'Self paced' }}
                </div>
            </div>

            <flux:button variant="primary" class="w-full" wire:click="markComplete">
                Complete lesson
            </flux:button>
        </aside>
    </div>

    @if($lesson->summary)
        <div class="glass-card p-5 glass-soft-shadow">
            <h2 class="font-bold text-[var(--color-smoke)]">Notes</h2>
            <p class="mt-2 text-sm text-[rgba(30,41,59,0.68)]">{{ $lesson->summary }}</p>
        </div>
    @endif
</div>
