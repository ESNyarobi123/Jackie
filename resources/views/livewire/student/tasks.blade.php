<div class="space-y-8">
    <style>
        @keyframes taskFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes taskProgress { from { width: 0%; } }
        .task-fade-up { animation: taskFadeUp .4s ease-out both; }
        .task-fade-up-1 { animation-delay: .05s; }
        .task-fade-up-2 { animation-delay: .1s; }
        .task-fade-up-3 { animation-delay: .15s; }
        .task-fade-up-4 { animation-delay: .2s; }
        .task-progress-fill { animation: taskProgress 1s ease-out both; animation-delay: .3s; }
        .task-card { transition: transform .25s ease, box-shadow .25s ease; }
        .task-card:hover { transform: translateY(-2px); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(245,130,32,.15); color: #f58220; border: 1px solid rgba(245,130,32,.2);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $stats['progress'] ?? 0 }}% Complete
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">My Tasks</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Your learning journey, one lesson at a time. Stay on track and achieve your goals.</p>
                </div>
                @if(($stats['pending'] ?? 0) > 0)
                    <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold" style="background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $stats['pending'] }} waiting
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="task-card relative overflow-hidden rounded-2xl p-5 task-fade-up task-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #f58220;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(245,130,32,.08);">
                    <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-(--color-smoke)">{{ $stats['total'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Total</div>
            </div>
        </div>
        <div class="task-card relative overflow-hidden rounded-2xl p-5 task-fade-up task-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #f59e0b;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(245,158,11,.08);">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-amber-600">{{ $stats['pending'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Pending</div>
            </div>
        </div>
        <div class="task-card relative overflow-hidden rounded-2xl p-5 task-fade-up task-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #22c55e;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(34,197,94,.08);">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-green-600">{{ $stats['completed'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Completed</div>
            </div>
        </div>
        <div class="task-card relative overflow-hidden rounded-2xl p-5 task-fade-up task-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #3b82f6;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(59,130,246,.08);">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-blue-600">{{ $stats['progress'] ?? 0 }}%</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Progress</div>
            </div>
        </div>
    </div>

    <!-- Overall Progress -->
    <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-3">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #f58220, rgba(245,130,32,.2));"></div>
            <span class="text-sm font-bold text-(--color-smoke)">Overall Progress</span>
            <span class="ml-auto text-sm font-bold" style="color: var(--color-terra);">{{ $stats['progress'] ?? 0 }}%</span>
        </div>
        <div class="bg-[rgba(30,41,59,0.06)] rounded-full h-3 overflow-hidden">
            <div class="h-3 rounded-full task-progress-fill" style="width: {{ $stats['progress'] ?? 0 }}%; background: linear-gradient(90deg, #f58220, #22c55e);"></div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-1 p-1 rounded-xl" style="background: rgba(30,41,59,.04);">
        <button wire:click="setTab('pending')"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'pending' ? 'text-white shadow-sm' : 'text-[rgba(30,41,59,0.5)] hover:text-(--color-smoke) hover:bg-[rgba(255,255,255,0.5)]' }}"
                style="{{ $activeTab === 'pending' ? 'background: var(--color-terra);' : '' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pending
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[.5625rem] font-bold {{ $activeTab === 'pending' ? 'bg-white/20 text-white' : 'bg-[rgba(245,158,11,.1)] text-amber-600' }}">{{ count($pendingTasks) }}</span>
        </button>
        <button wire:click="setTab('completed')"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'completed' ? 'text-white shadow-sm' : 'text-[rgba(30,41,59,0.5)] hover:text-(--color-smoke) hover:bg-[rgba(255,255,255,0.5)]' }}"
                style="{{ $activeTab === 'completed' ? 'background: var(--color-terra);' : '' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Completed
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[.5625rem] font-bold {{ $activeTab === 'completed' ? 'bg-white/20 text-white' : 'bg-[rgba(34,197,94,.1)] text-green-600' }}">{{ count($completedTasks) }}</span>
        </button>
    </div>

    <!-- Tasks List -->
    <div class="space-y-3">
        @if($activeTab === 'pending')
            @forelse($pendingTasks as $index => $task)
                <div class="task-card rounded-2xl overflow-hidden {{ isset($task['is_next']) ? 'ring-1 ring-[rgba(245,130,32,0.2)]' : '' }}" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                    @if(isset($task['is_next']))
                        <div class="h-1" style="background: linear-gradient(90deg, #f58220, #22c55e);"></div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl shrink-0 flex items-center justify-center" style="background: {{ isset($task['is_next']) ? 'rgba(245,130,32,.1)' : 'rgba(30,41,59,.04)' }};">
                                @if(isset($task['is_next']))
                                    <svg class="w-6 h-6" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                                @else
                                    <svg class="w-6 h-6 text-[rgba(30,41,59,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="font-bold text-sm text-(--color-smoke)">{{ $task['title'] }}</h3>
                                    @if(isset($task['is_next']))
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[.5625rem] font-bold" style="background: rgba(245,130,32,.1); color: #f58220;">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.14 3.524a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.52a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.14-3.523a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                                            Next Up
                                        </span>
                                    @endif
                                </div>
                                <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] mt-1 flex items-center gap-2 flex-wrap">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                        {{ $task['course'] }}
                                    </span>
                                    <span>·</span>
                                    <span>{{ $task['duration'] }}</span>
                                    <span>·</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                        {{ $task['due'] }}
                                    </span>
                                </p>
                            </div>
                            <div class="shrink-0">
                                @if(isset($task['is_next']))
                                    <button wire:click="startTask({{ $task['id'] }})" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all hover:scale-105 active:scale-95" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                                        Start Now
                                    </button>
                                @else
                                    <button wire:click="startTask({{ $task['id'] }})" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all hover:scale-105" style="background: rgba(30,41,59,.04); color: rgba(30,41,59,.6);">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        View
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl p-12 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06);">
                    <div class="w-20 h-20 mx-auto mb-5 rounded-2xl flex items-center justify-center" style="background: rgba(34,197,94,.08);">
                        <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-xl text-(--color-smoke) mb-2">All Caught Up!</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.5)] mb-5 max-w-md mx-auto">You've completed all your tasks. Time to explore new courses?</p>
                    <a href="{{ route('home') }}#courses" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                        Browse Courses
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            @endforelse
        @else
            @forelse($completedTasks as $task)
                <div class="task-card rounded-2xl overflow-hidden opacity-75 hover:opacity-100 transition-opacity" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                    <div class="h-0.5" style="background: linear-gradient(90deg, #22c55e, rgba(34,197,94,.2));"></div>
                    <div class="p-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl shrink-0 flex items-center justify-center" style="background: rgba(34,197,94,.08);">
                                <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-sm text-(--color-smoke) line-through">{{ $task['title'] }}</h3>
                                <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] mt-1">
                                    {{ $task['course'] }} · {{ $task['duration'] }} · Completed {{ $task['completed_at'] }}
                                </p>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: rgba(34,197,94,.08); color: #16a34a;">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Done
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl p-12 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06);">
                    <div class="w-20 h-20 mx-auto mb-5 rounded-2xl flex items-center justify-center" style="background: rgba(30,41,59,.04);">
                        <svg class="w-10 h-10 text-[rgba(30,41,59,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-xl text-(--color-smoke) mb-2">No Completed Tasks Yet</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.5)]">Start learning to see your progress here!</p>
                </div>
            @endforelse
        @endif
    </div>
</div>