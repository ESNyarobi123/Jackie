<div class="space-y-8">
    <style>
        @keyframes prgFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes prgProgress { from { width: 0%; } }
        .prg-fade-up { animation: prgFadeUp .4s ease-out both; }
        .prg-fade-up-1 { animation-delay: .05s; }
        .prg-fade-up-2 { animation-delay: .1s; }
        .prg-fade-up-3 { animation-delay: .15s; }
        .prg-fade-up-4 { animation-delay: .2s; }
        .prg-progress-fill { animation: prgProgress 1s ease-out both; animation-delay: .3s; }
        .prg-card { transition: transform .25s ease, box-shadow .25s ease; }
        .prg-card:hover { transform: translateY(-2px); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(34,197,94,.15); color: #22c55e; border: 1px solid rgba(34,197,94,.2);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                        {{ $stats['overall_progress'] ?? 0 }}% Overall
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">My Progress</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Track your learning across all courses. See how far you've come.</p>
                </div>
                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold" style="background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1);">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    {{ $stats['total_enrollments'] ?? 0 }} courses
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="prg-card relative overflow-hidden rounded-2xl p-5 prg-fade-up prg-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #22c55e;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(34,197,94,.08);">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-green-600">{{ $stats['completed_lessons'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Lessons Done</div>
            </div>
        </div>
        <div class="prg-card relative overflow-hidden rounded-2xl p-5 prg-fade-up prg-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #f58220;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(245,130,32,.08);">
                    <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <div class="text-2xl font-extrabold" style="color: var(--color-terra);">{{ $stats['avg_score'] ?? 0 }}%</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Avg Score</div>
            </div>
        </div>
        <div class="prg-card relative overflow-hidden rounded-2xl p-5 prg-fade-up prg-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #8b5cf6;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(139,92,246,.08);">
                    <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.251l.003-.003a5.408 5.408 0 017.299 0 .75.75 0 01-.998 1.122 3.908 3.908 0 00-5.303 0 .75.75 0 01-.998-1.12zM6.24 11.28l.003-.003a8.407 8.407 0 0111.518 0 .75.75 0 01-.998 1.122 6.907 6.907 0 00-9.522 0 .75.75 0 01-.998-1.12zm12.026 5.942l.002.002a2.408 2.408 0 01-3.24 0 .75.75 0 01.998-1.122.908.908 0 001.244 0 .75.75 0 01.998 1.122z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-purple-600">{{ $stats['live_attended'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Live Classes</div>
            </div>
        </div>
        <div class="prg-card relative overflow-hidden rounded-2xl p-5 prg-fade-up prg-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #3b82f6;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(59,130,246,.08);">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-blue-600">{{ $stats['total_enrollments'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Enrolled</div>
            </div>
        </div>
    </div>

    <!-- Course Progress -->
    <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #f58220, rgba(245,130,32,.2));"></div>
            <h2 class="text-base font-bold text-(--color-smoke)">Course Progress</h2>
        </div>
        <div class="space-y-4">
            @forelse($courseProgress as $progress)
                <div class="p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                                <svg class="w-4 h-4" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            </div>
                            <span class="font-semibold text-sm text-(--color-smoke)">{{ $progress['course'] }}</span>
                        </div>
                        <span class="text-sm font-bold" style="color: {{ $progress['progress'] >= 100 ? '#22c55e' : 'var(--color-terra)' }};">{{ $progress['progress'] }}%</span>
                    </div>
                    <div class="bg-[rgba(30,41,59,0.06)] rounded-full h-2.5 overflow-hidden">
                        <div class="h-2.5 rounded-full prg-progress-fill" style="width: {{ $progress['progress'] }}%; background: {{ $progress['progress'] >= 100 ? 'linear-gradient(90deg, #22c55e, #16a34a)' : 'linear-gradient(90deg, #f58220, #22c55e)' }};"></div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center" style="background: rgba(30,41,59,.04);">
                        <svg class="w-8 h-8 text-[rgba(30,41,59,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <p class="text-sm text-[rgba(30,41,59,0.5)]">You haven't enrolled in any courses yet</p>
                    <a href="{{ route('student.catalog') }}" class="text-sm font-semibold hover:underline mt-2 inline-block" style="color: var(--color-terra);">Browse courses →</a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quiz Scores -->
    <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #3b82f6, rgba(59,130,246,.2));"></div>
            <h2 class="text-base font-bold text-(--color-smoke)">Quiz Scores</h2>
        </div>
        <div class="space-y-2">
            @forelse($quizScores as $quiz)
                <div class="flex items-center justify-between p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: rgba(59,130,246,.08);">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>
                        </div>
                        <span class="text-sm font-medium text-(--color-smoke)">{{ $quiz['title'] ?? 'Quiz' }}</span>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: {{ ($quiz['score'] ?? 0) >= 70 ? 'rgba(34,197,94,.08)' : 'rgba(245,158,11,.08)' }}; color: {{ ($quiz['score'] ?? 0) >= 70 ? '#16a34a' : '#d97706' }};">{{ $quiz['score'] ?? 'Not Done' }}{{ isset($quiz['score']) && is_numeric($quiz['score']) ? '%' : '' }}</span>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center" style="background: rgba(59,130,246,.06);">
                        <svg class="w-8 h-8 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>
                    </div>
                    <p class="text-sm text-[rgba(30,41,59,0.5)]">No quiz scores yet</p>
                    <p class="text-xs text-[rgba(30,41,59,0.4)] mt-1">Complete quizzes to see your scores here</p>
                </div>
            @endforelse
        </div>
    </div>
</div>