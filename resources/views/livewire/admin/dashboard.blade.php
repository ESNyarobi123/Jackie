<div class="space-y-6">
    <!-- Admin Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Admin Dashboard</h1>
            <p class="text-xs text-[rgba(30,41,59,0.5)] mt-1">Platform overview & analytics</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold glass-outline hover:bg-[rgba(245,130,32,0.08)] transition" target="_blank">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            View Site
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(59,130,246,.1);">👥</div>
                <div>
                    <div class="text-xl font-bold text-[var(--color-smoke)]">{{ $stats['total_users'] }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">Users</div>
                </div>
            </div>
            <div class="mt-2 text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $stats['total_students'] }} students</div>
        </div>

        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(245,130,32,.1);">📚</div>
                <div>
                    <div class="text-xl font-bold text-[var(--color-terra)]">{{ $stats['total_courses'] }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">Courses</div>
                </div>
            </div>
            <div class="mt-2 text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $stats['active_enrollments'] }} enrollments</div>
        </div>

        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(34,197,94,.1);">💳</div>
                <div>
                    <div class="text-xl font-bold text-green-600">{{ $stats['active_subscriptions'] }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">Subscriptions</div>
                </div>
            </div>
            <div class="mt-2 text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $stats['total_subscriptions'] }} total</div>
        </div>

        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(245,158,11,.1);">🎁</div>
                <div>
                    <div class="text-xl font-bold text-amber-600">{{ $stats['trial_subscriptions'] }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">Free Trials</div>
                </div>
            </div>
            <div class="mt-2 text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $stats['courses_with_trial'] }} courses with trial</div>
        </div>

        <div class="glass-card p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: rgba(139,92,246,.1);">💰</div>
                <div>
                    <div class="text-lg font-bold text-purple-600">TSh {{ number_format($stats['total_revenue']) }}</div>
                    <div class="text-[.625rem] text-[rgba(30,41,59,0.5)] uppercase tracking-wider font-semibold">Revenue</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Live Classes -->
    @if($upcomingLiveClasses->count() > 0)
        <div class="glass-card p-5 rounded-xl glass-soft-shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-[var(--color-smoke)]">Upcoming Live Classes</h2>
                <span class="text-xs font-semibold text-[var(--color-terra)]">{{ $stats['upcoming_live_classes'] }} scheduled</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach($upcomingLiveClasses as $class)
                    <div class="p-4 rounded-xl border border-[rgba(30,41,59,0.06)] bg-[rgba(255,255,255,0.5)]">
                        <div class="flex items-center gap-1.5 mb-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                            <span class="text-[.625rem] font-bold text-red-500 uppercase tracking-wider">Live</span>
                        </div>
                        <h3 class="font-semibold text-sm text-[var(--color-smoke)]">{{ $class->title }}</h3>
                        <p class="text-xs text-[rgba(30,41,59,0.5)]">{{ $class->course->title ?? 'General' }}</p>
                        <p class="text-xs text-[var(--color-terra)] mt-2 font-medium">{{ $class->scheduled_at?->format('M d, h:i A') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Two Column: Enrollments + Users -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Recent Enrollments -->
        <div class="glass-card p-5 rounded-xl glass-soft-shadow">
            <h2 class="text-base font-bold text-[var(--color-smoke)] mb-3">Recent Enrollments</h2>
            <div class="space-y-2">
                @forelse($recentEnrollments as $enrollment)
                    <div class="flex items-center gap-3 p-2.5 rounded-lg bg-[rgba(255,255,255,0.5)]">
                        <div class="w-8 h-8 rounded flex items-center justify-center text-sm" style="background: rgba(245,130,32,.08);">📖</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-xs text-[var(--color-smoke)]">{{ $enrollment->user->name ?? 'Unknown' }}</p>
                            <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $enrollment->course->title ?? 'Unknown' }}</p>
                        </div>
                        <span class="text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $enrollment->enrolled_at?->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-[rgba(30,41,59,0.4)]">No recent enrollments</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="glass-card p-5 rounded-xl glass-soft-shadow">
            <h2 class="text-base font-bold text-[var(--color-smoke)] mb-3">New Users</h2>
            <div class="space-y-2">
                @forelse($recentUsers as $user)
                    <div class="flex items-center gap-3 p-2.5 rounded-lg bg-[rgba(255,255,255,0.5)]">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm" style="background: rgba(59,130,246,.08);">👤</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-xs text-[var(--color-smoke)]">{{ $user->name }}</p>
                            <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $user->email }}</p>
                        </div>
                        <span class="text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $user->created_at?->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-[rgba(30,41,59,0.4)]">No new users</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="glass-card p-5 rounded-xl glass-soft-shadow">
        <h2 class="text-base font-bold text-[var(--color-smoke)] mb-3">Recent Subscriptions</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-[.625rem] text-[rgba(30,41,59,0.4)] uppercase tracking-wider border-b border-[rgba(30,41,59,0.06)]">
                        <th class="pb-2 font-semibold">User</th>
                        <th class="pb-2 font-semibold">Plan</th>
                        <th class="pb-2 font-semibold">Status</th>
                        <th class="pb-2 font-semibold">Date</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @forelse($recentSubscriptions as $subscription)
                        <tr class="border-b border-[rgba(30,41,59,0.04)]">
                            <td class="py-2.5 font-medium">{{ $subscription->user->name ?? 'Unknown' }}</td>
                            <td class="py-2.5 text-[rgba(30,41,59,0.6)]">{{ $subscription->plan_name ?? 'N/A' }}</td>
                            <td class="py-2.5">
                                <span class="px-2 py-0.5 rounded-full text-[.625rem] font-semibold {{ $subscription->status === 'active' ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-500' }}">
                                    {{ $subscription->status }}
                                </span>
                            </td>
                            <td class="py-2.5 text-[rgba(30,41,59,0.4)]">{{ $subscription->created_at?->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-[rgba(30,41,59,0.4)]">No subscriptions yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Management -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <a href="{{ route('admin.courses.index') }}" class="glass-card p-4 rounded-xl text-center hover:shadow-md hover:border-[var(--color-terra)] transition-all group">
            <div class="w-10 h-10 mx-auto rounded-lg flex items-center justify-center text-lg mb-2 group-hover:scale-110 transition" style="background: rgba(245,130,32,.08);">📚</div>
            <div class="font-semibold text-xs text-[var(--color-smoke)]">Courses</div>
            <div class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Manage</div>
        </a>
        <a href="{{ route('admin.users.index') }}" class="glass-card p-4 rounded-xl text-center hover:shadow-md hover:border-[var(--color-terra)] transition-all group">
            <div class="w-10 h-10 mx-auto rounded-lg flex items-center justify-center text-lg mb-2 group-hover:scale-110 transition" style="background: rgba(59,130,246,.08);">👥</div>
            <div class="font-semibold text-xs text-[var(--color-smoke)]">Users</div>
            <div class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Manage</div>
        </a>
        <a href="{{ route('admin.subscriptions.index') }}" class="glass-card p-4 rounded-xl text-center hover:shadow-md hover:border-[var(--color-terra)] transition-all group">
            <div class="w-10 h-10 mx-auto rounded-lg flex items-center justify-center text-lg mb-2 group-hover:scale-110 transition" style="background: rgba(34,197,94,.08);">💳</div>
            <div class="font-semibold text-xs text-[var(--color-smoke)]">Subscriptions</div>
            <div class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Plans</div>
        </a>
        <a href="{{ route('admin.live-classes.index') }}" class="glass-card p-4 rounded-xl text-center hover:shadow-md hover:border-[var(--color-terra)] transition-all group">
            <div class="w-10 h-10 mx-auto rounded-lg flex items-center justify-center text-lg mb-2 group-hover:scale-110 transition" style="background: rgba(139,92,246,.08);">🎥</div>
            <div class="font-semibold text-xs text-[var(--color-smoke)]">Live Classes</div>
            <div class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Schedule</div>
        </a>
    </div>
</div>
