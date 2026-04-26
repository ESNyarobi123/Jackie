<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.students.index') }}" wire:navigate>
                Students
            </a>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">{{ $student->name }}</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ $student->email }}@if($student->phone) · {{ $student->phone }}@endif
            </p>
        </div>

        <div class="shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.students.index') }}" wire:navigate>
                Back
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Status</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ ucfirst($student->status?->value ?? (string) $student->status) }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Enrollments</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $student->enrollments_count }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Subscriptions</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $student->subscriptions_count }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Payments</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $student->payments_count }}</div>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow">
        <h2 class="text-lg font-semibold text-[var(--color-smoke)]">Account</h2>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="glass-outline rounded-lg p-4">
                <div class="text-xs text-[rgba(30,41,59,0.6)]">Created</div>
                <div class="mt-1 font-medium text-[var(--color-smoke)]">{{ $student->created_at?->format('M d, Y') }}</div>
            </div>
            <div class="glass-outline rounded-lg p-4">
                <div class="text-xs text-[rgba(30,41,59,0.6)]">Email verified</div>
                <div class="mt-1 font-medium text-[var(--color-smoke)]">
                    {{ $student->email_verified_at ? $student->email_verified_at->format('M d, Y') : 'Not verified' }}
                </div>
            </div>
        </div>
    </div>
</div>
