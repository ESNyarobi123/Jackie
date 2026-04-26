<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-(--color-terra)">{{ $stats['upcoming'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Upcoming</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-green-500">{{ $stats['this_week'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">This Week</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-blue-500">{{ $stats['attended'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Attended</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-purple-500">{{ $stats['recordings'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Recordings</div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-(--color-smoke)">Live Classes</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Join live interactive sessions with Jackie</p>
        </div>
        @if(count($upcomingClasses) > 0)
            <div class="text-sm text-[rgba(30,41,59,0.6)]">
                🔔 <span class="font-semibold text-(--color-terra)">{{ count($upcomingClasses) }}</span> upcoming classes
            </div>
        @endif
    </div>

    <!-- Live Now / Next Class -->
    @if(count($upcomingClasses) > 0)
        @php $nextClass = $upcomingClasses[0]; @endphp
        @php($isLiveNow = ($nextClass['status'] ?? '') === 'live')
        <div class="glass-card p-6 glass-elevated {{ $isLiveNow ? 'ring-2 ring-red-400/50' : '' }}" style="background: linear-gradient(135deg, {{ $isLiveNow ? 'rgba(239,68,68,0.08), rgba(239,68,68,0.02)' : 'rgba(245,130,32,0.08), rgba(245,130,32,0.02)' }});">
            @if($isLiveNow)
                <div class="absolute top-0 left-0 right-0 h-1 rounded-t-xl" style="background: linear-gradient(90deg, #ef4444, #f97316, #ef4444);"></div>
            @endif
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 rounded-full {{ $isLiveNow ? 'bg-red-500 animate-pulse' : 'bg-amber-500' }}"></div>
                        <span class="text-xs font-bold {{ $isLiveNow ? 'text-red-500' : 'text-amber-600' }} uppercase tracking-wider">
                            {{ $isLiveNow ? '🔴 Live Now!' : 'Coming Up Soon' }}
                        </span>
                    </div>
                    <h2 class="text-xl font-bold text-[var(--color-smoke)]">{{ $nextClass['title'] }}</h2>
                    <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">{{ $nextClass['course']['title'] ?? '' }}</p>
                    <div class="flex items-center gap-4 mt-3 text-sm text-[rgba(30,41,59,0.6)]">
                        @if($isLiveNow)
                            <span class="text-red-500 font-semibold">🔴 Happening now!</span>
                        @else
                            <span>📅 {{ \Carbon\Carbon::parse($nextClass['scheduled_at'])->format('l, M d') }}</span>
                            <span>🕐 {{ \Carbon\Carbon::parse($nextClass['scheduled_at'])->format('h:i A') }}</span>
                        @endif
                        <span>⏱️ {{ $nextClass['duration_minutes'] ?? 60 }} minutes</span>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('student.live-classes.join', $nextClass['id']) }}" wire:navigate class="btn-premium shrink-0 {{ $isLiveNow ? 'animate-pulse' : '' }}" style="{{ $isLiveNow ? 'background: #ef4444; box-shadow: 0 4px 14px rgba(239,68,68,.35);' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        {{ $isLiveNow ? 'Join Live' : 'Join' }}
                    </a>
                    @if(! $isLiveNow)
                        <button wire:click="setReminder({{ $nextClass['id'] }})" class="btn-glass-outline text-xs shrink-0">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            Set Reminder
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Upcoming Classes -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">This Week's Schedule</h2>
        
        <div class="space-y-3">
            @forelse(array_slice($upcomingClasses, 1) as $class)
                <div class="flex items-center gap-4 p-3 rounded-lg bg-[rgba(255,255,255,0.4)] border border-[rgba(30,41,59,0.05)]">
                    <div class="w-12 h-12 rounded-lg shrink-0 flex items-center justify-center text-lg"
                         style="background: linear-gradient(135deg, rgba(245,130,32,0.12), rgba(245,130,32,0.04));">
                        🎥
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-[var(--color-smoke)]">{{ $class['title'] }}</h3>
                        <p class="text-xs text-[rgba(30,41,59,0.6)]">{{ $class['course']['title'] ?? '' }} • {{ \Carbon\Carbon::parse($class['scheduled_at'])->format('D, h:i A') }}</p>
                    </div>
                    <span class="pill pill-blue shrink-0">{{ \Carbon\Carbon::parse($class['scheduled_at'])->diffForHumans() }}</span>
                    <a href="{{ route('student.live-classes.join', $class['id']) }}" wire:navigate class="btn-glass-outline text-xs shrink-0">
                        Room
                    </a>
                </div>
            @empty
                <div class="text-center py-6">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[rgba(30,41,59,0.06)] flex items-center justify-center text-2xl">📅</div>
                    <p class="text-[rgba(30,41,59,0.6)]">No live classes scheduled</p>
                    <p class="text-xs text-[rgba(30,41,59,0.5)] mt-1">Check back later for new sessions</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Past Classes / Recordings -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Past Recordings</h2>
        
        <div class="space-y-3">
            @forelse($pastClasses as $class)
                <div class="flex items-center gap-4 p-3 rounded-lg bg-[rgba(255,255,255,0.3)] border border-[rgba(30,41,59,0.05)]">
                    <div class="w-12 h-12 rounded-lg shrink-0 flex items-center justify-center text-lg"
                         style="background: rgba(30,41,59,0.06);">
                        ▶️
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-[var(--color-smoke)]">{{ $class['title'] }}</h3>
                        <p class="text-xs text-[rgba(30,41,59,0.6)]">{{ \Carbon\Carbon::parse($class['scheduled_at'])->format('M d, Y') }} • {{ $class['duration_minutes'] ?? 60 }} min</p>
                    </div>
                    <span class="pill pill-gray shrink-0">No Recording</span>
                </div>
            @empty
                <div class="text-center py-6">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[rgba(30,41,59,0.06)] flex items-center justify-center text-2xl">📹</div>
                    <p class="text-[rgba(30,41,59,0.6)]">No recordings yet</p>
                    <p class="text-xs text-[rgba(30,41,59,0.5)] mt-1">Past class recordings will appear here</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
