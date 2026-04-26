<div class="space-y-6">
    <!-- Hero Subscription Card -->
    <div class="relative overflow-hidden rounded-2xl" style="background: linear-gradient(135deg, rgba(245,130,32,.12), rgba(245,130,32,.04));">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, var(--color-terra) 0%, transparent 50%), radial-gradient(circle at 80% 20%, var(--color-terra) 0%, transparent 40%);"></div>
        <div class="relative p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 rounded-full {{ $subscription ? 'bg-green-500' : 'bg-red-400' }} animate-pulse"></div>
                        <span class="text-xs font-bold uppercase tracking-wider {{ $subscription ? 'text-green-600' : 'text-red-500' }}">
                            {{ $subscription ? 'Active Plan' : 'No Active Plan' }}
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[var(--color-smoke)]">
                        {{ $subscription ? 'Your Subscription' : 'Start Learning Today' }}
                    </h1>
                    <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                        {{ $subscription ? 'Access all your enrolled courses and live classes' : 'Subscribe to unlock courses, live classes, and certificates' }}
                    </p>
                </div>
                @if(!$subscription)
                    <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-sm transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.3);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                        Choose a Plan
                    </a>
                @else
                    <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm glass-outline hover:bg-[rgba(245,130,32,0.08)] transition">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Renew
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(245,130,32,.1);">💰</div>
                <div>
                    <div class="text-lg font-bold text-[var(--color-terra)]">TSh {{ number_format($stats['total_paid'] ?? 0, 0) }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">Total Paid</div>
                </div>
            </div>
        </div>
        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(34,197,94,.1);">✅</div>
                <div>
                    <div class="text-lg font-bold text-green-600">{{ $stats['active_subscriptions'] ?? 0 }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">Active</div>
                </div>
            </div>
        </div>
        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(59,130,246,.1);">📋</div>
                <div>
                    <div class="text-lg font-bold text-blue-600">{{ $stats['total_payments'] ?? 0 }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">Payments</div>
                </div>
            </div>
        </div>
        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(139,92,246,.1);">📅</div>
                <div>
                    <div class="text-lg font-bold text-purple-600">TSh {{ number_format($stats['this_month'] ?? 0, 0) }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">This Month</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Subscriptions -->
    <div class="glass-card p-5 rounded-xl glass-soft-shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-[var(--color-smoke)]">Active Subscriptions</h2>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $subscription ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-500' }}">
                {{ $subscription ? '● Active' : '○ None' }}
            </span>
        </div>
        @forelse($subscriptions as $sub)
            <div class="mb-3 pb-3 border-b border-[rgba(30,41,59,0.06)] last:border-0 last:mb-0 last:pb-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, rgba(245,130,32,.15), rgba(245,130,32,.05));">📚</div>
                        <div>
                            <h3 class="font-semibold text-sm text-[var(--color-smoke)]">{{ $sub['course']['title'] ?? 'Course' }}</h3>
                            <p class="text-xs text-[rgba(30,41,59,0.5)]">
                                @isset($sub['access_ends_at'])
                                    Expires {{ \Carbon\Carbon::parse($sub['access_ends_at'])->format('M d, Y') }}
                                    <span class="text-[var(--color-terra)]">({{ \Carbon\Carbon::parse($sub['access_ends_at'])->diffForHumans() }})</span>
                                @else
                                    Active subscription
                                @endif
                            </p>
                        </div>
                    </div>
                    <button wire:click="renewSubscription({{ $sub['id'] }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold glass-outline hover:bg-[rgba(245,130,32,0.08)] transition">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Renew
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center text-2xl" style="background: rgba(245,130,32,.08);">📭</div>
                <p class="text-sm text-[rgba(30,41,59,0.5)] mb-3">No active subscriptions</p>
                <a href="{{ route('student.catalog') }}" class="text-sm font-semibold text-[var(--color-terra)] hover:underline">Browse courses →</a>
            </div>
        @endforelse
    </div>

    <!-- Payment History -->
    <div class="glass-card p-5 rounded-xl glass-soft-shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-[var(--color-smoke)]">Payment History</h2>
            @if(($stats['total_payments'] ?? 0) > 5)
                <button wire:click="toggleShowAll" class="text-xs font-semibold text-[var(--color-terra)] hover:underline">
                    {{ $showAllPayments ? 'Show Less' : 'View All' }}
                </button>
            @endif
        </div>
        <div class="space-y-2">
            @forelse($payments as $payment)
                <div class="flex items-center justify-between p-3 rounded-xl bg-[rgba(255,255,255,0.5)] hover:bg-[rgba(255,255,255,0.8)] transition">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center text-sm" style="background: rgba(245,130,32,.08);">💳</div>
                        <div>
                            <h4 class="font-medium text-sm text-[var(--color-smoke)]">{{ $payment['course']['title'] ?? 'Course Payment' }}</h4>
                            <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">
                                @isset($payment['paid_at'])
                                    {{ \Carbon\Carbon::parse($payment['paid_at'])->format('M d, Y') }} ·
                                @endif
                                {{ $payment['provider'] ?? 'M-Pesa' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-[var(--color-terra)] font-mono">TSh {{ number_format($payment['amount'], 0) }}</span>
                        <button wire:click="downloadReceipt({{ $payment['id'] }})" class="p-1.5 rounded-lg hover:bg-[rgba(30,41,59,0.06)] transition-colors" title="Download Receipt">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center text-2xl" style="background: rgba(30,41,59,.04);">💳</div>
                    <p class="text-sm text-[rgba(30,41,59,0.5)]">No payments yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="glass-card p-5 rounded-xl glass-soft-shadow">
        <h2 class="text-base font-bold text-[var(--color-smoke)] mb-4">Payment Methods</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="group p-3 rounded-xl bg-[rgba(255,255,255,0.5)] border border-[rgba(30,41,59,0.06)] hover:border-[var(--color-terra)] hover:shadow-md transition-all cursor-pointer">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center text-lg mb-2" style="background: rgba(0,150,136,.1);">📱</div>
                <span class="text-xs font-semibold block text-[var(--color-smoke)]">M-Pesa</span>
                <span class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Mobile Money</span>
            </div>
            <div class="group p-3 rounded-xl bg-[rgba(255,255,255,0.5)] border border-[rgba(30,41,59,0.06)] hover:border-[var(--color-terra)] hover:shadow-md transition-all cursor-pointer">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center text-lg mb-2" style="background: rgba(244,67,54,.1);">📱</div>
                <span class="text-xs font-semibold block text-[var(--color-smoke)]">Airtel</span>
                <span class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Mobile Money</span>
            </div>
            <div class="group p-3 rounded-xl bg-[rgba(255,255,255,0.5)] border border-[rgba(30,41,59,0.06)] hover:border-[var(--color-terra)] hover:shadow-md transition-all cursor-pointer">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center text-lg mb-2" style="background: rgba(33,150,243,.1);">📱</div>
                <span class="text-xs font-semibold block text-[var(--color-smoke)]">Tigo Pesa</span>
                <span class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Mobile Money</span>
            </div>
            <div class="group p-3 rounded-xl bg-[rgba(255,255,255,0.5)] border border-[rgba(30,41,59,0.06)] hover:border-[var(--color-terra)] hover:shadow-md transition-all cursor-pointer">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center text-lg mb-2" style="background: rgba(103,58,183,.1);">💳</div>
                <span class="text-xs font-semibold block text-[var(--color-smoke)]">Card</span>
                <span class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Visa/Mastercard</span>
            </div>
        </div>
    </div>
</div>