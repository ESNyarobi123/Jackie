<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Create quiz</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Attach a quiz to a course (optionally a lesson).</p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.quizzes.index') }}" wire:navigate>
                Back
            </flux:button>
            <flux:button variant="primary" wire:click="save" wire:loading.attr="disabled">
                <span wire:loading.remove>Create</span>
                <span wire:loading>Saving…</span>
            </flux:button>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow space-y-5 max-w-3xl">
        <flux:field>
            <flux:label>Course</flux:label>
            <flux:select wire:model.live="course_id">
                <option value="0">Select course…</option>
                @foreach($courses as $course)
                    <option value="{{ $course['id'] }}">{{ $course['title'] }}</option>
                @endforeach
            </flux:select>
            <flux:error name="course_id" />
        </flux:field>

        <flux:field>
            <flux:label>Lesson (optional)</flux:label>
            <flux:select wire:model.live="lesson_id" @disabled($course_id === 0)>
                <option value="0">No lesson</option>
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson['id'] }}">{{ $lesson['title'] }}</option>
                @endforeach
            </flux:select>
            <flux:error name="lesson_id" />
        </flux:field>

        <flux:field>
            <flux:label>Title</flux:label>
            <flux:input wire:model.live="title" placeholder="e.g. Lesson 6 — Prepositions" />
            <flux:error name="title" />
        </flux:field>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select wire:model.live="status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>

            <flux:field>
                <flux:label>Pass percentage</flux:label>
                <flux:input type="number" min="1" max="100" wire:model.blur="pass_percentage" />
                <flux:error name="pass_percentage" />
            </flux:field>
        </div>
    </div>
</div>
