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
                    <div class="rounded-xl border p-5 {{ $paymentStatusValue === 'paid' ? 'border-green-200' : ($paymentStatusValue === 'failed' ? 'border-red-200' : 'border-amber-200') }}" style="background: {{ $paymentStatusValue === 'paid' ? 'rgba(34,197,94,.05)' : ($paymentStatusValue === 'failed' ? 'rgba(239,68,68,.05)' : 'rgba(245,158,11,.05)' ) }};">
                        @if($paymentStatusValue === 'paid')
                            <!-- Success -->
                            <div class="text-center space-y-3">
                                <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center text-2xl" style="background: rgba(34,197,94,.15);">✅</div>
                                <div>
                                    <div class="font-bold text-green-700">Payment Confirmed!</div>
                                    <div class="text-xs text-[rgba(30,41,59,0.5)] mt-1">Ref: {{ $activePayment->reference }}</div>
                                </div>
                                @if($paymentMessage)
                                    <div class="text-xs text-green-600">{{ $paymentMessage }}</div>
                                @endif
                            </div>
                        @elseif($paymentStatusValue === 'failed')
                            <!-- Failed -->
                            <div class="text-center space-y-3">
                                <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center text-2xl" style="background: rgba(239,68,68,.15);">❌</div>
                                <div>
                                    <div class="font-bold text-red-700">Payment Failed</div>
                                    <div class="text-xs text-[rgba(30,41,59,0.5)] mt-1">Ref: {{ $activePayment->reference }}</div>
                                </div>
                                @if($paymentMessage)
                                    <div class="text-xs text-red-600">{{ $paymentMessage }}</div>
                                @endif
                                <button wire:click="retryPayment" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                                    🔄 Try Again
                                </button>
                            </div>
                        @else
                            <!-- Pending -->
                            <div class="text-center space-y-3">
                                <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center text-2xl animate-pulse" style="background: rgba(245,158,11,.15);">⏳</div>
                                <div>
                                    <div class="font-bold text-amber-700">Awaiting Confirmation</div>
                                    <div class="text-xs text-[rgba(30,41,59,0.5)] mt-1">Ref: {{ $activePayment->reference }}</div>
                                </div>
                                @if($paymentMessage)
                                    <div class="text-xs text-amber-600">{{ $paymentMessage }}</div>
                                @endif
                                <div class="flex items-center justify-center gap-1 text-[.5625rem] text-[rgba(30,41,59,0.4)]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                    Checking automatically... Tap below if needed
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Modal Actions -->
            <div class="mt-6 flex justify-end gap-2">
                <flux:button variant="ghost" wire:click="$set('showSubscribeModal', false)">
                    {{ $activePayment && ($activePayment->status?->value ?? (string) $activePayment->status) === 'paid' ? 'Close' : 'Cancel' }}
                </flux:button>
                @if($activePayment && ($activePayment->status?->value ?? (string) $activePayment->status) === 'pending')
                    <flux:button variant="primary" wire:click="checkPaymentStatus" wire:loading.attr="disabled" class="bg-amber-600! hover:bg-amber-700!">
                        <span wire:loading.remove>🔄 Check Status</span>
                        <span wire:loading>Checking…</span>
                    </flux:button>
                @elseif(! $activePayment)
                    <flux:button variant="primary" wire:click="startClickPesaPayment" wire:loading.attr="disabled" class="{{ !$selectedNetwork ? 'opacity-50' : '' }}">
                        <span wire:loading.remove>📱 Send USSD Push</span>
                        <span wire:loading>Sending…</span>
                    </flux:button>
                @else
                    <flux:button variant="primary" href="{{ route('student.courses') }}" wire:navigate>
                        🎉 Start Learning
                    </flux:button>
                @endif
            </div>
        @endif
    </flux:modal>
</div>
