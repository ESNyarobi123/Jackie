<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Create user</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Add an admin or student account.</p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.users.index') }}" wire:navigate>
                Back
            </flux:button>
            <flux:button variant="primary" wire:click="save" wire:loading.attr="disabled">
                <span wire:loading.remove>Create</span>
                <span wire:loading>Saving…</span>
            </flux:button>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow space-y-5 max-w-3xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input wire:model.live="name" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>Email</flux:label>
                <flux:input type="email" wire:model.blur="email" />
                <flux:error name="email" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Phone</flux:label>
            <flux:input wire:model.blur="phone" placeholder="Optional" />
            <flux:error name="phone" />
        </flux:field>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Role</flux:label>
                <flux:select wire:model.live="role">
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </flux:select>
                <flux:error name="role" />
            </flux:field>

            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select wire:model.live="status">
                    <option value="active">Active</option>
                    <option value="suspended">Suspended</option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Password</flux:label>
            <flux:input type="password" wire:model.blur="password" />
            <flux:error name="password" />
        </flux:field>
    </div>
</div>
