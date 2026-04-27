<div class="space-y-8">
    <style>
        @keyframes spFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes spShimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes spFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        .sp-fade-up { animation: spFadeUp .4s ease-out both; }
        .sp-fade-up-1 { animation-delay: .05s; }
        .sp-fade-up-2 { animation-delay: .1s; }
        .sp-shimmer { background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.06) 50%, transparent 100%); background-size: 200% 100%; animation: spShimmer 3s ease-in-out infinite; }
        .sp-card { transition: transform .25s ease, box-shadow .25s ease; }
        .sp-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,.1); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(34,197,94,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="absolute inset-0 sp-shimmer"></div>
        <!-- Floating decorative elements -->
        <div class="absolute top-8 right-12 w-16 h-16 rounded-2xl opacity-5" style="background: #22c55e; animation: spFloat 4s ease-in-out infinite;"></div>
        <div class="absolute bottom-6 left-16 w-10 h-10 rounded-xl opacity-5" style="background: #f58220; animation: spFloat 5s ease-in-out infinite .5s;"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(34,197,94,.15); color: #22c55e; border: 1px solid rgba(34,197,94,.25);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pricing Management
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">Subscription Plans</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Manage pricing plans & free trial options for your courses.</p>
                </div>
                <a href="{{ route('admin.subscription-plans.create') }}" class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl text-sm font-bold transition-all hover:scale-105 active:scale-95" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white; box-shadow: 0 8px 24px rgba(34,197,94,.35);">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Add Plan
                </a>
            </div>
        </div>
    </div>

    <!-- Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($plans as $plan)
            @php
                $isActive = $plan->is_active;
                $isTrial = $plan->is_free_trial;
                $isFeatured = $plan->is_featured;
                $cardGradient = $isFeatured
                    ? 'linear-gradient(135deg, rgba(245,130,32,.06) 0%, rgba(34,197,94,.03) 100%)'
                    : 'white';
            @endphp
            <div class="sp-card relative overflow-hidden rounded-2xl sp-fade-up {{ $loop->index < 3 ? 'sp-fade-up-' . ($loop->index + 1) : '' }}" style="background: {{ $cardGradient }}; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                <!-- Top gradient bar -->
                <div class="h-1" style="background: {{ $isFeatured ? 'linear-gradient(90deg, #f58220, #22c55e)' : ($isTrial ? 'linear-gradient(90deg, #22c55e, #3b82f6)' : 'linear-gradient(90deg, #3b82f6, #8b5cf6)') }};"></div>

                @if($isFeatured)
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[.5rem] font-bold uppercase tracking-wider" style="background: linear-gradient(135deg, #f58220, #e06c10); color: white; box-shadow: 0 4px 12px rgba(245,130,32,.3);">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                            Featured
                        </span>
                    </div>
                @endif

                <div class="p-6">
                    <!-- Badges -->
                    <div class="flex items-center gap-2 mb-3">
                        @if($isTrial)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: rgba(34,197,94,.08); color: #16a34a;">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                Free Trial
                            </span>
                        @endif
                        @if(!$isActive)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: rgba(239,68,68,.08); color: #dc2626;">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Inactive
                            </span>
                        @endif
                        @if($isActive && !$isTrial)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: rgba(34,197,94,.08); color: #16a34a;">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Active
                            </span>
                        @endif
                    </div>

                    <!-- Plan Name & Description -->
                    <h3 class="font-bold text-lg text-(--color-smoke) mb-1">{{ $plan->name }}</h3>
                    <p class="text-xs text-[rgba(30,41,59,0.5)] line-clamp-2 leading-relaxed">{{ $plan->description }}</p>

                    <!-- Price -->
                    <div class="mt-4 p-4 rounded-xl" style="background: {{ $isFeatured ? 'rgba(245,130,32,.04)' : 'rgba(30,41,59,.02)' }};">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-black" style="color: {{ $isFeatured ? 'var(--color-terra)' : '#3b82f6' }};">{{ $plan->currency }} {{ number_format((float) $plan->price_amount, 0) }}</span>
                            <span class="text-xs text-[rgba(30,41,59,0.4)] font-medium">/ {{ $plan->duration_days }} days</span>
                        </div>
                        @if($isTrial)
                            <div class="flex items-center gap-1.5 mt-2">
                                <svg class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-xs font-semibold text-green-600">{{ $plan->trial_days }}-day free trial included</span>
                            </div>
                        @endif
                    </div>

                    <!-- Features -->
                    @if(count($plan->features ?? []) > 0)
                        <div class="mt-4 space-y-2">
                            @foreach(array_slice($plan->features ?? [], 0, 4) as $feature)
                                <div class="flex items-center gap-2 text-[.6875rem] text-[rgba(30,41,59,0.6)]">
                                    <svg class="w-4 h-4 shrink-0" style="color: {{ $isFeatured ? '#f58220' : '#22c55e' }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $feature }}
                                </div>
                            @endforeach
                            @if(count($plan->features ?? []) > 4)
                                <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)] pl-6">+{{ count($plan->features) - 4 }} more features</div>
                            @endif
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-5 pt-4 border-t flex items-center justify-between" style="border-color: rgba(30,41,59,.06);">
                        <button wire:click="toggleActive({{ $plan->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: {{ $isActive ? 'rgba(239,68,68,.06)' : 'rgba(34,197,94,.06)' }}; color: {{ $isActive ? '#dc2626' : '#16a34a' }};">
                            @if($isActive)
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Deactivate
                            @else
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Activate
                            @endif
                        </button>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: rgba(245,130,32,.08); color: var(--color-terra);">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                                Edit
                            </a>
                            <button wire:click="delete({{ $plan->id }})" wire:confirm="Delete this plan?" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: rgba(239,68,68,.06); color: #dc2626;">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="lg:col-span-3 rounded-2xl p-16 text-center" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
                <div class="w-20 h-20 mx-auto mb-5 rounded-2xl flex items-center justify-center" style="background: rgba(34,197,94,.06);">
                    <svg class="w-10 h-10 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-bold text-lg text-(--color-smoke) mb-2">No Plans Yet</h3>
                <p class="text-sm text-[rgba(30,41,59,0.5)] mb-5">Create your first subscription plan to start monetizing courses.</p>
                <a href="{{ route('admin.subscription-plans.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all hover:scale-105" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Create First Plan
                </a>
            </div>
        @endforelse
    </div>

    @if($plans->hasPages())
        <div class="mt-2">{{ $plans->links() }}</div>
    @endif
</div>
