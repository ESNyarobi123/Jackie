<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Users</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Create, edit, and manage accounts.</p>
        </div>

        <div class="shrink-0">
            <flux:button variant="primary" href="{{ route('admin.users.create') }}" wire:navigate>
                Create user
            </flux:button>
        </div>
    </div>

    <div class="glass-card p-4 glass-soft-shadow">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <flux:field class="md:col-span-2">
                <flux:label>Search</flux:label>
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Name, email, or phone..." />
            </flux:field>

            <flux:field>
                <flux:label>Per page</flux:label>
                <flux:select wire:model.live="perPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </flux:select>
            </flux:field>
        </div>
    </div>

    <div class="glass-card p-0 glass-soft-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[rgba(248,249,250,0.55)]">
                    <tr class="text-left text-xs text-[rgba(30,41,59,0.65)] border-b border-[rgba(30,41,59,0.08)]">
                        <th class="px-5 py-3">User</th>
                        <th class="px-5 py-3">Role</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Created</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($users as $user)
                        <tr class="border-b border-[rgba(30,41,59,0.06)] hover:bg-[rgba(245,130,32,0.04)] transition">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[var(--color-smoke)]">
                                    <a href="{{ route('admin.users.show', $user) }}" class="hover:underline" wire:navigate>
                                        {{ $user->name }}
                                    </a>
                                </div>
                                <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">
                                    {{ $user->email }}
                                    @if($user->phone)
                                        <span class="mx-1">·</span>{{ $user->phone }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ ucfirst($user->role?->value ?? (string) $user->role) }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                    {{ ucfirst($user->status?->value ?? (string) $user->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-xs text-[rgba(30,41,59,0.55)]">
                                {{ $user->created_at?->diffForHumans() }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" href="{{ route('admin.users.edit', $user) }}" wire:navigate>
                                        Edit
                                    </flux:button>
                                    <flux:button size="sm" variant="ghost" href="{{ route('admin.users.show', $user) }}" wire:navigate>
                                        View
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-[rgba(30,41,59,0.55)]">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[rgba(30,41,59,0.06)]">
            {{ $users->links() }}
        </div>
    </div>
</div>
