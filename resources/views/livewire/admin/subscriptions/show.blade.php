<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.subscriptions.index') }}" wire:navigate>
                Subscriptions
            </a>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">
                {{ $subscription->user->name ?? 'Student' }} · {{ $subscription->course->title ?? 'Course' }}
            </h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ ucfirst($subscription->status?->value ?? (string) $subscription->status) }}
            </p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.subscriptions.edit', $subscription) }}" wire:navigate>
                Edit
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Access starts</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $subscription->access_starts_at?->format('M d, Y') ?? '—' }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Access ends</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $subscription->access_ends_at?->format('M d, Y') ?? '—' }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Payment</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">
                {{ $subscription->payment?->reference ?? '—' }}
            </div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Enrollment</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">
                {{ $subscription->enrollment?->status?->value ?? $subscription->enrollment?->status ?? '—' }}
            </div>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow">
        <h2 class="text-lg font-semibold text-[var(--color-smoke)]">Student</h2>
        <div class="mt-3 text-sm text-[rgba(30,41,59,0.75)]">
            <div><span class="font-medium">Email:</span> {{ $subscription->user->email ?? '—' }}</div>
            <div><span class="font-medium">Phone:</span> {{ $subscription->user->phone ?? '—' }}</div>
        </div>
    </div>
</div>
