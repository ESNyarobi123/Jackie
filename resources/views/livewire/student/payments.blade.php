<div class="space-y-8">
    <style>
        @keyframes payFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes payShimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes payFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        .pay-fade-up { animation: payFadeUp .4s ease-out both; }
        .pay-fade-up-1 { animation-delay: .05s; }
        .pay-fade-up-2 { animation-delay: .1s; }
        .pay-fade-up-3 { animation-delay: .15s; }
        .pay-fade-up-4 { animation-delay: .2s; }
        .pay-shimmer { background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.08) 50%, transparent 100%); background-size: 200% 100%; animation: payShimmer 3s ease-in-out infinite; }
        .pay-float { animation: payFloat 3s ease-in-out infinite; }
        .pay-card { transition: transform .25s ease, box-shadow .25s ease; }
        .pay-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,.08); }
        .pay-method { transition: all .3s ease; }
        .pay-method:hover { transform: translateY(-4px) scale(1.02); box-shadow: 0 8px 30px rgba(0,0,0,.1); }
    </style>

    <!-- Hero Subscription Card -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="absolute inset-0 pay-shimmer"></div>
        <!-- Floating decorative elements -->
        <div class="absolute top-6 right-12 w-16 h-16 rounded-2xl opacity-5 pay-float" style="background: #f58220; animation-delay: 0s;"></div>
        <div class="absolute bottom-8 right-32 w-10 h-10 rounded-xl opacity-5 pay-float" style="background: #22c55e; animation-delay: 1s;"></div>
        <div class="absolute top-16 right-56 w-8 h-8 rounded-lg opacity-5 pay-float" style="background: #3b82f6; animation-delay: 2s;"></div>
        <div class="relative px-8 py-10 md:py-14">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-[.6875rem] font-semibold mb-5" style="background: {{ $subscription ? 'rgba(34,197,94,.15)' : 'rgba(239,68,68,.15)' }}; color: {{ $subscription ? '#22c55e' : '#ef4444' }}; border: 1px solid {{ $subscription ? 'rgba(34,197,94,.25)' : 'rgba(239,68,68,.25)' }}; backdrop-filter: blur(10px);">
                        <span class="w-2 h-2 rounded-full {{ $subscription ? 'bg-green-500' : 'bg-red-400' }} animate-pulse"></span>
                        {{ $subscription ? 'Active Plan' : 'No Active Plan' }}
                    </div>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3 tracking-tight" style="line-height: 1.1;">
                        {{ $subscription ? 'Your Subscription' : 'Start Learning' }}
                    </h1>
                    <p class="text-sm text-[rgba(255,255,255,.5)] max-w-lg leading-relaxed">
                        {{ $subscription ? 'You have active access to your courses and live classes. Manage your subscriptions and payment history below.' : 'Subscribe to unlock courses, live classes, and certificates. Start your learning journey today.' }}
                    </p>
                </div>
                <div class="flex flex-col items-end gap-3">
                    @if(!$subscription)
                        <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-2xl text-sm font-bold transition-all hover:scale-105 active:scale-95" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; box-shadow: 0 8px 24px rgba(245,158,11,.35);">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                            Choose a Plan
                        </a>
                        <span class="text-[.625rem] text-[rgba(255,255,255,.3)]">Flexible payment options available</span>
                    @else
                        <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl text-sm font-semibold transition-all hover:scale-105 active:scale-95" style="background: rgba(255,255,255,.1); color: rgba(255,255,255,.9); border: 1px solid rgba(255,255,255,.15); backdrop-filter: blur(10px);">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                            Renew Subscription
                        </a>
                        <span class="text-[.625rem] text-[rgba(255,255,255,.3)]">Keep your access active</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-24 h-24 rounded-full opacity-[.04]" style="background: #f58220;"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #f58220, rgba(245,130,32,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(245,130,32,.08);">
                    <svg class="w-5.5 h-5.5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Total Paid</div>
                <div class="text-xl font-black" style="color: var(--color-terra);">TSh {{ number_format($stats['total_paid'] ?? 0, 0) }}</div>
            </div>
        </div>
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-24 h-24 rounded-full opacity-[.04]" style="background: #22c55e;"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #22c55e, rgba(34,197,94,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(34,197,94,.08);">
                    <svg class="w-5.5 h-5.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Active</div>
                <div class="text-2xl font-black text-green-600">{{ $stats['active_subscriptions'] ?? 0 }}</div>
            </div>
        </div>
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-24 h-24 rounded-full opacity-[.04]" style="background: #3b82f6;"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #3b82f6, rgba(59,130,246,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(59,130,246,.08);">
                    <svg class="w-5.5 h-5.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 9h3.75m3.75 0h-.375v-.375h-.375V9h.375v.375h.375V9h-.375V5.25H9v.375H5.25V9H9v.375H5.25v.375H9V15H5.25v-.375H9V15zm6-6V5.25H15V9h.375zm0 0H15v.375h.375V9z"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Payments</div>
                <div class="text-2xl font-black text-blue-600">{{ $stats['total_payments'] ?? 0 }}</div>
            </div>
        </div>
        <div class="pay-card relative overflow-hidden rounded-2xl p-5 pay-fade-up pay-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-24 h-24 rounded-full opacity-[.04]" style="background: #8b5cf6;"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #8b5cf6, rgba(139,92,246,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(139,92,246,.08);">
                    <svg class="w-5.5 h-5.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">This Month</div>
                <div class="text-xl font-black text-purple-600">TSh {{ number_format($stats['this_month'] ?? 0, 0) }}</div>
            </div>
        </div>
    </div>

    <!-- Active Subscriptions -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #22c55e, #3b82f6, #8b5cf6);"></div>
        <div class="p-5">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(34,197,94,.08);">
                        <svg class="w-4.5 h-4.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-base font-bold text-(--color-smoke)">Active Subscriptions</h2>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[.625rem] font-bold" style="background: {{ $subscription ? 'rgba(34,197,94,.08)' : 'rgba(239,68,68,.08)' }}; color: {{ $subscription ? '#16a34a' : '#dc2626' }};">
                    <span class="w-1.5 h-1.5 rounded-full {{ $subscription ? 'bg-green-500' : 'bg-red-400' }}"></span>
                    {{ $subscription ? 'Active' : 'None' }}
                </span>
            </div>
            @forelse($subscriptions as $sub)
                <div class="pay-card flex items-center justify-between p-4 rounded-xl mb-3 last:mb-0" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(245,130,32,.1), rgba(245,130,32,.03));">
                            <svg class="w-5.5 h-5.5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm text-(--color-smoke)">{{ $sub['course']['title'] ?? 'Course' }}</h3>
                            <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] flex items-center gap-1">
                                @isset($sub['access_ends_at'])
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Expires {{ \Carbon\Carbon::parse($sub['access_ends_at'])->format('M d, Y') }}
                                    <span style="color: var(--color-terra);">({{ \Carbon\Carbon::parse($sub['access_ends_at'])->diffForHumans() }})</span>
                                @else
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Active subscription
                                @endif
                            </p>
                        </div>
                    </div>
                    <button wire:click="renewSubscription({{ $sub['id'] }})" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-[.6875rem] font-bold transition-all hover:scale-105 active:scale-95" style="background: linear-gradient(135deg, rgba(245,130,32,.12), rgba(245,130,32,.06)); color: var(--color-terra); border: 1px solid rgba(245,130,32,.1);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                        Renew
                    </button>
                </div>
            @empty
                <div class="text-center py-10">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                        <svg class="w-8 h-8" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-(--color-smoke) mb-1">No Active Subscriptions</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.5)] mb-4">Enroll in a course to get started</p>
                    <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                        Browse Courses
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Payment History -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #3b82f6, #8b5cf6, #f58220);"></div>
        <div class="p-5">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,.08);">
                        <svg class="w-4.5 h-4.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 9h3.75m3.75 0h-.375v-.375h-.375V9h.375v.375h.375V9h-.375V5.25H9v.375H5.25V9H9v.375H5.25v.375H9V15H5.25v-.375H9V15zm6-6V5.25H15V9h.375zm0 0H15v.375h.375V9z"/></svg>
                    </div>
                    <h2 class="text-base font-bold text-(--color-smoke)">Payment History</h2>
                </div>
                @if(($stats['total_payments'] ?? 0) > 5)
                    <button wire:click="toggleShowAll" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[.6875rem] font-semibold transition-all hover:scale-105" style="background: rgba(245,130,32,.08); color: var(--color-terra);">
                        {{ $showAllPayments ? 'Show Less' : 'View All' }}
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </button>
                @endif
            </div>
            <div class="space-y-3">
                @forelse($payments as $payment)
                    @php
                        $statusColor = ($payment['status'] ?? 'completed') === 'completed'
                            ? ['bg' => 'rgba(34,197,94,.08)', 'text' => '#16a34a', 'icon' => 'check']
                            : ($payment['status'] === 'pending'
                                ? ['bg' => 'rgba(245,158,11,.08)', 'text' => '#d97706', 'icon' => 'clock']
                                : ['bg' => 'rgba(239,68,68,.08)', 'text' => '#dc2626', 'icon' => 'x']);
                    @endphp
                    <div class="pay-card flex items-center justify-between p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl shrink-0 flex items-center justify-center" style="background: {{ $statusColor['bg'] }};">
                                @if($statusColor['icon'] === 'check')
                                    <svg class="w-5 h-5" style="color: {{ $statusColor['text'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif($statusColor['icon'] === 'clock')
                                    <svg class="w-5 h-5" style="color: {{ $statusColor['text'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @else
                                    <svg class="w-5 h-5" style="color: {{ $statusColor['text'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-(--color-smoke)">{{ $payment['course']['title'] ?? 'Course Payment' }}</h4>
                                <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] flex items-center gap-1.5">
                                    @isset($payment['paid_at'])
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                            {{ \Carbon\Carbon::parse($payment['paid_at'])->format('M d, Y') }}
                                        </span>
                                        <span>·</span>
                                    @endif
                                    <span>{{ $payment['provider'] ?? 'M-Pesa' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <span class="text-sm font-black font-mono" style="color: var(--color-terra);">TSh {{ number_format($payment['amount'], 0) }}</span>
                                <p class="text-[.5rem] font-semibold uppercase tracking-wider" style="color: {{ $statusColor['text'] }};">{{ ucfirst($payment['status'] ?? 'completed') }}</p>
                            </div>
                            <button wire:click="downloadReceipt({{ $payment['id'] }})" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-[rgba(30,41,59,0.06)] transition-all hover:scale-110" title="Download Receipt">
                                <svg class="w-4 h-4 text-[rgba(30,41,59,0.35)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(30,41,59,.04);">
                            <svg class="w-8 h-8 text-[rgba(30,41,59,0.25)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        </div>
                        <h3 class="font-bold text-base text-(--color-smoke) mb-1">No Payments Yet</h3>
                        <p class="text-sm text-[rgba(30,41,59,0.5)]">Your payment history will appear here</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #8b5cf6, #f58220, #22c55e);"></div>
        <div class="p-5">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(139,92,246,.08);">
                    <svg class="w-4.5 h-4.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                </div>
                <h2 class="text-base font-bold text-(--color-smoke)">Payment Methods</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="pay-method group p-5 rounded-2xl cursor-pointer" style="border: 1px solid rgba(0,150,136,.1); background: linear-gradient(135deg, rgba(0,150,136,.04), rgba(0,150,136,.01));">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: rgba(0,150,136,.1);">
                        <svg class="w-6 h-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                    </div>
                    <span class="text-sm font-bold block text-(--color-smoke)">M-Pesa</span>
                    <span class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Mobile Money</span>
                    <div class="mt-3 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        <span class="text-[.5rem] font-semibold text-green-600">Available</span>
                    </div>
                </div>
                <div class="pay-method group p-5 rounded-2xl cursor-pointer" style="border: 1px solid rgba(244,67,54,.1); background: linear-gradient(135deg, rgba(244,67,54,.04), rgba(244,67,54,.01));">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: rgba(244,67,54,.1);">
                        <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                    </div>
                    <span class="text-sm font-bold block text-(--color-smoke)">Airtel</span>
                    <span class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Mobile Money</span>
                    <div class="mt-3 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        <span class="text-[.5rem] font-semibold text-green-600">Available</span>
                    </div>
                </div>
                <div class="pay-method group p-5 rounded-2xl cursor-pointer" style="border: 1px solid rgba(33,150,243,.1); background: linear-gradient(135deg, rgba(33,150,243,.04), rgba(33,150,243,.01));">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: rgba(33,150,243,.1);">
                        <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                    </div>
                    <span class="text-sm font-bold block text-(--color-smoke)">Tigo Pesa</span>
                    <span class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Mobile Money</span>
                    <div class="mt-3 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        <span class="text-[.5rem] font-semibold text-green-600">Available</span>
                    </div>
                </div>
                <div class="pay-method group p-5 rounded-2xl cursor-pointer" style="border: 1px solid rgba(103,58,183,.1); background: linear-gradient(135deg, rgba(103,58,183,.04), rgba(103,58,183,.01));">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: rgba(103,58,183,.1);">
                        <svg class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    </div>
                    <span class="text-sm font-bold block text-(--color-smoke)">Card</span>
                    <span class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Visa/Mastercard</span>
                    <div class="mt-3 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        <span class="text-[.5rem] font-semibold text-amber-600">Coming Soon</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>