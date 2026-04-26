<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-(--color-smoke)">Edit Plan</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">{{ $subscriptionPlan->name }}</p>
        </div>
        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.subscription-plans.index') }}" wire:navigate>Cancel</flux:button>
            <flux:button variant="primary" wire:click="save" wire:loading.attr="disabled">
                <span wire:loading.remove>Save</span>
                <span wire:loading>Saving…</span>
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 glass-card p-6 glass-soft-shadow space-y-5">
            <flux:field>
                <flux:label>Plan Name</flux:label>
                <flux:input wire:model.live="name" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>Slug</flux:label>
                <flux:input wire:model.blur="slug" />
                <flux:error name="slug" />
            </flux:field>

            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model.blur="description" rows="3" />
                <flux:error name="description" />
            </flux:field>

            <flux:field>
                <flux:label>Features (one per line)</flux:label>
                <flux:textarea wire:model.blur="features_input" rows="6" />
                <flux:error name="features_input" />
            </flux:field>
        </div>

        <div class="glass-card p-6 glass-soft-shadow space-y-5">
            <div class="grid grid-cols-2 gap-3">
                <flux:field>
                    <flux:label>Currency</flux:label>
                    <flux:input wire:model.blur="currency" />
                    <flux:error name="currency" />
                </flux:field>

                <flux:field>
                    <flux:label>Price</flux:label>
                    <flux:input wire:model.blur="price_amount" inputmode="decimal" />
                    <flux:error name="price_amount" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Duration (days)</flux:label>
                <flux:input type="number" wire:model.blur="duration_days" min="1" max="3650" />
                <flux:error name="duration_days" />
            </flux:field>

            <flux:field>
                <div class="flex items-center justify-between gap-3">
                    <flux:label>Free Trial</flux:label>
                    <flux:switch wire:model.live="is_free_trial" />
                </div>
                <flux:error name="is_free_trial" />
            </flux:field>

            @if($is_free_trial)
                <flux:field>
                    <flux:label>Trial Duration (days)</flux:label>
                    <flux:input type="number" wire:model.blur="trial_days" min="1" max="365" />
                    <flux:error name="trial_days" />
                </flux:field>
            @endif

            <flux:field>
                <div class="flex items-center justify-between gap-3">
                    <flux:label>Featured</flux:label>
                    <flux:switch wire:model.live="is_featured" />
                </div>
                <flux:error name="is_featured" />
            </flux:field>

            <flux:field>
                <div class="flex items-center justify-between gap-3">
                    <flux:label>Active</flux:label>
                    <flux:switch wire:model.live="is_active" />
                </div>
                <flux:error name="is_active" />
            </flux:field>

            <flux:field>
                <flux:label>Sort Order</flux:label>
                <flux:input type="number" wire:model.blur="sort_order" min="0" />
                <flux:error name="sort_order" />
            </flux:field>
        </div>
    </div>
</div>
