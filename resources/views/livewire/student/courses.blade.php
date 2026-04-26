<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-(--color-terra)">{{ $stats['total'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Total Courses</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-green-500">{{ $stats['active'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Active</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-blue-500">{{ $stats['completed'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Completed</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-amber-500">{{ $stats['expired'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Expired</div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-(--color-smoke)">My Courses</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Continue learning where you left off</p>
        </div>
        <div class="flex items-center gap-3">
            <input type="text" wire:model.live="searchQuery" placeholder="Search courses..."
                   class="px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] text-sm focus:outline-none focus:border-(--color-terra) w-48">
            <a href="{{ route('student.catalog') }}" class="btn-premium">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buy New Course
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 border-b border-[rgba(30,41,59,0.08)] pb-1">
        <button wire:click="setTab('active')" 
                class="px-4 py-2 text-sm font-medium rounded-t-lg transition-colors {{ $activeTab === 'active' ? 'text-[var(--color-terra)] border-b-2 border-[var(--color-terra)] bg-[rgba(245,130,32,0.05)]' : 'text-[rgba(30,41,59,0.6)] hover:text-[var(--color-smoke)]' }}">
            Active
        </button>
        <button wire:click="setTab('completed')" 
                class="px-4 py-2 text-sm font-medium rounded-t-lg transition-colors {{ $activeTab === 'completed' ? 'text-[var(--color-terra)] border-b-2 border-[var(--color-terra)] bg-[rgba(245,130,32,0.05)]' : 'text-[rgba(30,41,59,0.6)] hover:text-[var(--color-smoke)]' }}">
            Completed
        </button>
        <button wire:click="setTab('all')" 
                class="px-4 py-2 text-sm font-medium rounded-t-lg transition-colors {{ $activeTab === 'all' ? 'text-[var(--color-terra)] border-b-2 border-[var(--color-terra)] bg-[rgba(245,130,32,0.05)]' : 'text-[rgba(30,41,59,0.6)] hover:text-[var(--color-smoke)]' }}">
            All
        </button>
    </div>

    <!-- Course Cards Grid -->
    <div class="grid gap-4">
        @forelse($this->filteredEnrollments as $enrollment)
            <div class="glass-card p-5 glass-soft-shadow hover:shadow-lg transition-shadow">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Course Icon -->
                    <div class="w-16 h-16 rounded-xl flex-shrink-0 flex items-center justify-center text-2xl"
                         style="background: linear-gradient(135deg, rgba(245,130,32,0.15), rgba(245,130,32,0.05));">
                        {{ substr($enrollment['course']['title'], 0, 1) }}
                    </div>
                    
                    <!-- Course Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                            <div>
                                <h3 class="font-bold text-lg text-[var(--color-smoke)]">{{ $enrollment['course']['title'] }}</h3>
                                <p class="text-sm text-[rgba(30,41,59,0.6)] mt-1">
                                    {{ $enrollment['progress_percentage'] ?? 0 }}% Complete
                                    @if($enrollment['access_expires_at'])
                                        • Expires: {{ \Carbon\Carbon::parse($enrollment['access_expires_at'])->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                @if($enrollment['status'] === 'active')
                                    <span class="pill pill-green">Active</span>
                                @elseif($enrollment['status'] === 'completed')
                                    <span class="pill pill-blue">Completed</span>
                                @elseif($enrollment['status'] === 'expired')
                                    <span class="pill pill-amber">Expired</span>
                                @else
                                    <span class="pill pill-gray">{{ ucfirst($enrollment['status']) }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-sm mb-2">
                                <span class="text-[rgba(30,41,59,0.6)]">Progress</span>
                                <span class="font-semibold text-(--color-terra)">{{ $enrollment['progress_percentage'] ?? 0 }}%</span>
                            </div>
                            <div class="h-2.5 bg-[rgba(30,41,59,0.08)] rounded-full overflow-hidden">
                                <div class="h-full bg-linear-to-r from-(--color-terra) to-[#F58220] rounded-full transition-all duration-500"
                                     style="width: {{ $enrollment['progress_percentage'] ?? 0 }}%"></div>
                            </div>
                            @if($enrollment['access_expires_at'])
                                <p class="text-xs text-[rgba(30,41,59,0.5)] mt-2 flex items-center gap-1">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    Expires {{ \Carbon\Carbon::parse($enrollment['access_expires_at'])->diffForHumans() }}
                                </p>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex flex-wrap gap-2">
                            @if($enrollment['status'] === 'active')
                                <button wire:click="continueCourse({{ $enrollment['course_id'] }})" class="btn-premium text-sm">
                                    Continue Learning
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                </button>
                            @elseif($enrollment['status'] === 'expired')
                                <button wire:click="renewCourse({{ $enrollment['id'] }})" class="btn-premium text-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                                    Renew Access
                                </button>
                            @elseif($enrollment['status'] === 'completed')
                                <a href="{{ route('student.certificates') }}" class="btn-glass-outline text-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    View Certificate
                                </a>
                            @endif
                            
                            <button class="btn-glass-outline text-sm">Details</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card p-8 text-center glass-elevated">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-[rgba(245,130,32,0.1)] flex items-center justify-center text-4xl">📚</div>
                <h3 class="font-bold text-xl text-(--color-smoke) mb-2">No Courses Yet</h3>
                <p class="text-sm text-[rgba(30,41,59,0.6)] mb-4 max-w-md mx-auto">Start your English learning journey today. Browse our courses and enroll in the one that fits your goals.</p>
                <a href="{{ route('student.catalog') }}" class="btn-premium">
                    Explore Courses
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        @endforelse
    </div>
</div>
