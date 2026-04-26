<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-(--color-smoke)">Subscription Plans</h1>
            <p class="text-xs text-[rgba(30,41,59,0.5)] mt-1">Manage pricing plans & free trial</p>
        </div>
        <a href="{{ route('admin.subscription-plans.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Plan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($plans as $plan)
            <div class="relative overflow-hidden glass-card rounded-2xl hover:shadow-lg transition-all group">
                @if($plan->is_featured)
                    <div class="absolute top-0 right-0 px-3 py-1 rounded-bl-xl text-[.5625rem] font-bold uppercase tracking-wider" style="background: var(--color-terra); color: var(--color-ivory);">Featured</div>
                @endif

                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        @if($plan->is_free_trial)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[.5625rem] font-bold" style="background: rgba(34,197,94,.1); color: #16a34a; border: 1px solid rgba(34,197,94,.15);">🎁 Free Trial</span>
                        @endif
                        @if(!$plan->is_active)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[.5625rem] font-bold" style="background: rgba(239,68,68,.1); color: #dc2626; border: 1px solid rgba(239,68,68,.15);">Inactive</span>
                        @endif
                    </div>

                    <h3 class="font-bold text-base text-(--color-smoke)">{{ $plan->name }}</h3>
                    <p class="text-xs text-[rgba(30,41,59,0.55)] mt-1 line-clamp-2">{{ $plan->description }}</p>

                    <div class="mt-3 flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-(--color-terra)">{{ $plan->currency }} {{ number_format((float) $plan->price_amount, 0) }}</span>
                        <span class="text-xs text-[rgba(30,41,59,0.4)]">/ {{ $plan->duration_days }} days</span>
                    </div>

                    @if($plan->is_free_trial)
                        <div class="text-xs text-green-600 font-semibold mt-1">{{ $plan->trial_days }}-day free trial</div>
                    @endif

                    @if(count($plan->features ?? []) > 0)
                        <div class="mt-3 space-y-1">
                            @foreach(array_slice($plan->features ?? [], 0, 3) as $feature)
                                <div class="flex items-center gap-1.5 text-[.6875rem] text-[rgba(30,41,59,0.6)]">
                                    <span class="text-green-500">✓</span> {{ $feature }}
                                </div>
                            @endforeach
                            @if(count($plan->features ?? []) > 3)
                                <div class="text-[.5625rem] text-[rgba(30,41,59,0.4)]">+{{ count($plan->features) - 3 }} more</div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-4 pt-3 border-t border-[rgba(30,41,59,0.06)] flex items-center justify-between">
                        <button wire:click="toggleActive({{ $plan->id }})" class="text-[.625rem] font-semibold {{ $plan->is_active ? 'text-[rgba(30,41,59,0.4)]' : 'text-green-600' }} hover:underline">
                            {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="text-[.625rem] font-semibold text-(--color-terra) hover:underline">Edit</a>
                            <button wire:click="delete({{ $plan->id }})" wire:confirm="Delete this plan?" class="text-[.625rem] font-semibold text-red-500 hover:underline">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card p-10 text-center lg:col-span-3 rounded-2xl">
                <div class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center text-3xl" style="background: linear-gradient(135deg, rgba(245,130,32,.1), rgba(245,130,32,.04));">📋</div>
                <p class="font-semibold text-(--color-smoke) mb-1">No plans yet</p>
                <p class="text-sm text-[rgba(30,41,59,0.5)]">Create your first subscription plan.</p>
            </div>
        @endforelse
    </div>

    <div>{{ $plans->links() }}</div>
</div>
