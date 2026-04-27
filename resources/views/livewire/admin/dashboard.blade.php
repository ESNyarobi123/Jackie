<div class="space-y-8">
    <style>
        @keyframes admFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes admShimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes admBarGrow { from { transform: scaleY(0); } to { transform: scaleY(1); } }
        @keyframes admDonutFill { from { stroke-dashoffset: 100; } }
        .adm-fade-up { animation: admFadeUp .4s ease-out both; }
        .adm-fade-up-1 { animation-delay: .05s; }
        .adm-fade-up-2 { animation-delay: .1s; }
        .adm-fade-up-3 { animation-delay: .15s; }
        .adm-fade-up-4 { animation-delay: .2s; }
        .adm-fade-up-5 { animation-delay: .25s; }
        .adm-shimmer { background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.06) 50%, transparent 100%); background-size: 200% 100%; animation: admShimmer 3s ease-in-out infinite; }
        .adm-bar { transform-origin: bottom; animation: admBarGrow .6s ease-out both; }
        .adm-donut { animation: admDonutFill 1s ease-out both; }
        .adm-card { transition: transform .25s ease, box-shadow .25s ease; }
        .adm-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,.08); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="absolute inset-0 adm-shimmer"></div>
        <div class="relative px-8 py-10 md:py-14">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-[.6875rem] font-semibold mb-5" style="background: rgba(245,130,32,.15); color: #f58220; border: 1px solid rgba(245,130,32,.25);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"/></svg>
                        Admin Panel
                    </div>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3 tracking-tight" style="line-height: 1.1;">Dashboard</h1>
                    <p class="text-sm text-[rgba(255,255,255,.5)] max-w-lg leading-relaxed">Platform overview & analytics. Monitor your learning platform in real time.</p>
                </div>
                <div class="flex flex-col items-end gap-3">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl text-sm font-semibold transition-all hover:scale-105 active:scale-95" style="background: rgba(255,255,255,.1); color: rgba(255,255,255,.9); border: 1px solid rgba(255,255,255,.15); backdrop-filter: blur(10px);" target="_blank">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 13v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 19.5V6a2.25 2.25 0 012.25-2.25h6m6 0L21 3m0 0l-3 3m3-3v7.5"/></svg>
                        View Site
                    </a>
                    <span class="text-[.625rem] text-[rgba(255,255,255,.3)]">{{ $stats['total_users'] }} total users</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="adm-card relative overflow-hidden rounded-2xl p-5 adm-fade-up adm-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #3b82f6, rgba(59,130,246,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(59,130,246,.08);">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.782-3.07-1.416a6.5 6.5 0 01-1.055-.598m0 0a6.497 6.497 0 01-3.875-1.178m3.875 1.178L9 19.128m0 0a9.337 9.337 0 01-4.121-.952 4.125 4.125 0 017.533-2.493M9 19.128v-.003c0-1.113.285-2.16.782-3.07a6.5 6.5 0 011.055-.598m0 0a6.497 6.497 0 013.875-1.178M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm7.125 3.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Users</div>
                <div class="text-2xl font-black text-blue-600">{{ $stats['total_users'] }}</div>
                <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)] mt-1">{{ $stats['total_students'] }} students</div>
            </div>
        </div>
        <div class="adm-card relative overflow-hidden rounded-2xl p-5 adm-fade-up adm-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #f58220, rgba(245,130,32,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(245,130,32,.08);">
                    <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Courses</div>
                <div class="text-2xl font-black" style="color: var(--color-terra);">{{ $stats['total_courses'] }}</div>
                <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)] mt-1">{{ $stats['active_enrollments'] }} enrollments</div>
            </div>
        </div>
        <div class="adm-card relative overflow-hidden rounded-2xl p-5 adm-fade-up adm-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #22c55e, rgba(34,197,94,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(34,197,94,.08);">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Subscriptions</div>
                <div class="text-2xl font-black text-green-600">{{ $stats['active_subscriptions'] }}</div>
                <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)] mt-1">{{ $stats['total_subscriptions'] }} total</div>
            </div>
        </div>
        <div class="adm-card relative overflow-hidden rounded-2xl p-5 adm-fade-up adm-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #f59e0b, rgba(245,158,11,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(245,158,11,.08);">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Free Trials</div>
                <div class="text-2xl font-black text-amber-600">{{ $stats['trial_subscriptions'] }}</div>
                <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)] mt-1">{{ $stats['courses_with_trial'] }} courses</div>
            </div>
        </div>
        <div class="adm-card relative overflow-hidden rounded-2xl p-5 adm-fade-up adm-fade-up-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-2xl" style="background: linear-gradient(90deg, #8b5cf6, rgba(139,92,246,.1));"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: rgba(139,92,246,.08);">
                    <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
                <div class="text-xs font-semibold text-[rgba(30,41,59,0.4)] uppercase tracking-wider mb-1">Revenue</div>
                <div class="text-lg font-black text-purple-600">TSh {{ number_format($stats['total_revenue']) }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Row: Donut + Histogram -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Subscription Distribution Donut -->
        <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1" style="background: linear-gradient(90deg, #22c55e, #f59e0b, #ef4444);"></div>
            <div class="p-5">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #22c55e, rgba(34,197,94,.2));"></div>
                    <h2 class="text-sm font-bold text-(--color-smoke)">Subscriptions</h2>
                </div>
                @php
                    $subTotal = collect($subscriptionDistribution)->sum('value');
                    $subCumulative = 0;
                @endphp
                <div class="flex items-center justify-center mb-4">
                    <svg width="140" height="140" viewBox="0 0 140 140">
                        <circle cx="70" cy="70" r="50" fill="none" stroke="rgba(30,41,59,.06)" stroke-width="20"/>
                        @foreach($subscriptionDistribution as $segment)
                            @if($subTotal > 0)
                                @php
                                    $pct = $segment['value'] / $subTotal;
                                    $dashLen = $pct * 314.16;
                                    $dashOffset = -$subCumulative * 314.16;
                                    $subCumulative += $pct;
                                @endphp
                                <circle cx="70" cy="70" r="50" fill="none"
                                    stroke="{{ $segment['color'] }}"
                                    stroke-width="20"
                                    stroke-dasharray="{{ $dashLen }} {{ 314.16 - $dashLen }}"
                                    stroke-dashoffset="{{ $dashOffset }}"
                                    stroke-linecap="round"
                                    class="adm-donut"
                                    style="animation-delay: {{ $loop->index * .2 }}s; transform: rotate(-90deg); transform-origin: 70px 70px;"/>
                            @endif
                        @endforeach
                        <text x="70" y="66" text-anchor="middle" class="text-xl font-black" fill="var(--color-smoke)" style="font-size: 22px; font-weight: 900;">{{ $subTotal }}</text>
                        <text x="70" y="82" text-anchor="middle" fill="rgba(30,41,59,.4)" style="font-size: 9px; font-weight: 600;">TOTAL</text>
                    </svg>
                </div>
                <div class="space-y-2">
                    @foreach($subscriptionDistribution as $segment)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $segment['color'] }};"></span>
                                <span class="text-xs font-medium text-(--color-smoke)">{{ $segment['label'] }}</span>
                            </div>
                            <span class="text-xs font-bold" style="color: {{ $segment['color'] }};">{{ $segment['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Enrollment Status Donut -->
        <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1" style="background: linear-gradient(90deg, #22c55e, #3b82f6, #ef4444);"></div>
            <div class="p-5">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #3b82f6, rgba(59,130,246,.2));"></div>
                    <h2 class="text-sm font-bold text-(--color-smoke)">Enrollments</h2>
                </div>
                @php
                    $enrTotal = collect($enrollmentStatusDistribution)->sum('value');
                    $enrCumulative = 0;
                @endphp
                <div class="flex items-center justify-center mb-4">
                    <svg width="140" height="140" viewBox="0 0 140 140">
                        <circle cx="70" cy="70" r="50" fill="none" stroke="rgba(30,41,59,.06)" stroke-width="20"/>
                        @foreach($enrollmentStatusDistribution as $segment)
                            @if($enrTotal > 0)
                                @php
                                    $pct = $segment['value'] / $enrTotal;
                                    $dashLen = $pct * 314.16;
                                    $dashOffset = -$enrCumulative * 314.16;
                                    $enrCumulative += $pct;
                                @endphp
                                <circle cx="70" cy="70" r="50" fill="none"
                                    stroke="{{ $segment['color'] }}"
                                    stroke-width="20"
                                    stroke-dasharray="{{ $dashLen }} {{ 314.16 - $dashLen }}"
                                    stroke-dashoffset="{{ $dashOffset }}"
                                    stroke-linecap="round"
                                    class="adm-donut"
                                    style="animation-delay: {{ $loop->index * .2 }}s; transform: rotate(-90deg); transform-origin: 70px 70px;"/>
                            @endif
                        @endforeach
                        <text x="70" y="66" text-anchor="middle" fill="var(--color-smoke)" style="font-size: 22px; font-weight: 900;">{{ $enrTotal }}</text>
                        <text x="70" y="82" text-anchor="middle" fill="rgba(30,41,59,.4)" style="font-size: 9px; font-weight: 600;">TOTAL</text>
                    </svg>
                </div>
                <div class="space-y-2">
                    @foreach($enrollmentStatusDistribution as $segment)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $segment['color'] }};"></span>
                                <span class="text-xs font-medium text-(--color-smoke)">{{ $segment['label'] }}</span>
                            </div>
                            <span class="text-xs font-bold" style="color: {{ $segment['color'] }};">{{ $segment['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Revenue Histogram -->
        <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1" style="background: linear-gradient(90deg, #8b5cf6, #f58220);"></div>
            <div class="p-5">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #8b5cf6, rgba(139,92,246,.2));"></div>
                    <h2 class="text-sm font-bold text-(--color-smoke)">Revenue (6 Months)</h2>
                </div>
                @php
                    $revMax = collect($revenueTrend)->max('value') ?: 1;
                @endphp
                <div class="flex items-end gap-2 h-36 mb-2">
                    @foreach($revenueTrend as $item)
                        @php $height = max(($item['value'] / $revMax) * 100, 4); @endphp
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <span class="text-[.5rem] font-bold text-purple-600">{{ $item['value'] > 0 ? number_format($item['value'] / 1000, 0) . 'k' : '0' }}</span>
                            <div class="w-full rounded-t-lg adm-bar" style="height: {{ $height }}%; background: linear-gradient(180deg, #8b5cf6, rgba(139,92,246,.4)); animation-delay: {{ $loop->index * .08 }}s; min-height: 4px;"></div>
                        </div>
                    @endforeach
                </div>
                <div class="flex gap-2">
                    @foreach($revenueTrend as $item)
                        <div class="flex-1 text-center">
                            <span class="text-[.5rem] font-semibold text-[rgba(30,41,59,0.4)]">{{ $item['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollment Trend Histogram -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #f58220, #22c55e);"></div>
        <div class="p-5">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #f58220, rgba(245,130,32,.2));"></div>
                    <h2 class="text-sm font-bold text-(--color-smoke)">Weekly Enrollment Trend</h2>
                </div>
                <span class="text-[.5625rem] font-semibold text-[rgba(30,41,59,0.4)]">Last 7 weeks</span>
            </div>
            @php
                $enrTrendMax = collect($enrollmentTrend)->max('value') ?: 1;
            @endphp
            <div class="flex items-end gap-3 h-40 mb-3">
                @foreach($enrollmentTrend as $item)
                    @php $height = max(($item['value'] / $enrTrendMax) * 100, 4); @endphp
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <span class="text-[.5625rem] font-bold" style="color: var(--color-terra);">{{ $item['value'] }}</span>
                        <div class="w-full rounded-t-lg adm-bar" style="height: {{ $height }}%; background: linear-gradient(180deg, #f58220, rgba(245,130,32,.3)); animation-delay: {{ $loop->index * .08 }}s; min-height: 4px;"></div>
                    </div>
                @endforeach
            </div>
            <div class="flex gap-3">
                @foreach($enrollmentTrend as $item)
                    <div class="flex-1 text-center">
                        <span class="text-[.5rem] font-semibold text-[rgba(30,41,59,0.4)]">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Upcoming Live Classes -->
    @if($upcomingLiveClasses->count() > 0)
        <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1" style="background: linear-gradient(90deg, #ef4444, #f58220);"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,.08);">
                            <svg class="w-4.5 h-4.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.251l.003-.003a5.408 5.408 0 017.299 0 .75.75 0 01-.998 1.122 3.908 3.908 0 00-5.303 0 .75.75 0 01-.998-1.12zM6.24 11.28l.003-.003a8.407 8.407 0 0111.518 0 .75.75 0 01-.998 1.122 6.907 6.907 0 00-9.522 0 .75.75 0 01-.998-1.12zm12.026 5.942l.002.002a2.408 2.408 0 01-3.24 0 .75.75 0 01.998-1.122.908.908 0 001.244 0 .75.75 0 01.998 1.122z"/></svg>
                        </div>
                        <h2 class="text-sm font-bold text-(--color-smoke)">Upcoming Live Classes</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[.5625rem] font-bold" style="background: rgba(239,68,68,.08); color: #ef4444;">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        {{ $stats['upcoming_live_classes'] }} scheduled
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($upcomingLiveClasses as $class)
                        <div class="adm-card p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                            <div class="flex items-center gap-1.5 mb-2">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                <span class="text-[.5625rem] font-bold text-red-500 uppercase tracking-wider">Live</span>
                            </div>
                            <h3 class="font-bold text-sm text-(--color-smoke) mb-1">{{ $class->title }}</h3>
                            <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $class->course->title ?? 'General' }}</p>
                            <p class="text-[.625rem] font-semibold mt-2" style="color: var(--color-terra);">{{ $class->scheduled_at?->format('M d, h:i A') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Two Column: Recent Enrollments + Users -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Enrollments -->
        <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1" style="background: linear-gradient(90deg, #f58220, #22c55e);"></div>
            <div class="p-5">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #f58220, rgba(245,130,32,.2));"></div>
                    <h2 class="text-sm font-bold text-(--color-smoke)">Recent Enrollments</h2>
                </div>
                <div class="space-y-2">
                    @forelse($recentEnrollments as $enrollment)
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                                <svg class="w-4 h-4" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-xs text-(--color-smoke)">{{ $enrollment->user->name ?? 'Unknown' }}</p>
                                <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">{{ $enrollment->course->title ?? 'Unknown' }}</p>
                            </div>
                            <span class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">{{ $enrollment->enrolled_at?->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-[rgba(30,41,59,0.4)]">No recent enrollments</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1" style="background: linear-gradient(90deg, #3b82f6, #8b5cf6);"></div>
            <div class="p-5">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #3b82f6, rgba(59,130,246,.2));"></div>
                    <h2 class="text-sm font-bold text-(--color-smoke)">New Users</h2>
                </div>
                <div class="space-y-2">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center" style="background: rgba(59,130,246,.08);">
                                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-xs text-(--color-smoke)">{{ $user->name }}</p>
                                <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">{{ $user->email }}</p>
                            </div>
                            <span class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">{{ $user->created_at?->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-[rgba(30,41,59,0.4)]">No new users</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #22c55e, #3b82f6, #8b5cf6);"></div>
        <div class="p-5">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #22c55e, rgba(34,197,94,.2));"></div>
                <h2 class="text-sm font-bold text-(--color-smoke)">Recent Subscriptions</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-[.5625rem] text-[rgba(30,41,59,0.4)] uppercase tracking-wider border-b" style="border-color: rgba(30,41,59,.06);">
                            <th class="pb-3 font-semibold">User</th>
                            <th class="pb-3 font-semibold">Plan</th>
                            <th class="pb-3 font-semibold">Status</th>
                            <th class="pb-3 font-semibold">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        @forelse($recentSubscriptions as $subscription)
                            <tr class="border-b" style="border-color: rgba(30,41,59,.04);">
                                <td class="py-3 font-semibold text-(--color-smoke)">{{ $subscription->user->name ?? 'Unknown' }}</td>
                                <td class="py-3 text-[rgba(30,41,59,0.6)]">{{ $subscription->plan_name ?? 'N/A' }}</td>
                                <td class="py-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: {{ $subscription->status->value === 'active' ? 'rgba(34,197,94,.08)' : 'rgba(30,41,59,.04)' }}; color: {{ $subscription->status->value === 'active' ? '#16a34a' : 'rgba(30,41,59,.5)' }};">
                                        <span class="w-1 h-1 rounded-full" style="background: {{ $subscription->status->value === 'active' ? '#22c55e' : 'rgba(30,41,59,.3)' }};"></span>
                                        {{ ucfirst($subscription->status->value) }}
                                    </span>
                                </td>
                                <td class="py-3 text-[rgba(30,41,59,0.4)]">{{ $subscription->created_at?->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-[rgba(30,41,59,0.4)]">No subscriptions yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Management -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.courses.index') }}" class="adm-card group rounded-2xl overflow-hidden p-5 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1 -mx-5 -mt-5 mb-4" style="background: linear-gradient(90deg, #f58220, rgba(245,130,32,.1));"></div>
            <div class="w-12 h-12 mx-auto rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition" style="background: rgba(245,130,32,.08);">
                <svg class="w-6 h-6" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </div>
            <div class="font-bold text-sm text-(--color-smoke)">Courses</div>
            <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Manage</div>
        </a>
        <a href="{{ route('admin.users.index') }}" class="adm-card group rounded-2xl overflow-hidden p-5 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1 -mx-5 -mt-5 mb-4" style="background: linear-gradient(90deg, #3b82f6, rgba(59,130,246,.1));"></div>
            <div class="w-12 h-12 mx-auto rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition" style="background: rgba(59,130,246,.08);">
                <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.782-3.07-1.416a6.5 6.5 0 01-1.055-.598m0 0a6.497 6.497 0 01-3.875-1.178m3.875 1.178L9 19.128m0 0a9.337 9.337 0 01-4.121-.952 4.125 4.125 0 017.533-2.493M9 19.128v-.003c0-1.113.285-2.16.782-3.07a6.5 6.5 0 011.055-.598m0 0a6.497 6.497 0 013.875-1.178M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm7.125 3.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
            </div>
            <div class="font-bold text-sm text-(--color-smoke)">Users</div>
            <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Manage</div>
        </a>
        <a href="{{ route('admin.subscriptions.index') }}" class="adm-card group rounded-2xl overflow-hidden p-5 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1 -mx-5 -mt-5 mb-4" style="background: linear-gradient(90deg, #22c55e, rgba(34,197,94,.1));"></div>
            <div class="w-12 h-12 mx-auto rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition" style="background: rgba(34,197,94,.08);">
                <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="font-bold text-sm text-(--color-smoke)">Subscriptions</div>
            <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Plans</div>
        </a>
        <a href="{{ route('admin.live-classes.index') }}" class="adm-card group rounded-2xl overflow-hidden p-5 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="h-1 -mx-5 -mt-5 mb-4" style="background: linear-gradient(90deg, #8b5cf6, rgba(139,92,246,.1));"></div>
            <div class="w-12 h-12 mx-auto rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition" style="background: rgba(139,92,246,.08);">
                <svg class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.251l.003-.003a5.408 5.408 0 017.299 0 .75.75 0 01-.998 1.122 3.908 3.908 0 00-5.303 0 .75.75 0 01-.998-1.12zM6.24 11.28l.003-.003a8.407 8.407 0 0111.518 0 .75.75 0 01-.998 1.122 6.907 6.907 0 00-9.522 0 .75.75 0 01-.998-1.12zm12.026 5.942l.002.002a2.408 2.408 0 01-3.24 0 .75.75 0 01.998-1.122.908.908 0 001.244 0 .75.75 0 01.998 1.122z"/></svg>
            </div>
            <div class="font-bold text-sm text-(--color-smoke)">Live Classes</div>
            <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Schedule</div>
        </a>
    </div>
</div>
