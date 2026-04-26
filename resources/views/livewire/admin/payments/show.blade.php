<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.payments.index') }}" wire:navigate>
                Payments
            </a>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">
                {{ $payment->reference ?? ('Payment #' . $payment->id) }}
            </h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ ucfirst($payment->provider?->value ?? (string) $payment->provider) }} ·
                {{ ucfirst($payment->status?->value ?? (string) $payment->status) }}
            </p>
        </div>

        <div class="shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.payments.index') }}" wire:navigate>
                Back
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Amount</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">
                {{ $payment->currency }} {{ number_format((float) $payment->amount, 2) }}
            </div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Paid at</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">
                {{ $payment->paid_at?->format('M d, Y H:i') ?? '—' }}
            </div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Student</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">
                {{ $payment->user->name ?? '—' }}
            </div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Course</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">
                {{ $payment->course->title ?? $payment->subscription?->course?->title ?? '—' }}
            </div>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow">
        <h2 class="text-lg font-semibold text-[var(--color-smoke)]">Details</h2>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="glass-outline rounded-lg p-4">
                <div class="text-xs text-[rgba(30,41,59,0.6)]">Provider reference</div>
                <div class="mt-1 font-medium text-[var(--color-smoke)] break-all">
                    {{ $payment->provider_reference ?: '—' }}
                </div>
            </div>
            <div class="glass-outline rounded-lg p-4">
                <div class="text-xs text-[rgba(30,41,59,0.6)]">Description</div>
                <div class="mt-1 font-medium text-[var(--color-smoke)]">
                    {{ $payment->description ?: '—' }}
                </div>
            </div>
        </div>
    </div>
</div>
