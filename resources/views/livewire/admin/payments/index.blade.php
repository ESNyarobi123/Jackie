<div class="space-y-8">
    <style>
        @keyframes payFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes payShimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .pay-fade-up { animation: payFadeUp .4s ease-out both; }
        .pay-fade-up-1 { animation-delay: .05s; }
        .pay-fade-up-2 { animation-delay: .1s; }
        .pay-fade-up-3 { animation-delay: .15s; }
        .pay-fade-up-4 { animation-delay: .2s; }
        .pay-fade-up-5 { animation-delay: .25s; }
        .pay-shimmer { background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.06) 50%, transparent 100%); background-size: 200% 100%; animation: payShimmer 3s ease-in-out infinite; }
        .pay-row { transition: all .2s ease; }
        .pay-row:hover { background: rgba(245,130,32,.03); }
        .pay-card { transition: transform .25s ease, box-shadow .25s ease; }
        .pay-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,.08); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(34,197,94,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(139,92,246,.3) 0%, transparent 40%);"></div>
        <div class="absolute inset-0 pay-shimmer"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(34,197,94,.15); color: #22c55e; border: 1px solid rgba(34,197,94,.25);">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    Payment History
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">Payments</h1>
                <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Track payment status across providers. Full history with all statuses.</p>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #3b82f6, rgba(59,130,246,.1));"></div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(59,130,246,.08);">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
            </div>
            <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Total</div>
            <div class="text-2xl font-black text-blue-600">{{ $stats['total'] }}</div>
        </div>
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #22c55e, rgba(34,197,94,.1));"></div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(34,197,94,.08);">
                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Paid</div>
            <div class="text-2xl font-black text-green-600">{{ $stats['paid'] }}</div>
        </div>
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #f59e0b, rgba(245,158,11,.1));"></div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(245,158,11,.08);">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Pending</div>
            <div class="text-2xl font-black text-amber-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #ef4444, rgba(239,68,68,.1));"></div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(239,68,68,.08);">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </div>
            <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Failed</div>
            <div class="text-2xl font-black text-red-600">{{ $stats['failed'] }}</div>
        </div>
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #8b5cf6, rgba(139,92,246,.1));"></div>
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(139,92,246,.08);">
                <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
            </div>
            <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Revenue</div>
            <div class="text-lg font-black text-purple-600">TSh {{ number_format($stats['total_revenue']) }}</div>
            <div class="text-[.5rem] text-[rgba(30,41,59,0.3)] mt-0.5">This month: TSh {{ number_format($stats['this_month']) }}</div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[rgba(30,41,59,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by reference, student, or course..." class="w-full pl-10 pr-4 py-3 rounded-xl text-sm border-0 bg-[rgba(30,41,59,0.04)] focus:bg-[rgba(30,41,59,0.06)] focus:ring-2 focus:ring-[rgba(34,197,94,.3)] transition-all outline-none" />
                </div>
            </div>
            <div>
                <select wire:model.live="status" class="w-full px-4 py-3 rounded-xl text-sm border-0 bg-[rgba(30,41,59,0.04)] focus:bg-[rgba(30,41,59,0.06)] focus:ring-2 focus:ring-[rgba(34,197,94,.3)] transition-all outline-none cursor-pointer">
                    <option value="">All statuses</option>
                    @foreach($statusOptions as $value)
                        <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="provider" class="w-full px-4 py-3 rounded-xl text-sm border-0 bg-[rgba(30,41,59,0.04)] focus:bg-[rgba(30,41,59,0.06)] focus:ring-2 focus:ring-[rgba(34,197,94,.3)] transition-all outline-none cursor-pointer">
                    <option value="">All providers</option>
                    @foreach($providerOptions as $value)
                        <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #22c55e, #f59e0b, #ef4444, #8b5cf6);"></div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-[.5625rem] text-[rgba(30,41,59,0.4)] uppercase tracking-wider border-b" style="border-color: rgba(30,41,59,.06); background: rgba(248,249,250,.4);">
                        <th class="px-5 py-3.5 font-semibold">Reference</th>
                        <th class="px-5 py-3.5 font-semibold">Student</th>
                        <th class="px-5 py-3.5 font-semibold">Course</th>
                        <th class="px-5 py-3.5 font-semibold">Provider</th>
                        <th class="px-5 py-3.5 font-semibold">Status</th>
                        <th class="px-5 py-3.5 font-semibold text-right">Amount</th>
                        <th class="px-5 py-3.5 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($payments as $payment)
                        @php
                            $status = $payment->status?->value ?? 'pending';
                            $statusStyles = [
                                'paid' => ['bg' => 'rgba(34,197,94,.08)', 'text' => '#16a34a', 'dot' => '#22c55e', 'icon' => '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'],
                                'pending' => ['bg' => 'rgba(245,158,11,.08)', 'text' => '#b45309', 'dot' => '#f59e0b', 'icon' => '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'],
                                'failed' => ['bg' => 'rgba(239,68,68,.08)', 'text' => '#dc2626', 'dot' => '#ef4444', 'icon' => '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>'],
                                'refunded' => ['bg' => 'rgba(139,92,246,.08)', 'text' => '#7c3aed', 'dot' => '#8b5cf6', 'icon' => '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>'],
                            ];
                            $ss = $statusStyles[$status] ?? $statusStyles['pending'];
                            $provider = $payment->provider?->value ?? 'unknown';
                            $providerColors = [
                                'mpesa' => ['bg' => 'rgba(0,161,93,.08)', 'text' => '#00a15d'],
                                'airtel' => ['bg' => 'rgba(220,38,38,.08)', 'text' => '#dc2626'],
                                'tigo' => ['bg' => 'rgba(59,130,246,.08)', 'text' => '#2563eb'],
                                'card' => ['bg' => 'rgba(139,92,246,.08)', 'text' => '#7c3aed'],
                            ];
                            $pc = $providerColors[$provider] ?? ['bg' => 'rgba(30,41,59,.04)', 'text' => 'rgba(30,41,59,.5)'];
                        @endphp
                        <tr class="pay-row border-b" style="border-color: rgba(30,41,59,.04);">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background: {{ $ss['bg'] }};">
                                        {!! $ss['icon'] !!}
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.payments.show', $payment) }}" wire:navigate class="font-bold text-sm text-(--color-smoke) hover:underline">{{ $payment->reference ?? ('#' . $payment->id) }}</a>
                                        <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)] flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                            {{ $payment->paid_at?->diffForHumans() ?? $payment->created_at?->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 text-[.5rem] font-bold text-white" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                                        {{ strtoupper(substr($payment->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="text-[.6875rem] font-semibold text-(--color-smoke)">{{ $payment->user->name ?? '—' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[.6875rem] text-[rgba(30,41,59,0.6)]">{{ $payment->course->title ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: {{ $pc['bg'] }}; color: {{ $pc['text'] }};">
                                    {{ ucfirst($provider) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: {{ $ss['bg'] }}; color: {{ $ss['text'] }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $ss['dot'] }};"></span>
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="text-sm font-black text-(--color-smoke)">{{ $payment->currency }} {{ number_format((float) $payment->amount, 2) }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.payments.show', $payment) }}" wire:navigate class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: rgba(59,130,246,.08); color: #2563eb;">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(34,197,94,.06);">
                                    <svg class="w-8 h-8 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                </div>
                                <h3 class="font-bold text-base text-(--color-smoke) mb-1">No Payments Found</h3>
                                <p class="text-sm text-[rgba(30,41,59,0.5)]">Try adjusting your filters</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="p-4 border-t" style="border-color: rgba(30,41,59,.06);">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
