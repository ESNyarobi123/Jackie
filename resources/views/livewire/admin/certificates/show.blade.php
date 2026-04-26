<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.certificates.index') }}" wire:navigate>
                Certificates
            </a>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">{{ $certificate->certificate_number }}</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ $certificate->user->name ?? '—' }} · {{ $certificate->course->title ?? '—' }}
            </p>
        </div>

        <div class="shrink-0">
            @if($certificate->pdf_path)
                <flux:button variant="primary" href="{{ \Illuminate\Support\Facades\Storage::url($certificate->pdf_path) }}" target="_blank">
                    Open PDF
                </flux:button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Score</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ (int) $certificate->score_percentage }}%</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Issued</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $certificate->issued_at?->format('M d, Y') }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Student email</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $certificate->user->email ?? '—' }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Course slug</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $certificate->course->slug ?? '—' }}</div>
        </div>
    </div>
</div>
