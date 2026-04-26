<div class="space-y-6">
    <!-- Hero Header -->
    <div class="relative overflow-hidden rounded-2xl p-6" style="background: linear-gradient(135deg, rgba(245,130,32,.08), rgba(245,130,32,.02));">
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 90% 20%, rgba(245,130,32,.8) 0%, transparent 50%);"></div>
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-base" style="background: linear-gradient(135deg, rgba(245,130,32,.15), rgba(245,130,32,.05));">�</div>
                    <h1 class="text-2xl font-bold text-(--color-smoke)">Choose Your Plan</h1>
                </div>
                <p class="text-sm text-[rgba(30,41,59,0.6)] ml-10">Pick a subscription plan that works for you</p>
            </div>

            <div class="flex items-center gap-3 ml-10 md:ml-0">
                <a href="{{ route('student.payments') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold border border-[rgba(30,41,59,0.08)] bg-[rgba(255,255,255,0.4)] backdrop-blur-sm hover:bg-[rgba(255,255,255,0.6)] transition-all">
                    💳 My Subscription
                </a>
            </div>
        </div>
    </div>

    <!-- Subscription Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($plans as $plan)
            <div class="relative overflow-hidden glass-card rounded-2xl hover:shadow-xl transition-all duration-300 group {{ $plan->is_featured ? 'ring-2 ring-[rgba(245,130,32,0.3)]' : '' }}">
                @if($plan->is_featured)
                    <div class="absolute top-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, var(--color-terra), rgba(245,130,32,.3));"></div>
                @endif

                @if($plan->is_featured)
                    <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[.5625rem] font-bold uppercase tracking-wider" style="background: var(--color-terra); color: var(--color-ivory);">
                        ⭐ Most Popular
                    </div>
                @endif

                <div class="p-6">
                    <!-- Plan Name & Badge -->
                    <div class="flex items-center gap-2 mb-3">
                        @if($plan->is_free_trial)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[.625rem] font-bold uppercase tracking-wider" style="background: rgba(34,197,94,.1); color: #16a34a; border: 1px solid rgba(34,197,94,.15);">
                                🎁 Free Trial
                            </span>
                        @endif
                    </div>

                    <h3 class="font-bold text-xl text-(--color-smoke) group-hover:text-(--color-terra) transition-colors">{{ $plan->name }}</h3>

                    @if($plan->description)
                        <p class="text-xs text-[rgba(30,41,59,0.55)] mt-2 line-clamp-2 leading-relaxed">{{ $plan->description }}</p>
                    @endif

                    <!-- Price -->
                    <div class="mt-4 flex items-baseline gap-1">
                        @if($plan->is_free_trial)
                            <span class="text-3xl font-bold text-green-600">Free</span>
                            <span class="text-sm text-[rgba(30,41,59,0.5)]">for {{ $plan->trial_days }} days</span>
                        @else
                            <span class="text-3xl font-bold text-(--color-terra)">{{ $plan->currency }} {{ number_format((float) $plan->price_amount, 0) }}</span>
                            <span class="text-sm text-[rgba(30,41,59,0.5)]">/ {{ $plan->duration_days }} days</span>
                        @endif
                    </div>

                    <!-- Features -->
                    @if(count($plan->features ?? []) > 0)
                        <div class="mt-4 space-y-2">
                            @foreach($plan->features as $feature)
                                <div class="flex items-center gap-2 text-xs text-[rgba(30,41,59,0.65)]">
                                    <span class="text-green-500 shrink-0">✓</span>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- CTA Button -->
                    <div class="mt-5">
                        @if($plan->is_free_trial)
                            <button wire:click="startFreeTrialPlan({{ $plan->id }})" wire:confirm="Start your {{ $plan->trial_days }}-day free trial?" class="w-full py-3 rounded-xl text-sm font-semibold transition-all hover:scale-[1.02]" style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; box-shadow: 0 4px 14px rgba(34,197,94,.25);">
                                🎁 Start Free Trial
                            </button>
                        @else
                            <button wire:click="openPlanSubscribe({{ $plan->id }})" class="w-full py-3 rounded-xl text-sm font-semibold transition-all hover:scale-[1.02]" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                                Subscribe Now
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card p-10 text-center lg:col-span-3 rounded-2xl">
                <div class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center text-3xl" style="background: linear-gradient(135deg, rgba(245,130,32,.1), rgba(245,130,32,.04));">�</div>
                <p class="font-semibold text-(--color-smoke) mb-1">No plans available</p>
                <p class="text-sm text-[rgba(30,41,59,0.5)]">Please check back later.</p>
            </div>
        @endforelse
    </div>

    <!-- Courses Section -->
    @if($courses->count() > 0)
        <div class="mt-8">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-sm" style="background: linear-gradient(135deg, rgba(245,130,32,.15), rgba(245,130,32,.05));">📚</div>
                <h2 class="text-lg font-bold text-(--color-smoke)">Available Courses</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($courses as $course)
                    @php($isEnrolled = $enrolledCourseIds->contains($course->id))
                    <div class="relative overflow-hidden glass-card rounded-2xl hover:shadow-lg transition-all group">
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                @if($course->is_featured)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[.5625rem] font-bold" style="background: rgba(245,130,32,.1); color: var(--color-terra);">⭐ Featured</span>
                                @endif
                                @if($isEnrolled)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[.5625rem] font-bold" style="background: rgba(59,130,246,.1); color: #F58220;">✅ Enrolled</span>
                                @endif
                            </div>
                            <h3 class="font-bold text-sm text-(--color-smoke) group-hover:text-(--color-terra) transition-colors">{{ $course->title }}</h3>
                            <div class="flex items-center gap-2 mt-1 text-[.625rem] text-[rgba(30,41,59,0.5)]">
                                <span>📖 {{ $course->lessons_count }} lessons</span>
                                <span>📅 {{ $course->duration_days }} days</span>
                            </div>
                            <div class="mt-2 text-xs font-bold text-(--color-terra)">{{ $course->currency }} {{ number_format((float) $course->price_amount, 0) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
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
