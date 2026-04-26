<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Subscriptions</h1>
        <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Manage access windows and status.</p>
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
                        <th class="px-5 py-3">Student</th>
                        <th class="px-5 py-3">Course</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Access</th>
                        <th class="px-5 py-3">Payment</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($subscriptions as $subscription)
                        @php($status = $subscription->status?->value ?? (string) $subscription->status)
                        <tr class="border-b border-[rgba(30,41,59,0.06)] hover:bg-[rgba(245,130,32,0.04)] transition">
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                <div class="font-semibold text-[var(--color-smoke)]">
                                    <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="hover:underline" wire:navigate>
                                        {{ $subscription->user->name ?? '—' }}
                                    </a>
                                </div>
                                <div class="text-xs text-[rgba(30,41,59,0.55)]">{{ $subscription->user->email ?? '—' }}</div>
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $subscription->course->title ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs
                                    {{ $status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ in_array($status, ['expired','cancelled'], true) ? 'bg-gray-100 text-gray-700' : '' }}
                                ">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-xs text-[rgba(30,41,59,0.65)]">
                                <div>{{ $subscription->access_starts_at?->format('M d, Y') ?? '—' }}</div>
                                <div>{{ $subscription->access_ends_at?->format('M d, Y') ?? '—' }}</div>
                            </td>
                            <td class="px-5 py-4 text-xs text-[rgba(30,41,59,0.65)]">
                                @if($subscription->payment)
                                    <div class="font-medium text-[var(--color-smoke)]">{{ $subscription->payment->reference }}</div>
                                    <div>{{ ucfirst($subscription->payment->status?->value ?? (string) $subscription->payment->status) }}</div>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" href="{{ route('admin.subscriptions.edit', $subscription) }}" wire:navigate>
                                        Edit
                                    </flux:button>
                                    <flux:button size="sm" variant="ghost" href="{{ route('admin.subscriptions.show', $subscription) }}" wire:navigate>
                                        View
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-[rgba(30,41,59,0.55)]">
                                No subscriptions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[rgba(30,41,59,0.06)]">
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
