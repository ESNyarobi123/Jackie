<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.users.index') }}" wire:navigate>
                Users
            </a>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">{{ $user->name }}</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ $user->email }}@if($user->phone) · {{ $user->phone }}@endif
            </p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.users.edit', $user) }}" wire:navigate>
                Edit
            </flux:button>
            <flux:button
                variant="ghost"
                wire:click="delete"
                wire:confirm="Delete this user? This cannot be undone."
                class="text-red-600"
            >
                Delete
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Role</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ ucfirst($user->role?->value ?? (string) $user->role) }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Status</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ ucfirst($user->status?->value ?? (string) $user->status) }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Subscriptions</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $user->subscriptions_count }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Payments</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $user->payments_count }}</div>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow">
        <h2 class="text-lg font-semibold text-[var(--color-smoke)]">Activity</h2>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="glass-outline rounded-lg p-4">
                <div class="text-xs text-[rgba(30,41,59,0.6)]">Enrollments</div>
                <div class="mt-1 font-medium text-[var(--color-smoke)]">{{ $user->enrollments_count }}</div>
            </div>
            <div class="glass-outline rounded-lg p-4">
                <div class="text-xs text-[rgba(30,41,59,0.6)]">Admin created courses</div>
                <div class="mt-1 font-medium text-[var(--color-smoke)]">{{ $user->created_courses_count }}</div>
            </div>
            <div class="glass-outline rounded-lg p-4">
                <div class="text-xs text-[rgba(30,41,59,0.6)]">Admin created live classes</div>
                <div class="mt-1 font-medium text-[var(--color-smoke)]">{{ $user->created_live_classes_count }}</div>
            </div>
        </div>
    </div>
</div>
