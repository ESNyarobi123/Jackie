<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.live-classes.index') }}" wire:navigate>
                Live classes
            </a>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">{{ $liveClass->title }}</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ $liveClass->course->title ?? 'General' }} ·
                {{ ucfirst($liveClass->status?->value ?? (string) $liveClass->status) }}
            </p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.live-classes.edit', $liveClass) }}" wire:navigate>
                Edit
            </flux:button>
            <flux:button variant="ghost" href="{{ route('admin.live-classes.join', $liveClass) }}" wire:navigate>
                Join (iframe)
            </flux:button>
            @if($liveClass->join_url)
                <flux:button variant="primary" href="{{ $liveClass->join_url }}" target="_blank">
                    Open room
                </flux:button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Scheduled</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">
                {{ $liveClass->scheduled_at?->format('M d, Y H:i') ?? '—' }}
            </div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Duration</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $liveClass->duration_minutes }} min</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Room</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)] break-all">{{ $liveClass->room_name }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Created by</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $liveClass->creator->name ?? '—' }}</div>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow">
        <h2 class="text-lg font-semibold text-[var(--color-smoke)]">Join link</h2>
        <div class="mt-3 flex items-center justify-between gap-3 glass-outline rounded-lg p-4">
            <div class="text-sm text-[rgba(30,41,59,0.75)] break-all">{{ $liveClass->join_url ?? '—' }}</div>
            @if($liveClass->join_url)
                <flux:button
                    size="sm"
                    variant="ghost"
                    x-data
                    x-on:click.prevent="navigator.clipboard.writeText(@js($liveClass->join_url))"
                >
                    Copy
                </flux:button>
            @endif
        </div>

        @if($liveClass->description)
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-[var(--color-smoke)]">Description</h3>
                <div class="mt-2 text-sm text-[rgba(30,41,59,0.7)] whitespace-pre-line">{{ $liveClass->description }}</div>
            </div>
        @endif
    </div>
</div>
