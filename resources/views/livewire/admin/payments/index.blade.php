<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Payments</h1>
        <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Track payment status across providers.</p>
    </div>

    <div class="glass-card p-4 glass-soft-shadow">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select wire:model.live="status">
                    <option value="">All statuses</option>
                    @foreach($statusOptions as $value)
                        <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <flux:label>Provider</flux:label>
                <flux:select wire:model.live="provider">
                    <option value="">All providers</option>
                    @foreach($providerOptions as $value)
                        <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <flux:label>Per page</flux:label>
                <flux:select wire:model.live="perPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </flux:select>
            </flux:field>
        </div>
    </div>

    <div class="glass-card p-0 glass-soft-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[rgba(248,249,250,0.55)]">
                    <tr class="text-left text-xs text-[rgba(30,41,59,0.65)] border-b border-[rgba(30,41,59,0.08)]">
                        <th class="px-5 py-3">Reference</th>
                        <th class="px-5 py-3">Student</th>
                        <th class="px-5 py-3">Course</th>
                        <th class="px-5 py-3">Provider</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Amount</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($payments as $payment)
                        @php($status = $payment->status?->value ?? (string) $payment->status)
                        <tr class="border-b border-[rgba(30,41,59,0.06)] hover:bg-[rgba(245,130,32,0.04)] transition">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[var(--color-smoke)]">
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="hover:underline" wire:navigate>
                                        {{ $payment->reference ?? ('#' . $payment->id) }}
                                    </a>
                                </div>
                                <div class="text-xs text-[rgba(30,41,59,0.55)] mt-1">
                                    {{ $payment->paid_at?->diffForHumans() ?? $payment->created_at?->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $payment->user->name ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $payment->course->title ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ ucfirst($payment->provider?->value ?? (string) $payment->provider) }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs
                                    {{ $status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $status === 'failed' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $status === 'refunded' ? 'bg-gray-100 text-gray-700' : '' }}
                                ">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right text-[rgba(30,41,59,0.75)]">
                                {{ $payment->currency }} {{ number_format((float) $payment->amount, 2) }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <flux:button size="sm" variant="ghost" href="{{ route('admin.payments.show', $payment) }}" wire:navigate>
                                    View
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-[rgba(30,41,59,0.55)]">
                                No payments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[rgba(30,41,59,0.06)]">
            {{ $payments->links() }}
        </div>
    </div>
</div>
