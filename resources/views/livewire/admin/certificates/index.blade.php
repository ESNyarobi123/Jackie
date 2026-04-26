<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Certificates</h1>
        <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Issued certificates across courses.</p>
    </div>

    <div class="glass-card p-0 glass-soft-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[rgba(248,249,250,0.55)]">
                    <tr class="text-left text-xs text-[rgba(30,41,59,0.65)] border-b border-[rgba(30,41,59,0.08)]">
                        <th class="px-5 py-3">Certificate</th>
                        <th class="px-5 py-3">Student</th>
                        <th class="px-5 py-3">Course</th>
                        <th class="px-5 py-3">Score</th>
                        <th class="px-5 py-3">Issued</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($certificates as $certificate)
                        <tr class="border-b border-[rgba(30,41,59,0.06)] hover:bg-[rgba(245,130,32,0.04)] transition">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[var(--color-smoke)]">
                                    <a href="{{ route('admin.certificates.show', $certificate) }}" class="hover:underline" wire:navigate>
                                        {{ $certificate->certificate_number }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">{{ $certificate->user->name ?? '—' }}</td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">{{ $certificate->course->title ?? '—' }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                    {{ (int) $certificate->score_percentage }}%
                                </span>
                            </td>
                            <td class="px-5 py-4 text-xs text-[rgba(30,41,59,0.55)]">{{ $certificate->issued_at?->diffForHumans() }}</td>
                            <td class="px-5 py-4 text-right">
                                <flux:button size="sm" variant="ghost" href="{{ route('admin.certificates.show', $certificate) }}" wire:navigate>
                                    View
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-[rgba(30,41,59,0.55)]">
                                No certificates issued yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[rgba(30,41,59,0.06)]">
            {{ $certificates->links() }}
        </div>
    </div>
</div>
