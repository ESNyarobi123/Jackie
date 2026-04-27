<div class="space-y-8">
    <style>
        @keyframes certFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        .cert-fade-up { animation: certFadeUp .4s ease-out both; }
        .cert-fade-up-1 { animation-delay: .05s; }
        .cert-fade-up-2 { animation-delay: .1s; }
        .cert-fade-up-3 { animation-delay: .15s; }
        .cert-card { transition: transform .25s ease, box-shadow .25s ease; }
        .cert-card:hover { transform: translateY(-2px); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(245,130,32,.15); color: #f58220; border: 1px solid rgba(245,130,32,.2);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                        Achievement Unlocked
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">My Certificates</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Your hard-earned credentials. Download and share your achievements.</p>
                </div>
                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold" style="background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1);">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-14.48-5.331A48.636 48.636 0 0112 3.096c5.277 0 10.272 1.26 14.713 3.503M4.26 10.147a48.635 48.635 0 017.74-3.503M4.26 10.148l-.003.003"/></svg>
                    {{ $stats['earned'] ?? 0 }} earned
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-3 gap-4">
        <div class="cert-card relative overflow-hidden rounded-2xl p-5 cert-fade-up cert-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #f58220;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(245,130,32,.08);">
                    <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-14.48-5.331A48.636 48.636 0 0112 3.096c5.277 0 10.272 1.26 14.713 3.503M4.26 10.147a48.635 48.635 0 017.74-3.503M4.26 10.148l-.003.003"/></svg>
                </div>
                <div class="text-2xl font-extrabold" style="color: var(--color-terra);">{{ $stats['earned'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Earned</div>
            </div>
        </div>
        <div class="cert-card relative overflow-hidden rounded-2xl p-5 cert-fade-up cert-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #3b82f6;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(59,130,246,.08);">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-blue-600">{{ $stats['courses'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Courses</div>
            </div>
        </div>
        <div class="cert-card relative overflow-hidden rounded-2xl p-5 cert-fade-up cert-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #22c55e;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(34,197,94,.08);">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-green-600">{{ $stats['courses'] > 0 ? round(($stats['earned'] / $stats['courses']) * 100) : 0 }}%</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Completion</div>
            </div>
        </div>
    </div>

    <!-- Certificates List -->
    <div class="space-y-4">
        @forelse($certificates as $certificate)
            <div class="cert-card rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                <div class="h-1" style="background: linear-gradient(90deg, #f58220, #22c55e);"></div>
                <div class="p-5">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl shrink-0 flex items-center justify-center" style="background: linear-gradient(135deg, rgba(245,130,32,.1), rgba(245,130,32,.04));">
                            <svg class="w-7 h-7" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-14.48-5.331A48.636 48.636 0 0112 3.096c5.277 0 10.272 1.26 14.713 3.503M4.26 10.147a48.635 48.635 0 017.74-3.503M4.26 10.148l-.003.003"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-sm text-(--color-smoke)">{{ $certificate['course'] }}</h3>
                            <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] mt-1 flex items-center gap-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Completed {{ $certificate['completed_at'] }}
                                </span>
                                <span>·</span>
                                <span>Score: {{ $certificate['score'] }}%</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button wire:click="downloadCertificate({{ $certificate['id'] }})" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all hover:scale-105 active:scale-95" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl p-12 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06);">
                <div class="w-20 h-20 mx-auto mb-5 rounded-2xl flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                    <svg class="w-10 h-10" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-14.48-5.331A48.636 48.636 0 0112 3.096c5.277 0 10.272 1.26 14.713 3.503M4.26 10.147a48.635 48.635 0 017.74-3.503M4.26 10.148l-.003.003"/></svg>
                </div>
                <h3 class="font-bold text-xl text-(--color-smoke) mb-2">No Certificates Yet</h3>
                <p class="text-sm text-[rgba(30,41,59,0.5)] mb-5 max-w-md mx-auto">Complete your courses to earn certificates. Keep learning and achieve your goals!</p>
                <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                    Explore Courses
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        @endforelse
    </div>
</div>
