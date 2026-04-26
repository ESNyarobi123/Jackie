<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-xs text-[rgba(30,41,59,0.5)] mt-1">Continue your learning journey</p>
        </div>
        <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Browse Courses
        </a>
    </div>

    <!-- Free Trial Banner -->
    @if(($stats['is_trial'] ?? false))
        <div class="relative overflow-hidden rounded-2xl" style="background: linear-gradient(135deg, rgba(245,158,11,.12), rgba(245,158,11,.04));">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,158,11,.6) 0%, transparent 50%);"></div>
            <div class="relative p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl" style="background: rgba(245,158,11,.15);">🎁</div>
                    <div>
                        <div class="text-sm font-bold text-amber-700">Free Trial Active</div>
                        <div class="text-xs text-[rgba(30,41,59,0.6)]">{{ $stats['trial_days_left'] ?? 0 }} day{{ ($stats['trial_days_left'] ?? 0) !== 1 ? 's' : '' }} remaining · Expires {{ isset($stats['trial_ends_at']) ? \Carbon\Carbon::parse($stats['trial_ends_at'])->format('M d, Y') : 'N/A' }}</div>
                    </div>
                </div>
                <a href="{{ route('student.payments') }}" class="px-4 py-2 rounded-lg text-xs font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                    Subscribe Now
                </a>
            </div>
        </div>
    @endif

    <!-- Stats Grid - Amazing Box Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="relative overflow-hidden glass-card p-5 rounded-2xl group hover:shadow-lg transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-10 -mr-6 -mt-6" style="background: var(--color-terra);"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3" style="background: linear-gradient(135deg, rgba(245,130,32,.15), rgba(245,130,32,.05));">📚</div>
                <div class="text-2xl font-bold text-[var(--color-smoke)]">{{ $stats['active_courses'] }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5 font-medium">Active Courses</div>
            </div>
        </div>

        <div class="relative overflow-hidden glass-card p-5 rounded-2xl group hover:shadow-lg transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-10 -mr-6 -mt-6" style="background: #22c55e;"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3" style="background: linear-gradient(135deg, rgba(34,197,94,.15), rgba(34,197,94,.05));">📊</div>
                <div class="text-2xl font-bold text-[var(--color-terra)]">{{ round($stats['avg_progress']) }}%</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5 font-medium">Progress</div>
                <div class="mt-2 w-full bg-[rgba(30,41,59,0.06)] rounded-full h-1.5">
                    <div class="bg-[var(--color-terra)] h-1.5 rounded-full transition-all duration-500" style="width: {{ $stats['avg_progress'] }}%"></div>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden glass-card p-5 rounded-2xl group hover:shadow-lg transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-10 -mr-6 -mt-6" style="background: #8b5cf6;"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3" style="background: linear-gradient(135deg, rgba(139,92,246,.15), rgba(139,92,246,.05));">🎓</div>
                <div class="text-2xl font-bold text-purple-600">{{ $stats['certificates'] }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5 font-medium">Certificates</div>
            </div>
        </div>

        <div class="relative overflow-hidden glass-card p-5 rounded-2xl group hover:shadow-lg transition-all">
            <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-10 -mr-6 -mt-6" style="background: {{ $subscription ? '#22c55e' : '#ef4444' }};"></div>
            <div class="relative">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3" style="background: linear-gradient(135deg, {{ $subscription ? 'rgba(34,197,94,.15)' : 'rgba(239,68,68,.15)' }}, {{ $subscription ? 'rgba(34,197,94,.05)' : 'rgba(239,68,68,.05)' }});">
                    {{ $subscription ? '✅' : '⚠️' }}
                </div>
                <div class="text-lg font-bold {{ $subscription ? 'text-green-600' : 'text-red-500' }}">
                    {{ ($stats['is_trial'] ?? false) ? 'Free Trial' : ($subscription ? 'Active' : 'Inactive') }}
                </div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5 font-medium">Subscription</div>
                @if(!$subscription)
                    <a href="{{ route('student.catalog') }}" class="mt-1.5 block text-[.625rem] font-semibold text-[var(--color-terra)] hover:underline">Start trial →</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Continue Learning -->
            <div class="glass-card p-5 rounded-xl glass-soft-shadow">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-bold text-[var(--color-smoke)]">Continue Learning</h2>
                    <a href="{{ route('student.courses') }}" class="text-xs font-semibold text-[var(--color-terra)]">View all →</a>
                </div>
                <div class="space-y-2">
                    @forelse($activeEnrollments as $enrollment)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-[rgba(255,255,255,0.5)] hover:bg-[rgba(255,255,255,0.8)] transition">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background: rgba(245,130,32,.08);">
                                {{ $enrollment->course->emoji ?? '📖' }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-xs text-[var(--color-smoke)]">{{ $enrollment->course->title }}</h3>
                                <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] mt-0.5">
                                    {{ (int) floor(($enrollment->progress_percentage / 100) * ($enrollment->course->lessons_count ?? 0)) }} lessons · Enrolled {{ $enrollment->enrolled_at?->diffForHumans() ?? 'Recently' }}
                                </p>
                                <div class="mt-1.5 w-full bg-[rgba(30,41,59,0.06)] rounded-full h-1">
                                    <div class="bg-[var(--color-terra)] h-1 rounded-full transition-all duration-500" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>
                            </div>
                            <a href="{{ route('student.courses') }}" class="px-3 py-1.5 rounded-lg text-[.625rem] font-semibold glass-outline hover:bg-[rgba(245,130,32,0.08)] transition shrink-0">Continue</a>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center text-2xl" style="background: rgba(245,130,32,.08);">📚</div>
                            <p class="text-sm font-semibold text-[var(--color-smoke)] mb-1">No Active Courses</p>
                            <p class="text-xs text-[rgba(30,41,59,0.5)] mb-3">Start your learning journey today!</p>
                            <a href="{{ route('student.catalog') }}" class="text-xs font-semibold text-[var(--color-terra)] hover:underline">Browse courses →</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Next Live Class -->
            @if($nextLiveClass)
                @php($isLive = $nextLiveClass->status?->value === 'live')
                <div class="relative overflow-hidden rounded-xl {{ $isLive ? 'ring-2 ring-red-400/50' : '' }}" style="background: linear-gradient(135deg, {{ $isLive ? 'rgba(239,68,68,.1), rgba(239,68,68,.03)' : 'rgba(245,130,32,.08), rgba(245,130,32,.03)' }});">
                    @if($isLive)
                        <div class="absolute top-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, #ef4444, #f97316, #ef4444);"></div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 mb-2">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $isLive ? 'bg-red-500 animate-pulse' : 'bg-amber-500' }}"></div>
                                    <span class="text-[.625rem] font-bold {{ $isLive ? 'text-red-500' : 'text-amber-600' }} uppercase tracking-wider">
                                        {{ $isLive ? '🔴 Live Now!' : 'Upcoming Live Class' }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-sm text-[var(--color-smoke)]">{{ $nextLiveClass->title }}</h3>
                                <p class="text-xs text-[rgba(30,41,59,0.5)] mt-1">{{ $nextLiveClass->course->title ?? '' }}</p>
                                <p class="text-xs text-[var(--color-terra)] font-medium mt-1">
                                    @if($isLive)
                                        Happening now · Join before it ends!
                                    @else
                                        {{ $nextLiveClass->scheduled_at?->format('M d, h:i A') }} · {{ $nextLiveClass->scheduled_at?->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('student.live-classes.join', $nextLiveClass) }}" wire:navigate class="px-4 py-2.5 rounded-xl text-xs font-semibold transition-all hover:scale-105 {{ $isLive ? 'animate-pulse' : '' }}" style="background: {{ $isLive ? '#ef4444' : 'var(--color-terra)' }}; color: white; box-shadow: 0 4px 14px {{ $isLive ? 'rgba(239,68,68,.35)' : 'rgba(245,130,32,.25)' }};">
                                {{ $isLive ? '🔴 Join Live' : 'Join' }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recommended Courses -->
            @if(is_array($recommendedCourses) && count($recommendedCourses) > 0)
                <div class="glass-card p-5 rounded-xl glass-soft-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-base font-bold text-[var(--color-smoke)]">Recommended</h2>
                        <a href="{{ route('student.catalog') }}" class="text-xs font-semibold text-[var(--color-terra)]">Catalog →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach($recommendedCourses as $course)
                            <div class="p-3 rounded-xl border border-[rgba(30,41,59,0.06)] bg-[rgba(255,255,255,0.5)] hover:shadow-md transition-all">
                                <div class="font-semibold text-xs text-[var(--color-smoke)]">{{ $course['title'] }}</div>
                                <div class="text-[.625rem] text-[rgba(30,41,59,0.4)] mt-1">
                                    {{ $course['lessons_count'] ?? 0 }} lessons · {{ $course['duration_days'] ?? 0 }} days
                                </div>
                                @if(($course['has_free_trial'] ?? false))
                                    <div class="mt-1 text-[.5625rem] font-bold text-green-600">🎁 {{ $course['free_trial_days'] ?? 7 }}-day free trial</div>
                                @endif
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs font-bold text-[var(--color-terra)]">
                                        {{ $course['currency'] ?? 'TZS' }} {{ number_format((float) ($course['price_amount'] ?? 0), 0) }}
                                    </span>
                                    <a href="{{ route('student.catalog') }}" class="text-[.625rem] font-semibold text-[var(--color-terra)] hover:underline">
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
        <div class="space-y-4">
            <!-- Quick Actions -->
            <div class="glass-card p-4 rounded-xl glass-soft-shadow">
                <h3 class="font-bold text-xs text-[var(--color-smoke)] mb-2 uppercase tracking-wider">Quick Actions</h3>
                <div class="space-y-1.5">
                    <a href="{{ route('student.certificates') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-[rgba(245,130,32,0.05)] transition">
                        <span class="text-sm">🎓</span>
                        <span class="text-xs font-medium">Certificates</span>
                    </a>
                    <a href="{{ route('student.payments') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-[rgba(245,130,32,0.05)] transition">
                        <span class="text-sm">💳</span>
                        <span class="text-xs font-medium">Subscription</span>
                    </a>
                    <a href="{{ route('student.catalog') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-[rgba(245,130,32,0.05)] transition">
                        <span class="text-sm">🛒</span>
                        <span class="text-xs font-medium">Browse Courses</span>
                    </a>
                    <a href="{{ route('student.settings') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-[rgba(245,130,32,0.05)] transition">
                        <span class="text-sm">⚙️</span>
                        <span class="text-xs font-medium">Settings</span>
                    </a>
                </div>
            </div>

            <!-- This Week -->
            <div class="glass-card p-4 rounded-xl glass-soft-shadow">
                <h3 class="font-bold text-xs text-[var(--color-smoke)] mb-2 uppercase tracking-wider">This Week</h3>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-[rgba(30,41,59,0.5)]">Study Time</span>
                        <span class="text-xs font-bold text-[var(--color-terra)]">{{ $stats['active_courses'] > 0 ? '2h 30m' : '0h 0m' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-[rgba(30,41,59,0.5)]">Lessons Done</span>
                        <span class="text-xs font-bold text-[var(--color-terra)]">{{ $stats['total_lessons_completed'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
