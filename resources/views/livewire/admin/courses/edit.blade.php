<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Edit course</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">{{ $course->title }}</p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.courses.show', $course) }}" wire:navigate>
                Cancel
            </flux:button>
            <flux:button variant="primary" wire:click="save" wire:loading.attr="disabled">
                <span wire:loading.remove>Save</span>
                <span wire:loading>Saving…</span>
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 glass-card p-6 glass-soft-shadow space-y-5">
            <flux:field>
                <flux:label>Title</flux:label>
                <flux:input wire:model.live="title" />
                <flux:error name="title" />
            </flux:field>

            <flux:field>
                <flux:label>Slug</flux:label>
                <flux:input wire:model.blur="slug" />
                <flux:error name="slug" />
            </flux:field>

            <flux:field>
                <flux:label>Excerpt</flux:label>
                <flux:textarea wire:model.blur="excerpt" rows="3" />
                <flux:error name="excerpt" />
            </flux:field>

            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model.blur="description" rows="8" />
                <flux:error name="description" />
            </flux:field>
        </div>

        <div class="glass-card p-6 glass-soft-shadow space-y-5">
            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select wire:model.live="status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>

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
                <flux:label>Published at</flux:label>
                <flux:input type="datetime-local" wire:model.blur="published_at" />
                <flux:error name="published_at" />
            </flux:field>

            <flux:field>
                <div class="flex items-center justify-between gap-3">
                    <flux:label>Featured</flux:label>
                    <flux:switch wire:model.live="is_featured" />
                </div>
                <flux:error name="is_featured" />
            </flux:field>

            <flux:field>
                <div class="flex items-center justify-between gap-3">
                    <flux:label>Free Trial</flux:label>
                    <flux:switch wire:model.live="has_free_trial" />
                </div>
                <flux:error name="has_free_trial" />
            </flux:field>

            @if($has_free_trial)
                <flux:field>
                    <flux:label>Trial Duration (days)</flux:label>
                    <flux:input type="number" wire:model.blur="free_trial_days" min="1" max="365" />
                    <flux:error name="free_trial_days" />
                </flux:field>
            @endif
        </div>
    </div>
</div>
