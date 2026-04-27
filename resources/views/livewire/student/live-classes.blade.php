<div class="space-y-8">
    <style>
        @keyframes lcFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes lcLivePulse { 0%,100% { box-shadow: 0 0 0 0 rgba(239,68,68,.4); } 50% { box-shadow: 0 0 0 8px rgba(239,68,68,0); } }
        .lc-fade-up { animation: lcFadeUp .4s ease-out both; }
        .lc-fade-up-1 { animation-delay: .05s; }
        .lc-fade-up-2 { animation-delay: .1s; }
        .lc-fade-up-3 { animation-delay: .15s; }
        .lc-fade-up-4 { animation-delay: .2s; }
        .lc-live-pulse { animation: lcLivePulse 2s ease-in-out infinite; }
        .lc-card { transition: transform .25s ease, box-shadow .25s ease; }
        .lc-card:hover { transform: translateY(-2px); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(239,68,68,.15); color: #ef4444; border: 1px solid rgba(239,68,68,.2);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.251l.003-.003a5.408 5.408 0 017.299 0 .75.75 0 01-.998 1.122 3.908 3.908 0 00-5.303 0 .75.75 0 01-.998-1.12zM6.24 11.28l.003-.003a8.407 8.407 0 0111.518 0 .75.75 0 01-.998 1.122 6.907 6.907 0 00-9.522 0 .75.75 0 01-.998-1.12zm12.026 5.942l.002.002a2.408 2.408 0 01-3.24 0 .75.75 0 01.998-1.122.908.908 0 001.244 0 .75.75 0 01.998 1.122z"/></svg>
                        Live Interactive Sessions
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">Live Classes</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Join live interactive sessions with Jackie. Learn, practice, and grow together.</p>
                </div>
                @if(count($upcomingClasses) > 0)
                    <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold" style="background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                        {{ count($upcomingClasses) }} upcoming
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="lc-card relative overflow-hidden rounded-2xl p-5 lc-fade-up lc-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #f58220;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(245,130,32,.08);">
                    <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div class="text-2xl font-extrabold" style="color: var(--color-terra);">{{ $stats['upcoming'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Upcoming</div>
            </div>
        </div>
        <div class="lc-card relative overflow-hidden rounded-2xl p-5 lc-fade-up lc-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #22c55e;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(34,197,94,.08);">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-green-600">{{ $stats['this_week'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">This Week</div>
            </div>
        </div>
        <div class="lc-card relative overflow-hidden rounded-2xl p-5 lc-fade-up lc-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #3b82f6;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(59,130,246,.08);">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-blue-600">{{ $stats['attended'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Attended</div>
            </div>
        </div>
        <div class="lc-card relative overflow-hidden rounded-2xl p-5 lc-fade-up lc-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #8b5cf6;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(139,92,246,.08);">
                    <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-purple-600">{{ $stats['recordings'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Recordings</div>
            </div>
        </div>
    </div>

    <!-- Live Now / Next Class -->
    @if(count($upcomingClasses) > 0)
        @php $nextClass = $upcomingClasses[0]; @endphp
        @php($isLiveNow = ($nextClass['status'] ?? '') === 'live')
        <div class="relative overflow-hidden rounded-2xl {{ $isLiveNow ? 'ring-2 ring-red-400/50' : '' }}" style="background: {{ $isLiveNow ? 'linear-gradient(135deg, rgba(239,68,68,.06), rgba(239,68,68,.02))' : 'linear-gradient(135deg, rgba(245,130,32,.06), rgba(245,130,32,.02))' }}; border: 1px solid {{ $isLiveNow ? 'rgba(239,68,68,.15)' : 'rgba(245,130,32,.12)' }};">
            @if($isLiveNow)
                <div class="absolute top-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, #ef4444, #f97316, #ef4444);"></div>
            @endif
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 {{ $isLiveNow ? 'lc-live-pulse' : '' }}" style="background: {{ $isLiveNow ? 'rgba(239,68,68,.1)' : 'rgba(245,130,32,.1)' }};">
                            @if($isLiveNow)
                                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.251l.003-.003a5.408 5.408 0 017.299 0 .75.75 0 01-.998 1.122 3.908 3.908 0 00-5.303 0 .75.75 0 01-.998-1.12zM6.24 11.28l.003-.003a8.407 8.407 0 0111.518 0 .75.75 0 01-.998 1.122 6.907 6.907 0 00-9.522 0 .75.75 0 01-.998-1.12zm12.026 5.942l.002.002a2.408 2.408 0 01-3.24 0 .75.75 0 01.998-1.122.908.908 0 001.244 0 .75.75 0 01.998 1.122z"/></svg>
                            @else
                                <svg class="w-7 h-7" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.96-1.802-3.169a23.61 23.61 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5 mb-1">
                                <span class="w-1.5 h-1.5 rounded-full {{ $isLiveNow ? 'bg-red-500 animate-pulse' : 'bg-amber-500' }}"></span>
                                <span class="text-[.625rem] font-bold {{ $isLiveNow ? 'text-red-500' : 'text-amber-600' }} uppercase tracking-wider">
                                    {{ $isLiveNow ? 'Live Now!' : 'Coming Up Soon' }}
                                </span>
                            </div>
                            <h2 class="text-xl font-bold text-(--color-smoke)">{{ $nextClass['title'] }}</h2>
                            <p class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-0.5">{{ $nextClass['course']['title'] ?? '' }}</p>
                            <div class="flex items-center gap-3 mt-2 text-[.6875rem] text-[rgba(30,41,59,0.5)]">
                                @if($isLiveNow)
                                    <span class="font-semibold text-red-500">Happening now!</span>
                                @else
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                        {{ \Carbon\Carbon::parse($nextClass['scheduled_at'])->format('l, M d · h:i A') }}
                                    </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $nextClass['duration_minutes'] ?? 60 }} min
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('student.live-classes.join', $nextClass['id']) }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 {{ $isLiveNow ? 'animate-pulse' : '' }}" style="background: {{ $isLiveNow ? '#ef4444' : 'var(--color-terra)' }}; color: white; box-shadow: 0 4px 14px {{ $isLiveNow ? 'rgba(239,68,68,.3)' : 'rgba(245,130,32,.25)' }};">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                            {{ $isLiveNow ? 'Join Live' : 'Join Class' }}
                        </a>
                        @if(! $isLiveNow)
                            <button wire:click="setReminder({{ $nextClass['id'] }})" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-105" style="background: rgba(245,130,32,.08); border: 1px solid rgba(245,130,32,.12);" title="Set Reminder">
                                <svg class="w-4 h-4" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Upcoming Classes -->
    <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #f58220, rgba(245,130,32,.2));"></div>
            <h2 class="text-base font-bold text-(--color-smoke)">This Week's Schedule</h2>
        </div>
        <div class="space-y-3">
            @forelse(array_slice($upcomingClasses, 1) as $class)
                <div class="lc-card flex items-center gap-4 p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                    <div class="w-12 h-12 rounded-xl shrink-0 flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                        <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.96-1.802-3.169a23.61 23.61 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm text-(--color-smoke)">{{ $class['title'] }}</h3>
                        <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ $class['course']['title'] ?? '' }} · {{ \Carbon\Carbon::parse($class['scheduled_at'])->format('D, h:i A') }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: rgba(59,130,246,.08); color: #2563eb;">{{ \Carbon\Carbon::parse($class['scheduled_at'])->diffForHumans() }}</span>
                    <a href="{{ route('student.live-classes.join', $class['id']) }}" wire:navigate class="px-4 py-2 rounded-xl text-[.6875rem] font-semibold transition-all hover:scale-105 active:scale-95 shrink-0" style="background: rgba(245,130,32,.08); color: var(--color-terra);">
                        Room
                    </a>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center" style="background: rgba(30,41,59,.04);">
                        <svg class="w-8 h-8 text-[rgba(30,41,59,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <p class="text-sm text-[rgba(30,41,59,0.5)]">No live classes scheduled</p>
                    <p class="text-xs text-[rgba(30,41,59,0.4)] mt-1">Check back later for new sessions</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Past Classes / Recordings -->
    <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #8b5cf6, rgba(139,92,246,.2));"></div>
            <h2 class="text-base font-bold text-(--color-smoke)">Past Recordings</h2>
        </div>
        <div class="space-y-3">
            @forelse($pastClasses as $class)
                <div class="flex items-center gap-4 p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.3);">
                    <div class="w-12 h-12 rounded-xl shrink-0 flex items-center justify-center" style="background: rgba(139,92,246,.08);">
                        <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm text-(--color-smoke)">{{ $class['title'] }}</h3>
                        <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">{{ \Carbon\Carbon::parse($class['scheduled_at'])->format('M d, Y') }} · {{ $class['duration_minutes'] ?? 60 }} min</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: rgba(30,41,59,.04); color: rgba(30,41,59,.4);">No Recording</span>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center" style="background: rgba(139,92,246,.06);">
                        <svg class="w-8 h-8 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                    </div>
                    <p class="text-sm text-[rgba(30,41,59,0.5)]">No recordings yet</p>
                    <p class="text-xs text-[rgba(30,41,59,0.4)] mt-1">Past class recordings will appear here</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
