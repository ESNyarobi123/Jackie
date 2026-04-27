<div class="space-y-8">
    <style>
        @keyframes crsFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes crsProgress { from { width: 0%; } }
        .crs-fade-up { animation: crsFadeUp .4s ease-out both; }
        .crs-fade-up-1 { animation-delay: .05s; }
        .crs-fade-up-2 { animation-delay: .1s; }
        .crs-fade-up-3 { animation-delay: .15s; }
        .crs-fade-up-4 { animation-delay: .2s; }
        .crs-progress-fill { animation: crsProgress 1s ease-out both; animation-delay: .3s; }
        .crs-card { transition: transform .25s ease, box-shadow .25s ease; }
        .crs-card:hover { transform: translateY(-2px); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(245,130,32,.15); color: #f58220; border: 1px solid rgba(245,130,32,.2);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        {{ $stats['active'] ?? 0 }} Active Courses
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">My Courses</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Continue learning where you left off. Track your progress and achieve your goals.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[rgba(255,255,255,.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <input type="text" wire:model.live="searchQuery" placeholder="Search courses..."
                               class="w-full sm:w-56 pl-10 pr-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(245,130,32,0.3)] transition-all" style="background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1);">
                    </div>
                    <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.3);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        New Course
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="crs-card relative overflow-hidden rounded-2xl p-5 crs-fade-up crs-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #f58220;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(245,130,32,.08);">
                    <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-(--color-smoke)">{{ $stats['total'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Total</div>
            </div>
        </div>
        <div class="crs-card relative overflow-hidden rounded-2xl p-5 crs-fade-up crs-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #22c55e;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(34,197,94,.08);">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-green-600">{{ $stats['active'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Active</div>
            </div>
        </div>
        <div class="crs-card relative overflow-hidden rounded-2xl p-5 crs-fade-up crs-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #3b82f6;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(59,130,246,.08);">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-blue-600">{{ $stats['completed'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Completed</div>
            </div>
        </div>
        <div class="crs-card relative overflow-hidden rounded-2xl p-5 crs-fade-up crs-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full opacity-[.06]" style="background: #f59e0b;"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-2" style="background: rgba(245,158,11,.08);">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-2xl font-extrabold text-amber-600">{{ $stats['expired'] ?? 0 }}</div>
                <div class="text-[.6875rem] text-[rgba(30,41,59,0.5)] font-medium">Expired</div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-1 p-1 rounded-xl" style="background: rgba(30,41,59,.04);">
        <button wire:click="setTab('active')"
                class="flex-1 px-4 py-2.5 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'active' ? 'text-white shadow-sm' : 'text-[rgba(30,41,59,0.5)] hover:text-(--color-smoke) hover:bg-[rgba(255,255,255,0.5)]' }}"
                style="{{ $activeTab === 'active' ? 'background: var(--color-terra);' : '' }}">
            Active
        </button>
        <button wire:click="setTab('completed')"
                class="flex-1 px-4 py-2.5 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'completed' ? 'text-white shadow-sm' : 'text-[rgba(30,41,59,0.5)] hover:text-(--color-smoke) hover:bg-[rgba(255,255,255,0.5)]' }}"
                style="{{ $activeTab === 'completed' ? 'background: var(--color-terra);' : '' }}">
            Completed
        </button>
        <button wire:click="setTab('all')"
                class="flex-1 px-4 py-2.5 text-sm font-semibold rounded-lg transition-all {{ $activeTab === 'all' ? 'text-white shadow-sm' : 'text-[rgba(30,41,59,0.5)] hover:text-(--color-smoke) hover:bg-[rgba(255,255,255,0.5)]' }}"
                style="{{ $activeTab === 'all' ? 'background: var(--color-terra);' : '' }}">
            All
        </button>
    </div>

    <!-- Course Cards -->
    <div class="space-y-4">
        @forelse($this->filteredEnrollments as $enrollment)
            @php
                $courseImages = [
                    'spoken' => 'https://images.unsplash.com/photo-1543165796-5426273eaab3?w=400&q=80',
                    'business' => 'https://images.unsplash.com/photo-1552664733-d6d7a8a4345?w=400&q=80',
                    'ielts' => 'https://images.unsplash.com/photo-1456511780578-1a7e62e0c3c5?w=400&q=80',
                    'default' => 'https://images.unsplash.com/photo-1509062523349-8427d3e7e577?w=400&q=80',
                ];
                $imgKey = str_contains(strtolower($enrollment['course']['title']), 'spoken') ? 'spoken'
                    : (str_contains(strtolower($enrollment['course']['title']), 'business') ? 'business'
                    : (str_contains(strtolower($enrollment['course']['title']), 'ielts') ? 'ielts'
                    : 'default'));
                $courseImg = $courseImages[$imgKey];
                $statusColors = [
                    'active' => ['bg' => 'rgba(34,197,94,.08)', 'text' => '#16a34a', 'border' => 'rgba(34,197,94,.15)'],
                    'completed' => ['bg' => 'rgba(59,130,246,.08)', 'text' => '#2563eb', 'border' => 'rgba(59,130,246,.15)'],
                    'expired' => ['bg' => 'rgba(245,158,11,.08)', 'text' => '#d97706', 'border' => 'rgba(245,158,11,.15)'],
                ];
                $sc = $statusColors[$enrollment['status']] ?? ['bg' => 'rgba(30,41,59,.04)', 'text' => '#6b7280', 'border' => 'rgba(30,41,59,.08)'];
            @endphp

            <div class="crs-card rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                <div class="flex flex-col md:flex-row">
                    <!-- Course Image -->
                    <div class="relative w-full md:w-48 h-36 md:h-auto shrink-0 overflow-hidden" style="background: #f0f0f0;">
                        <img src="{{ $courseImg }}" alt="{{ $enrollment['course']['title'] }}" class="w-full h-full object-cover" loading="lazy" onerror="this.style.display='none'" />
                        <div class="absolute inset-0" style="background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,.3) 100%);"></div>
                        <div class="absolute bottom-2 left-2">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[.5625rem] font-bold text-white" style="background: {{ $sc['bg'] }}; border: 1px solid {{ $sc['border'] }}; color: {{ $sc['text'] }}; backdrop-filter: blur(4px);">
                                {{ ucfirst($enrollment['status']) }}
                            </span>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="flex-1 p-5">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="font-bold text-lg text-(--color-smoke)">{{ $enrollment['course']['title'] }}</h3>
                                <p class="text-[.6875rem] text-[rgba(30,41,59,0.5)] mt-1">
                                    {{ $enrollment['progress_percentage'] ?? 0 }}% complete
                                    @if($enrollment['access_expires_at'])
                                        · Expires {{ \Carbon\Carbon::parse($enrollment['access_expires_at'])->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                @if($enrollment['status'] === 'active')
                                    <button wire:click="continueCourse({{ $enrollment['course_id'] }})" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:scale-105 active:scale-95" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                                        Continue
                                    </button>
                                @elseif($enrollment['status'] === 'expired')
                                    <button wire:click="renewCourse({{ $enrollment['id'] }})" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:scale-105 active:scale-95" style="background: rgba(245,158,11,.1); color: #d97706;">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                        Renew
                                    </button>
                                @elseif($enrollment['status'] === 'completed')
                                    <a href="{{ route('student.certificates') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:scale-105" style="background: rgba(59,130,246,.1); color: #2563eb;">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                                        Certificate
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Progress -->
                        <div class="mt-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-[rgba(30,41,59,0.06)] rounded-full h-2">
                                    <div class="h-2 rounded-full crs-progress-fill" style="width: {{ $enrollment['progress_percentage'] ?? 0 }}%; background: linear-gradient(90deg, #f58220, #22c55e);"></div>
                                </div>
                                <span class="text-xs font-bold" style="color: var(--color-terra);">{{ $enrollment['progress_percentage'] ?? 0 }}%</span>
                            </div>
                            @if($enrollment['access_expires_at'])
                                <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Expires {{ \Carbon\Carbon::parse($enrollment['access_expires_at'])->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl p-12 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06);">
                <div class="w-20 h-20 mx-auto mb-5 rounded-2xl flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                    <svg class="w-10 h-10" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <h3 class="font-bold text-xl text-(--color-smoke) mb-2">No Courses Yet</h3>
                <p class="text-sm text-[rgba(30,41,59,0.5)] mb-5 max-w-md mx-auto">Start your learning journey today. Browse our courses and enroll in the one that fits your goals.</p>
                <a href="{{ route('student.catalog') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                    Explore Courses
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        @endforelse
    </div>
</div>
