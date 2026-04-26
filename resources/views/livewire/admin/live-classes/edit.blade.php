<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Edit live class</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1 truncate">{{ $liveClass->title }}</p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.live-classes.show', $liveClass) }}" wire:navigate>
                Cancel
            </flux:button>
            <flux:button variant="primary" wire:click="save" wire:loading.attr="disabled">
                <span wire:loading.remove>Save</span>
                <span wire:loading>Saving…</span>
            </flux:button>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Course</flux:label>
                <flux:select wire:model.live="course_id">
                    @foreach($courses as $course)
                        <option value="{{ $course['id'] }}">{{ $course['title'] }}</option>
                    @endforeach
                </flux:select>
                <flux:error name="course_id" />
            </flux:field>

            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select wire:model.live="status">
                    <option value="draft">Draft</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="live">Live</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Title</flux:label>
            <flux:input wire:model.live="title" />
            <flux:error name="title" />
        </flux:field>

        <flux:field>
            <flux:label>Description</flux:label>
            <flux:textarea wire:model.blur="description" rows="4" />
            <flux:error name="description" />
        </flux:field>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <flux:field>
                <flux:label>Scheduled at</flux:label>
                <flux:input type="datetime-local" wire:model.blur="scheduled_at" />
                <flux:error name="scheduled_at" />
            </flux:field>

            <flux:field>
                <flux:label>Duration (minutes)</flux:label>
                <flux:input type="number" wire:model.blur="duration_minutes" min="15" max="360" />
                <flux:error name="duration_minutes" />
            </flux:field>

            <flux:field>
                <flux:label>Room name</flux:label>
                <flux:input wire:model.blur="room_name" />
                <flux:error name="room_name" />
            </flux:field>
        </div>
    </div>
</div>
