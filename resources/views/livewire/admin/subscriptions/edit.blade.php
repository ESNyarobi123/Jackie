<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Edit subscription</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1 truncate">
                {{ $subscription->user?->name ?? 'Student' }} · {{ $subscription->course?->title ?? 'Course' }}
            </p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.subscriptions.show', $subscription) }}" wire:navigate>
                Cancel
            </flux:button>
            <flux:button variant="primary" wire:click="save" wire:loading.attr="disabled">
                <span wire:loading.remove>Save</span>
                <span wire:loading>Saving…</span>
            </flux:button>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow space-y-5 max-w-3xl">
        <flux:field>
            <flux:label>Status</flux:label>
            <flux:select wire:model.live="status">
                <option value="pending">Pending</option>
                <option value="active">Active</option>
                <option value="expired">Expired</option>
                <option value="cancelled">Cancelled</option>
            </flux:select>
            <flux:error name="status" />
        </flux:field>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Access starts</flux:label>
                <flux:input type="datetime-local" wire:model.blur="access_starts_at" />
                <flux:error name="access_starts_at" />
            </flux:field>

            <flux:field>
                <flux:label>Access ends</flux:label>
                <flux:input type="datetime-local" wire:model.blur="access_ends_at" />
                <flux:error name="access_ends_at" />
            </flux:field>
        </div>
    </div>
</div>
