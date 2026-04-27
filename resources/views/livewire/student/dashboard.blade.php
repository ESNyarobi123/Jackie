<div class="space-y-8">
    <style>
        @keyframes dashFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes progressFill { from { width: 0%; } }
        @keyframes countUp { from { opacity:0; transform:scale(.8); } 50% { transform:scale(1.05); } to { opacity:1; transform:scale(1); } }
        @keyframes livePulse { 0%,100% { box-shadow: 0 0 0 0 rgba(239,68,68,.4); } 50% { box-shadow: 0 0 0 8px rgba(239,68,68,0); } }
        .dash-fade-up { animation: dashFadeUp .4s ease-out both; }
        .dash-fade-up-1 { animation-delay: .05s; }
        .dash-fade-up-2 { animation-delay: .1s; }
        .dash-fade-up-3 { animation-delay: .15s; }
        .dash-fade-up-4 { animation-delay: .2s; }
        .progress-fill { animation: progressFill 1s ease-out both; animation-delay: .3s; }
        .stat-count { animation: countUp .5s ease-out both; }
        .live-pulse { animation: livePulse 2s ease-in-out infinite; }
        .stat-card { transition: transform .25s ease, box-shadow .25s ease; }
        .stat-card:hover { transform: translateY(-3px); }
    </style>

    <!-- Hero Welcome Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full opacity-5" style="background: radial-gradient(circle, rgba(245,130,32,.5), transparent 70%); filter: blur(30px);"></div>

        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <p class="text-xs text-[rgba(255,255,255,.4)] mb-1 font-medium">{{ now()->format('l, M d Y') }}</p>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Pick up where you left off. Your learning journey continues here.</p>
                </div>
                <div class="flex items-center gap-3">
                    @if(($stats['is_trial'] ?? false))
                        <a href="{{ route('student.payments') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-sm font-semibold transition-all hover:scale-105 active:scale-95" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; box-shadow: 0 4px 14px rgba(245,158,11,.3);">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0016.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.003 6.003 0 01-5.54 0"/></svg>
                            Subscribe Now
                        </a>
                    @endif
                    <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-sm font-semibold transition-all hover:scale-105 active:scale-95" style="background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1); backdrop-filter: blur(10px);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        Browse Courses
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Free Trial Banner -->
    @if(($stats['is_trial'] ?? false))
        <div class="relative overflow-hidden rounded-2xl" style="background: linear-gradient(135deg, rgba(245,158,11,.08), rgba(245,158,11,.02)); border: 1px solid rgba(245,158,11,.15);">
            <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,158,11,.6) 0%, transparent 50%);"></div>
            <div class="relative p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,.12);">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-amber-700">Free Trial Active</div>
                        <div class="text-xs text-[rgba(30,41,59,0.6)]">{{ $stats['trial_days_left'] ?? 0 }} day{{ ($stats['trial_days_left'] ?? 0) !== 1 ? 's' : '' }} remaining · Expires {{ isset($stats['trial_ends_at']) ? \Carbon\Carbon::parse($stats['trial_ends_at'])->format('M d, Y') : 'N/A' }}</div>
                    </div>
                </div>
                <a href="{{ route('student.payments') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:scale-105 active:scale-95" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                    Subscribe Now
                </a>
            </div>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="stat-card relative overflow-hidden rounded-2xl p-5 dash-fade-up dash-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #f58220;"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center mb-3" style="background: rgba(245,130,32,.08);">
                    <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div class="text-3xl font-extrabold text-(--color-smoke) stat-count">{{ $stats['active_courses'] }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5 font-medium">Active Courses</div>
            </div>
        </div>

        <div class="stat-card relative overflow-hidden rounded-2xl p-5 dash-fade-up dash-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #22c55e;"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center mb-3" style="background: rgba(34,197,94,.08);">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <div class="text-3xl font-extrabold stat-count" style="color: var(--color-terra);">{{ round($stats['avg_progress']) }}%</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5 font-medium">Progress</div>
                <div class="mt-2.5 w-full bg-[rgba(30,41,59,0.06)] rounded-full h-1.5">
                    <div class="h-1.5 rounded-full progress-fill" style="width: {{ $stats['avg_progress'] }}%; background: linear-gradient(90deg, #f58220, #22c55e);"></div>
                </div>
            </div>
        </div>

        <div class="stat-card relative overflow-hidden rounded-2xl p-5 dash-fade-up dash-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #8b5cf6;"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center mb-3" style="background: rgba(139,92,246,.08);">
                    <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 1.587M4.26 10.147a60.438 60.438 0 011.356-3.727M4.26 10.147a60.438 60.438 0 001.356 3.727m0 0a60.437 60.437 0 004.89 8.736M5.616 13.874a60.44 60.44 0 014.89-8.736m0 0a60.44 60.44 0 015.724 8.736M10.506 5.138a60.44 60.44 0 005.724 8.736m0 0a60.44 60.44 0 014.89 8.736M16.23 13.874a60.44 60.44 0 004.89-8.736m0 0a60.44 60.44 0 00-.491-1.587M20.619 5.138a60.44 60.44 0 00-1.356-3.727M20.619 5.138a60.44 60.44 0 01-1.356 3.727"/></svg>
                </div>
                <div class="text-3xl font-extrabold text-purple-600 stat-count">{{ $stats['certificates'] }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5 font-medium">Certificates</div>
            </div>
        </div>

        <div class="stat-card relative overflow-hidden rounded-2xl p-5 dash-fade-up dash-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: {{ $subscription ? '#22c55e' : '#ef4444' }};"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center mb-3" style="background: {{ $subscription ? 'rgba(34,197,94,.08)' : 'rgba(239,68,68,.08)' }};">
                    @if($subscription)
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    @endif
                </div>
                <div class="text-lg font-extrabold {{ $subscription ? 'text-green-600' : 'text-red-500' }} stat-count">
                    {{ ($stats['is_trial'] ?? false) ? 'Free Trial' : ($subscription ? 'Active' : 'Inactive') }}
                </div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5 font-medium">Subscription</div>
                @if(!$subscription)
                    <a href="{{ route('student.catalog') }}" class="mt-1.5 block text-[.625rem] font-semibold hover:underline" style="color: var(--color-terra);">Start trial →</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-5">
            <!-- Continue Learning -->
            <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, var(--color-terra), rgba(245,130,32,.2));"></div>
                        <h2 class="text-base font-bold text-(--color-smoke)">Continue Learning</h2>
                    </div>
                    <a href="{{ route('student.courses') }}" class="text-xs font-semibold hover:underline" style="color: var(--color-terra);">View all →</a>
                </div>
                <div class="space-y-3">
                    @forelse($activeEnrollments as $enrollment)
                        @php
                            $courseImages = [
                                'spoken' => 'https://images.unsplash.com/photo-1543165796-5426273eaab3?w=400&q=80',
                                'business' => 'https://images.unsplash.com/photo-1552664733-d6d7a8a4345?w=400&q=80',
                                'ielts' => 'https://images.unsplash.com/photo-1456511780578-1a7e62e0c3c5?w=400&q=80',
                                'default' => 'https://images.unsplash.com/photo-1509062523349-8427d3e7e577?w=400&q=80',
                            ];
                            $imgKey = str_contains(strtolower($enrollment->course->title), 'spoken') ? 'spoken'
                                : (str_contains(strtolower($enrollment->course->title), 'business') ? 'business'
                                : (str_contains(strtolower($enrollment->course->title), 'ielts') ? 'ielts'
                                : 'default'));
                            $courseImg = $courseImages[$imgKey];
                        @endphp

                        <div class="flex items-center gap-4 p-3 rounded-xl hover:shadow-md transition-all group" style="background: rgba(255,255,255,.5); border: 1px solid rgba(30,41,59,.04);">
                            <div class="w-14 h-14 rounded-xl overflow-hidden shrink-0" style="background: #f0f0f0;">
                                <img src="{{ $courseImg }}" alt="{{ $enrollment->course->title }}" class="w-full h-full object-cover" loading="lazy" onerror="this.style.display='none'" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-sm text-(--color-smoke) group-hover:text-(--color-terra) transition-colors">{{ $enrollment->course->title }}</h3>
                                <p class="text-[.6875rem] text-[rgba(30,41,59,0.4)] mt-0.5">
                                    {{ (int) floor(($enrollment->progress_percentage / 100) * ($enrollment->course->lessons_count ?? 0)) }}/{{ $enrollment->course->lessons_count ?? 0 }} lessons · {{ $enrollment->enrolled_at?->diffForHumans() ?? 'Recently' }}
                                </p>
                                <div class="mt-2 flex items-center gap-2">
                                    <div class="flex-1 bg-[rgba(30,41,59,0.06)] rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full transition-all duration-500" style="width: {{ $enrollment->progress_percentage }}%; background: linear-gradient(90deg, #f58220, #22c55e);"></div>
                                    </div>
                                    <span class="text-[.5625rem] font-bold" style="color: var(--color-terra);">{{ round($enrollment->progress_percentage) }}%</span>
                                </div>
                            </div>
                            <a href="{{ route('student.courses') }}" class="px-4 py-2 rounded-xl text-[.6875rem] font-semibold transition-all hover:scale-105 active:scale-95 shrink-0" style="background: rgba(245,130,32,.08); color: var(--color-terra);">
                                Continue
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                                <svg class="w-8 h-8" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            </div>
                            <p class="font-semibold text-(--color-smoke) mb-1">No Active Courses</p>
                            <p class="text-xs text-[rgba(30,41,59,0.5)] mb-4">Start your learning journey today!</p>
                            <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                                Browse Courses
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Next Live Class -->
            @if($nextLiveClass)
                @php($isLive = $nextLiveClass->status?->value === 'live')
                <div class="relative overflow-hidden rounded-2xl {{ $isLive ? 'ring-2 ring-red-400/50' : '' }}" style="background: {{ $isLive ? 'linear-gradient(135deg, rgba(239,68,68,.06), rgba(239,68,68,.02))' : 'linear-gradient(135deg, rgba(245,130,32,.06), rgba(245,130,32,.02))' }}; border: 1px solid {{ $isLive ? 'rgba(239,68,68,.15)' : 'rgba(245,130,32,.12)' }};">
                    @if($isLive)
                        <div class="absolute top-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, #ef4444, #f97316, #ef4444);"></div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 {{ $isLive ? 'live-pulse' : '' }}" style="background: {{ $isLive ? 'rgba(239,68,68,.1)' : 'rgba(245,130,32,.1)' }};">
                                    @if($isLive)
                                        <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.251l.003-.003a5.408 5.408 0 017.299 0 .75.75 0 01-.998 1.122 3.908 3.908 0 00-5.303 0 .75.75 0 01-.998-1.12zM6.24 11.28l.003-.003a8.407 8.407 0 0111.518 0 .75.75 0 01-.998 1.122 6.907 6.907 0 00-9.522 0 .75.75 0 01-.998-1.12zm12.026 5.942l.002.002a2.408 2.408 0 01-3.24 0 .75.75 0 01.998-1.122.908.908 0 001.244 0 .75.75 0 01.998 1.122z"/></svg>
                                    @else
                                        <svg class="w-6 h-6" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.96-1.802-3.169a23.61 23.61 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $isLive ? 'bg-red-500 animate-pulse' : 'bg-amber-500' }}"></span>
                                        <span class="text-[.625rem] font-bold {{ $isLive ? 'text-red-500' : 'text-amber-600' }} uppercase tracking-wider">
                                            {{ $isLive ? 'Live Now!' : 'Upcoming Live Class' }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-sm text-(--color-smoke)">{{ $nextLiveClass->title }}</h3>
                                    <p class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5">{{ $nextLiveClass->course->title ?? '' }}</p>
                                    <p class="text-[.6875rem] font-medium mt-1" style="color: var(--color-terra);">
                                        @if($isLive)
                                            Happening now · Join before it ends!
                                        @else
                                            {{ $nextLiveClass->scheduled_at?->format('M d, h:i A') }} · {{ $nextLiveClass->scheduled_at?->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('student.live-classes.join', $nextLiveClass) }}" wire:navigate class="px-5 py-3 rounded-xl text-xs font-semibold transition-all hover:scale-105 active:scale-95 shrink-0" style="background: {{ $isLive ? '#ef4444' : 'var(--color-terra)' }}; color: white; box-shadow: 0 4px 14px {{ $isLive ? 'rgba(239,68,68,.3)' : 'rgba(245,130,32,.25)' }};">
                                {{ $isLive ? 'Join Live' : 'Join Class' }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recommended Courses -->
            @if(is_array($recommendedCourses) && count($recommendedCourses) > 0)
                <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #8b5cf6, rgba(139,92,246,.2));"></div>
                            <h2 class="text-base font-bold text-(--color-smoke)">Recommended</h2>
                        </div>
                        <a href="{{ route('student.catalog') }}" class="text-xs font-semibold hover:underline" style="color: var(--color-terra);">Catalog →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach($recommendedCourses as $course)
                            <div class="p-4 rounded-xl hover:shadow-md transition-all" style="border: 1px solid rgba(30,41,59,.06); background: rgba(255,255,255,.5);">
                                <div class="font-semibold text-xs text-(--color-smoke) mb-1">{{ $course['title'] }}</div>
                                <div class="text-[.625rem] text-[rgba(30,41,59,0.4)]">
                                    {{ $course['lessons_count'] ?? 0 }} lessons · {{ $course['duration_days'] ?? 0 }} days
                                </div>
                                @if(($course['has_free_trial'] ?? false))
                                    <div class="mt-1.5 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[.5rem] font-bold" style="background: rgba(34,197,94,.08); color: #16a34a;">
                                        {{ $course['free_trial_days'] ?? 7 }}-day free trial
                                    </div>
                                @endif
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-xs font-bold" style="color: var(--color-terra);">
                                        {{ $course['currency'] ?? 'TZS' }} {{ number_format((float) ($course['price_amount'] ?? 0), 0) }}
                                    </span>
                                    <a href="{{ route('student.catalog') }}" class="text-[.625rem] font-semibold hover:underline" style="color: var(--color-terra);">
                                        @if(($course['has_free_trial'] ?? false))
                                            Start Trial →
                                        @else
                                            Enroll →
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-5">
            <!-- Quick Actions -->
            <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, var(--color-terra), rgba(245,130,32,.2));"></div>
                    <h3 class="font-bold text-sm text-(--color-smoke)">Quick Actions</h3>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('student.certificates') }}" class="flex items-center gap-3 p-3 rounded-xl hover:shadow-sm transition-all group" style="border: 1px solid rgba(30,41,59,.04);">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(139,92,246,.08);">
                            <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 1.587M4.26 10.147a60.438 60.438 0 011.356-3.727M4.26 10.147a60.438 60.438 0 001.356 3.727m0 0a60.437 60.437 0 004.89 8.736M5.616 13.874a60.44 60.44 0 014.89-8.736m0 0a60.44 60.44 0 015.724 8.736M10.506 5.138a60.44 60.44 0 005.724 8.736m0 0a60.44 60.44 0 014.89 8.736"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-(--color-smoke) group-hover:text-(--color-terra) transition-colors">Certificates</span>
                            <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">View your achievements</p>
                        </div>
                    </a>
                    <a href="{{ route('student.payments') }}" class="flex items-center gap-3 p-3 rounded-xl hover:shadow-sm transition-all group" style="border: 1px solid rgba(30,41,59,.04);">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(34,197,94,.08);">
                            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-(--color-smoke) group-hover:text-(--color-terra) transition-colors">Subscription</span>
                            <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Manage your plan</p>
                        </div>
                    </a>
                    <a href="{{ route('student.catalog') }}" class="flex items-center gap-3 p-3 rounded-xl hover:shadow-sm transition-all group" style="border: 1px solid rgba(30,41,59,.04);">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(245,130,32,.08);">
                            <svg class="w-4 h-4" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-(--color-smoke) group-hover:text-(--color-terra) transition-colors">Browse Courses</span>
                            <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Explore new courses</p>
                        </div>
                    </a>
                    <a href="{{ route('student.settings') }}" class="flex items-center gap-3 p-3 rounded-xl hover:shadow-sm transition-all group" style="border: 1px solid rgba(30,41,59,.04);">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(30,41,59,.04);">
                            <svg class="w-4 h-4 text-[rgba(30,41,59,0.4)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.153.902.833 1.619 1.724 1.775l1.263.215c.542.09.94.56.94 1.11v2.593c0 .55-.398 1.02-.94 1.11l-1.281.213c-.902.153-1.619.833-1.775 1.724l-.215 1.263c-.09.542-.56.94-1.11.94h-2.593c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.153-.902-.833-1.619-1.724-1.775l-1.263-.215c-.542-.09-.94-.56-.94-1.11V7.784c0-.55.398-1.02.94-1.11l1.281-.213c.902-.153 1.619-.833 1.775-1.724l.215-1.263z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-(--color-smoke) group-hover:text-(--color-terra) transition-colors">Settings</span>
                            <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">Account preferences</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- This Week -->
            <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #06b6d4, rgba(6,182,212,.2));"></div>
                    <h3 class="font-bold text-sm text-(--color-smoke)">This Week</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-xl" style="background: rgba(6,182,212,.04); border: 1px solid rgba(6,182,212,.08);">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(6,182,212,.08);">
                                <svg class="w-4 h-4 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-xs text-[rgba(30,41,59,0.6)]">Study Time</span>
                        </div>
                        <span class="text-xs font-bold text-cyan-600">{{ $stats['active_courses'] > 0 ? '2h 30m' : '0h 0m' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl" style="background: rgba(245,130,32,.04); border: 1px solid rgba(245,130,32,.08);">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                                <svg class="w-4 h-4" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 1.587M7.588 6.42a60.438 60.438 0 00-1.356 3.727m1.356 3.727a60.44 60.44 0 004.89 8.736M7.588 6.42a60.44 60.44 0 015.724 8.736m0 0a60.44 60.44 0 004.89 8.736"/></svg>
                            </div>
                            <span class="text-xs text-[rgba(30,41,59,0.6)]">Lessons Done</span>
                        </div>
                        <span class="text-xs font-bold" style="color: var(--color-terra);">{{ $stats['total_lessons_completed'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
