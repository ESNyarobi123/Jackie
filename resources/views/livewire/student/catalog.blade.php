<div class="space-y-8">
    <style>
        @keyframes heroFloat { 0%,100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-8px) rotate(1deg); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .hero-float { animation: heroFloat 6s ease-in-out infinite; }
        .shimmer-line { background: linear-gradient(90deg, transparent 30%, rgba(245,130,32,.08) 50%, transparent 70%); background-size: 200% 100%; animation: shimmer 3s infinite; }
        .fade-up { animation: fadeUp .5s ease-out both; }
        .fade-up-1 { animation-delay: .05s; }
        .fade-up-2 { animation-delay: .1s; }
        .fade-up-3 { animation-delay: .15s; }
        .plan-card { transition: transform .3s cubic-bezier(.4,0,.2,1), box-shadow .3s ease; }
        .plan-card:hover { transform: translateY(-4px); }
        .course-card { transition: transform .25s ease, box-shadow .25s ease; }
        .course-card:hover { transform: translateY(-3px); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="absolute top-0 right-0 w-64 h-64 hero-float opacity-5" style="background: radial-gradient(circle, rgba(245,130,32,.4), transparent 70%); filter: blur(40px);"></div>

        <div class="relative px-8 py-10 md:py-14">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(245,130,32,.15); color: #f58220; border: 1px solid rgba(245,130,32,.2);">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#f58220] animate-pulse"></span>
                        Learning Plans Available
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">Choose Your Plan</h1>
                    <p class="text-sm text-[rgba(255,255,255,.5)] max-w-md leading-relaxed">Unlock your potential with flexible subscription plans. Pay securely via mobile money and start learning today.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('student.payments') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-sm font-semibold transition-all hover:scale-105 active:scale-95" style="background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1); backdrop-filter: blur(10px);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        My Subscription
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription Plans -->
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-1 h-8 rounded-full" style="background: linear-gradient(180deg, var(--color-terra), rgba(245,130,32,.2));"></div>
            <div>
                <h2 class="text-xl font-bold text-(--color-smoke)">Subscription Plans</h2>
                <p class="text-xs text-[rgba(30,41,59,0.5)] mt-0.5">Select the plan that fits your learning goals</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($plans as $plan)
                @php
                    $planColors = [
                        'monthly' => ['bg' => 'linear-gradient(135deg, #f58220 0%, #e8751a 100%)', 'accent' => '#f58220', 'light' => 'rgba(245,130,32,.08)'],
                        'quarterly' => ['bg' => 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)', 'accent' => '#8b5cf6', 'light' => 'rgba(139,92,246,.08)'],
                        'yearly' => ['bg' => 'linear-gradient(135deg, #06b6d4 0%, #0891b2 100%)', 'accent' => '#06b6d4', 'light' => 'rgba(6,182,212,.08)'],
                        'default' => ['bg' => 'linear-gradient(135deg, #f58220 0%, #e8751a 100%)', 'accent' => '#f58220', 'light' => 'rgba(245,130,32,.08)'],
                    ];
                    $planKey = str_contains(strtolower($plan->name), 'month') ? 'monthly'
                        : (str_contains(strtolower($plan->name), 'quarter') ? 'quarterly'
                        : (str_contains(strtolower($plan->name), 'year') ? 'yearly'
                        : 'default'));
                    $pc = $planColors[$planKey];
                @endphp

                <div class="plan-card relative overflow-hidden rounded-2xl fade-up {{ $loop->index === 0 ? 'fade-up-1' : ($loop->index === 1 ? 'fade-up-2' : 'fade-up-3') }} {{ $plan->is_featured ? 'ring-2 ring-[rgba(245,130,32,0.4)]' : '' }}" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                    @if($plan->is_featured)
                        <div class="absolute top-0 left-0 right-0 h-1.5" style="background: {{ $pc['bg'] }};"></div>
                        <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-[.5625rem] font-bold uppercase tracking-wider text-white" style="background: {{ $pc['bg'] }};">
                            Most Popular
                        </div>
                    @endif

                    <div class="p-6">
                        <!-- Plan Icon & Name -->
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background: {{ $pc['light'] }};">
                                @if($plan->is_free_trial)
                                    <svg class="w-6 h-6" style="color: #22c55e;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                @else
                                    <svg class="w-6 h-6" style="color: {{ $pc['accent'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-bold text-lg text-(--color-smoke) truncate">{{ $plan->name }}</h3>
                                    @if($plan->is_free_trial)
                                        <span class="shrink-0 px-2 py-0.5 rounded-full text-[.5625rem] font-bold uppercase tracking-wider" style="background: rgba(34,197,94,.1); color: #16a34a; border: 1px solid rgba(34,197,94,.15);">Free Trial</span>
                                    @endif
                                </div>
                                @if($plan->description)
                                    <p class="text-xs text-[rgba(30,41,59,0.5)] line-clamp-2 leading-relaxed">{{ $plan->description }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-5 p-4 rounded-xl" style="background: {{ $pc['light'] }};">
                            @if($plan->is_free_trial)
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-3xl font-extrabold text-green-600">Free</span>
                                    <span class="text-sm text-[rgba(30,41,59,0.5)]">/ {{ $plan->trial_days }} days</span>
                                </div>
                            @else
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-xs font-semibold text-[rgba(30,41,59,0.4)]">{{ $plan->currency }}</span>
                                    <span class="text-3xl font-extrabold" style="color: {{ $pc['accent'] }};">{{ number_format((float) $plan->price_amount, 0) }}</span>
                                </div>
                                <p class="text-[.6875rem] text-[rgba(30,41,59,0.4)] mt-1">{{ $plan->duration_days }} days access</p>
                            @endif
                        </div>

                        <!-- Features -->
                        @if(count($plan->features ?? []) > 0)
                            <div class="space-y-2.5 mb-5">
                                @foreach($plan->features as $feature)
                                    <div class="flex items-center gap-2.5 text-xs text-[rgba(30,41,59,0.6)]">
                                        <div class="w-4 h-4 rounded-full flex items-center justify-center shrink-0" style="background: {{ $pc['light'] }};">
                                            <svg class="w-2.5 h-2.5" style="color: {{ $pc['accent'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span>{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- CTA -->
                        @if($plan->is_free_trial)
                            <button wire:click="startFreeTrialPlan({{ $plan->id }})" wire:confirm="Start your {{ $plan->trial_days }}-day free trial?" class="w-full py-3.5 rounded-xl text-sm font-semibold transition-all hover:scale-[1.02] active:scale-[.98]" style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; box-shadow: 0 4px 14px rgba(34,197,94,.25);">
                                Start Free Trial
                            </button>
                        @else
                            <button wire:click="openPlanSubscribe({{ $plan->id }})" class="w-full py-3.5 rounded-xl text-sm font-semibold transition-all hover:scale-[1.02] active:scale-[.98]" style="background: {{ $pc['bg'] }}; color: white; box-shadow: 0 4px 14px {{ $pc['accent'] }}33;">
                                Subscribe Now
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl p-12 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06);">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(245,130,32,.08);">
                        <svg class="w-8 h-8" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h.375a.375.375 0 01.375.375v.375a.375.375 0 00.375.375h.375a.375.375 0 00.375-.375v-.375a.375.375 0 01.375-.375h.375a.375.375 0 00.375-.375v-.375a.375.375 0 00-.375-.375h-.375a.375.375 0 01-.375-.375v-.375a.375.375 0 01.375-.375h.375a.375.375 0 00.375-.375v-.375a.375.375 0 00-.375-.375h-.375a.375.375 0 01-.375-.375v-.375a.375.375 0 00-.375-.375h-.375a.375.375 0 01-.375.375v.375"/></svg>
                    </div>
                    <p class="font-semibold text-(--color-smoke) mb-1">No plans available</p>
                    <p class="text-sm text-[rgba(30,41,59,0.5)]">Please check back later.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Courses Section -->
    @if($courses->count() > 0)
        <div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-8 rounded-full" style="background: linear-gradient(180deg, var(--color-terra), rgba(245,130,32,.2));"></div>
                    <div>
                        <h2 class="text-xl font-bold text-(--color-smoke)">Available Courses</h2>
                        <p class="text-xs text-[rgba(30,41,59,0.5)] mt-0.5">{{ $courses->total() }} courses available</p>
                    </div>
                </div>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[rgba(30,41,59,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search courses..."
                        class="w-full sm:w-64 pl-10 pr-4 py-2.5 rounded-xl border border-[rgba(30,41,59,0.08)] bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(245,130,32,0.15)] focus:border-[rgba(245,130,32,0.2)] transition-all"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($courses as $course)
                    @php
                        $isEnrolled = $enrolledCourseIds->contains($course->id);
                        $courseImages = [
                            'spoken' => ['url' => 'https://images.unsplash.com/photo-1543165796-5426273eaab3?w=600&q=80', 'bg' => '#e8975a'],
                            'business' => ['url' => 'https://images.unsplash.com/photo-1552664733-d6d7a8a4345?w=600&q=80', 'bg' => '#5a8ee8'],
                            'ielts' => ['url' => 'https://images.unsplash.com/photo-1456511780578-1a7e62e0c3c5?w=600&q=80', 'bg' => '#7c5ae8'],
                            'default' => ['url' => 'https://images.unsplash.com/photo-1509062523349-8427d3e7e577?w=600&q=80', 'bg' => '#5abce8'],
                        ];
                        $courseImg = str_contains(strtolower($course->title), 'spoken') ? $courseImages['spoken']
                            : (str_contains(strtolower($course->title), 'business') ? $courseImages['business']
                            : (str_contains(strtolower($course->title), 'ielts') ? $courseImages['ielts']
                            : $courseImages['default']));
                    @endphp

                    <div class="course-card relative overflow-hidden rounded-2xl group" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                        <!-- Course Image -->
                        <div class="relative h-40 overflow-hidden" style="background: {{ $courseImg['bg'] }};">
                            <img src="{{ $courseImg['url'] }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy" onerror="this.style.display='none'" />
                            <div class="absolute inset-0" style="background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,.4) 100%);"></div>

                            @if($course->is_featured)
                                <div class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[.5625rem] font-bold uppercase tracking-wider text-white" style="background: rgba(245,130,32,.9); backdrop-filter: blur(4px);">
                                    Featured
                                </div>
                            @endif

                            @if($isEnrolled)
                                <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[.5625rem] font-bold text-white" style="background: rgba(34,197,94,.9); backdrop-filter: blur(4px);">
                                    Enrolled
                                </div>
                            @endif

                            <div class="absolute bottom-3 left-3 right-3">
                                <div class="flex items-center gap-2 text-white text-[.6875rem]">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md" style="background: rgba(255,255,255,.15); backdrop-filter: blur(4px);">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                        {{ $course->lessons_count }} lessons
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md" style="background: rgba(255,255,255,.15); backdrop-filter: blur(4px);">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                        {{ $course->duration_days }}d
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="p-5">
                            <h3 class="font-bold text-[.9375rem] text-(--color-smoke) group-hover:text-(--color-terra) transition-colors leading-snug mb-3">{{ $course->title }}</h3>

                            <div class="flex items-center justify-between">
                                <div class="text-sm font-bold" style="color: var(--color-terra);">{{ $course->currency }} {{ number_format((float) $course->price_amount, 0) }}</div>
                                @if($isEnrolled)
                                    <a href="{{ route('student.courses') }}" wire:navigate class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[.6875rem] font-semibold transition-all hover:scale-105" style="background: rgba(34,197,94,.08); color: #16a34a;">
                                        Continue
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                    </a>
                                @else
                                    <button wire:click="openSubscribe({{ $course->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[.6875rem] font-semibold transition-all hover:scale-105" style="background: rgba(245,130,32,.08); color: var(--color-terra);">
                                        Enroll
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($courses->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- Payment Modal - Amazing Flow -->
    <flux:modal wire:model="showSubscribeModal" class="max-w-lg!">
        @if($selectedPlan)
            <div class="space-y-5">
                <!-- Plan Header -->
                <div class="relative overflow-hidden rounded-xl p-4" style="background: linear-gradient(135deg, rgba(245,130,32,.08), rgba(245,130,32,.02));">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0" style="background: linear-gradient(135deg, rgba(245,130,32,.15), rgba(245,130,32,.05));">📋</div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-bold text-sm text-(--color-smoke) truncate">{{ $selectedPlan->name }}</h3>
                            <span class="text-xs text-[rgba(30,41,59,0.5)]">{{ $selectedPlan->duration_days }} days access</span>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-lg font-bold text-(--color-terra)">{{ $selectedPlan->currency }} {{ number_format((float) $selectedPlan->price_amount, 0) }}</div>
                        </div>
                    </div>
                </div>

                @if(! $activePayment)
                    <!-- Step 1: Select Network -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center text-[.5625rem] font-bold" style="background: var(--color-terra); color: var(--color-ivory);">1</div>
                            <span class="text-xs font-semibold text-(--color-smoke)">Select Mobile Network</span>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach([
                                ['id' => 'mpesa', 'name' => 'M-Pesa', 'prefix' => 'Vodacom', 'color' => '#e31e24', 'icon' => '🔴'],
                                ['id' => 'airtel', 'name' => 'Airtel', 'prefix' => 'Airtel', 'color' => '#e4002b', 'icon' => '🔴'],
                                ['id' => 'tigo', 'name' => 'Tigo', 'prefix' => 'Tigo', 'color' => '#003da5', 'icon' => '🔵'],
                                ['id' => 'halotel', 'name' => 'Halotel', 'prefix' => 'Halotel', 'color' => '#00a651', 'icon' => '🟢'],
                            ] as $network)
                                <button
                                    type="button"
                                    wire:click="$set('selectedNetwork', '{{ $network['id'] }}')"
                                    class="relative flex flex-col items-center gap-1 p-3 rounded-xl border-2 transition-all hover:shadow-md {{ $selectedNetwork === $network['id'] ? 'border-[rgba(245,130,32,0.5)] shadow-md' : 'border-[rgba(30,41,59,0.06)] hover:border-[rgba(30,41,59,0.15)]' }}"
                                    style="{{ $selectedNetwork === $network['id'] ? 'background: rgba(245,130,32,.06)' : 'background: rgba(255,255,255,0.4)' }}"
                                >
                                    @if($selectedNetwork === $network['id'])
                                        <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full flex items-center justify-center text-[.5rem]" style="background: var(--color-terra); color: white;">✓</div>
                                    @endif
                                    <span class="text-lg">{{ $network['icon'] }}</span>
                                    <span class="text-[.625rem] font-semibold text-(--color-smoke)">{{ $network['name'] }}</span>
                                </button>
                            @endforeach
                        </div>
                        <flux:error name="selectedNetwork" />
                    </div>

                    <!-- Step 2: Phone Number -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center text-[.5625rem] font-bold" style="background: var(--color-terra); color: var(--color-ivory);">2</div>
                            <span class="text-xs font-semibold text-(--color-smoke)">Enter Phone Number</span>
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm">🇹🇿</span>
                            <input
                                type="tel"
                                wire:model.blur="phoneNumber"
                                placeholder="07XXXXXXXX or 2557XXXXXXXX"
                                class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-[rgba(30,41,59,0.08)] bg-[rgba(255,255,255,0.6)] text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(245,130,32,0.2)] focus:border-[rgba(245,130,32,0.3)] transition-all"
                            />
                        </div>
                        <flux:error name="phoneNumber" />
                        <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)] mt-1.5 ml-1">USSD push will be sent to this number. Just approve on your phone.</p>
                    </div>
                @endif

                <!-- Payment Status (after initiation) -->
                @if($activePayment)
                    @php($paymentStatusValue = $activePayment->status?->value ?? (string) $activePayment->status)

                    @if($paymentStatusValue === 'paid')
                        {{-- Success State --}}
                        <div class="rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, rgba(34,197,94,.06), rgba(16,185,129,.03)); border: 1px solid rgba(34,197,94,.15);">
                            <div class="p-6 text-center">
                                <div class="relative w-20 h-20 mx-auto mb-4">
                                    <div class="absolute inset-0 rounded-full animate-ping opacity-20" style="background: rgba(34,197,94,.3);"></div>
                                    <div class="relative w-20 h-20 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #22c55e, #16a34a); box-shadow: 0 8px 30px rgba(34,197,94,.3);">
                                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-green-700 mb-1">Payment Confirmed!</h3>
                                <p class="text-xs text-[rgba(30,41,59,0.45)] mb-3">Ref: {{ $activePayment->reference }}</p>
                                @if($paymentMessage)
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium" style="background: rgba(34,197,94,.1); color: #16a34a;">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $paymentMessage }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    @elseif($paymentStatusValue === 'failed')
                        {{-- Failed State --}}
                        <div class="rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, rgba(239,68,68,.05), rgba(220,38,38,.02)); border: 1px solid rgba(239,68,68,.12);">
                            <div class="p-6 text-center">
                                <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, rgba(239,68,68,.12), rgba(239,68,68,.06));">
                                    <svg class="w-10 h-10" style="color: #ef4444;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-red-700 mb-1">Payment Failed</h3>
                                <p class="text-xs text-[rgba(30,41,59,0.45)] mb-2">Ref: {{ $activePayment->reference }}</p>
                                @if($paymentMessage)
                                    <p class="text-xs text-red-500 mb-4">{{ $paymentMessage }}</p>
                                @endif
                                <button wire:click="retryPayment" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                    Try Again
                                </button>
                            </div>
                        </div>

                    @else
                        {{-- Pending / Awaiting State - Beautiful animated --}}
                        <div wire:poll.5s="checkPaymentStatus" class="rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, rgba(245,130,32,.04), rgba(251,191,36,.03)); border: 1px solid rgba(245,130,32,.12);">
                            <style>
                                @keyframes cpRipple { 0% { transform: scale(.8); opacity: .6; } 100% { transform: scale(2.2); opacity: 0; } }
                                @keyframes cpFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
                                @keyframes cpDot { 0%,80%,100% { transform: scale(0); opacity:.4; } 40% { transform: scale(1); opacity:1; } }
                                @keyframes cpProgress { 0% { width: 5%; } 50% { width: 65%; } 100% { width: 95%; } }
                                @keyframes cpGlow { 0%,100% { box-shadow: 0 0 15px rgba(245,130,32,.15); } 50% { box-shadow: 0 0 30px rgba(245,130,32,.3); } }
                                .cp-ripple-1 { animation: cpRipple 2s ease-out infinite; }
                                .cp-ripple-2 { animation: cpRipple 2s ease-out .6s infinite; }
                                .cp-ripple-3 { animation: cpRipple 2s ease-out 1.2s infinite; }
                                .cp-float { animation: cpFloat 3s ease-in-out infinite; }
                                .cp-dot-1 { animation: cpDot 1.4s ease-in-out infinite; }
                                .cp-dot-2 { animation: cpDot 1.4s ease-in-out .2s infinite; }
                                .cp-dot-3 { animation: cpDot 1.4s ease-in-out .4s infinite; }
                                .cp-progress-bar { animation: cpProgress 12s ease-in-out infinite; }
                                .cp-glow { animation: cpGlow 2s ease-in-out infinite; }
                            </style>

                            <div class="p-6 text-center">
                                {{-- Animated phone icon with ripple rings --}}
                                <div class="relative w-24 h-24 mx-auto mb-5">
                                    <div class="absolute inset-0 rounded-full cp-ripple-1" style="border: 2px solid rgba(245,130,32,.2);"></div>
                                    <div class="absolute inset-0 rounded-full cp-ripple-2" style="border: 2px solid rgba(245,130,32,.15);"></div>
                                    <div class="absolute inset-0 rounded-full cp-ripple-3" style="border: 2px solid rgba(245,130,32,.1);"></div>
                                    <div class="relative w-24 h-24 rounded-full flex items-center justify-center cp-float cp-glow" style="background: linear-gradient(135deg, #f58220, #e8751a); box-shadow: 0 8px 30px rgba(245,130,32,.25);">
                                        <svg class="w-11 h-11 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Title --}}
                                <h3 class="text-lg font-bold mb-1" style="color: var(--color-smoke);">Approve on Your Phone</h3>
                                <p class="text-xs text-[rgba(30,41,59,0.5)] mb-5">A USSD prompt has been sent to your phone. Enter your PIN to confirm.</p>

                                {{-- Progress steps --}}
                                <div class="flex items-center justify-center gap-0 mb-5 px-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="text-[.5625rem] mt-1.5 font-medium text-green-600">Sent</span>
                                    </div>
                                    <div class="flex-1 h-0.5 mx-1 rounded-full overflow-hidden" style="background: rgba(30,41,59,.06);">
                                        <div class="h-full rounded-full cp-progress-bar" style="background: linear-gradient(90deg, #22c55e, #f59e0b);"></div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold animate-pulse" style="background: linear-gradient(135deg, rgba(245,130,32,.15), rgba(245,130,32,.08)); color: var(--color-terra); border: 2px solid rgba(245,130,32,.2);">
                                            2
                                        </div>
                                        <span class="text-[.5625rem] mt-1.5 font-medium" style="color: var(--color-terra);">Confirm</span>
                                    </div>
                                    <div class="flex-1 h-0.5 mx-1 rounded-full" style="background: rgba(30,41,59,.06);"></div>
                                    <div class="flex flex-col items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold" style="background: rgba(30,41,59,.04); color: rgba(30,41,59,.25); border: 2px solid rgba(30,41,59,.06);">
                                            3
                                        </div>
                                        <span class="text-[.5625rem] mt-1.5 font-medium text-[rgba(30,41,59,0.3)]">Done</span>
                                    </div>
                                </div>

                                {{-- Animated loading dots --}}
                                <div class="flex items-center justify-center gap-1.5 mb-4">
                                    <span class="w-2 h-2 rounded-full cp-dot-1" style="background: var(--color-terra);"></span>
                                    <span class="w-2 h-2 rounded-full cp-dot-2" style="background: var(--color-terra);"></span>
                                    <span class="w-2 h-2 rounded-full cp-dot-3" style="background: var(--color-terra);"></span>
                                </div>

                                <p class="text-[.6875rem] font-medium" style="color: var(--color-terra);">Waiting for confirmation...</p>
                                <p class="text-[.5625rem] text-[rgba(30,41,59,0.35)] mt-1">Auto-checking every 5 seconds</p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Modal Actions -->
            <div class="mt-5 flex justify-end gap-2">
                @if(!$activePayment)
                    <flux:button variant="ghost" wire:click="$set('showSubscribeModal', false)">Cancel</flux:button>
                    <flux:button variant="primary" wire:click="startClickPesaPayment" wire:loading.attr="disabled" class="{{ !$selectedNetwork ? 'opacity-50' : '' }}">
                        <span wire:loading.remove>📱 Send USSD Push</span>
                        <span wire:loading>Sending…</span>
                    </flux:button>
                @elseif($paymentStatusValue === 'paid')
                    <flux:button variant="primary" href="{{ route('student.courses') }}" wire:navigate class="bg-green-600! hover:bg-green-700!">
                        🎉 Start Learning
                    </flux:button>
                @elseif($paymentStatusValue === 'failed')
                    <flux:button variant="ghost" wire:click="$set('showSubscribeModal', false)">Close</flux:button>
                @else
                    <flux:button variant="ghost" wire:click="$set('showSubscribeModal', false)" class="text-xs!">Cancel Payment</flux:button>
                @endif
            </div>
        @endif
    </flux:modal>
</div>
