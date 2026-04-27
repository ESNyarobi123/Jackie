<div class="space-y-8">
    <style>
        @keyframes usrFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes usrShimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .usr-fade-up { animation: usrFadeUp .4s ease-out both; }
        .usr-fade-up-1 { animation-delay: .05s; }
        .usr-fade-up-2 { animation-delay: .1s; }
        .usr-fade-up-3 { animation-delay: .15s; }
        .usr-shimmer { background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.06) 50%, transparent 100%); background-size: 200% 100%; animation: usrShimmer 3s ease-in-out infinite; }
        .usr-row { transition: all .2s ease; }
        .usr-row:hover { background: rgba(245,130,32,.03); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(59,130,246,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="absolute inset-0 usr-shimmer"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(59,130,246,.15); color: #3b82f6; border: 1px solid rgba(59,130,246,.25);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.782-3.07-1.416a6.5 6.5 0 01-1.055-.598m0 0a6.497 6.497 0 01-3.875-1.178m3.875 1.178L9 19.128m0 0a9.337 9.337 0 01-4.121-.952 4.125 4.125 0 017.533-2.493M9 19.128v-.003c0-1.113.285-2.16.782-3.07a6.5 6.5 0 011.055-.598m0 0a6.497 6.497 0 013.875-1.178M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm7.125 3.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
                        User Management
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">Users</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Create, edit, and manage accounts. Monitor user activity and roles.</p>
                </div>
                <a href="{{ route('admin.users.create') }}" wire:navigate class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl text-sm font-bold transition-all hover:scale-105 active:scale-95" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; box-shadow: 0 8px 24px rgba(59,130,246,.35);">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    Create User
                </a>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[rgba(30,41,59,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name, email, or phone..." class="w-full pl-10 pr-4 py-3 rounded-xl text-sm border-0 bg-[rgba(30,41,59,0.04)] focus:bg-[rgba(30,41,59,0.06)] focus:ring-2 focus:ring-[rgba(59,130,246,.3)] transition-all outline-none" />
                </div>
            </div>
            <div>
                <select wire:model.live="perPage" class="w-full px-4 py-3 rounded-xl text-sm border-0 bg-[rgba(30,41,59,0.04)] focus:bg-[rgba(30,41,59,0.06)] focus:ring-2 focus:ring-[rgba(59,130,246,.3)] transition-all outline-none cursor-pointer">
                    <option value="10">10 per page</option>
                    <option value="20">20 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #3b82f6, #8b5cf6, #f58220);"></div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-[.5625rem] text-[rgba(30,41,59,0.4)] uppercase tracking-wider border-b" style="border-color: rgba(30,41,59,.06); background: rgba(248,249,250,.4);">
                        <th class="px-5 py-3.5 font-semibold">User</th>
                        <th class="px-5 py-3.5 font-semibold">Role</th>
                        <th class="px-5 py-3.5 font-semibold">Status</th>
                        <th class="px-5 py-3.5 font-semibold">Created</th>
                        <th class="px-5 py-3.5 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($users as $user)
                        @php
                            $roleColors = [
                                'admin' => ['bg' => 'rgba(139,92,246,.08)', 'text' => '#7c3aed', 'dot' => '#8b5cf6'],
                                'student' => ['bg' => 'rgba(59,130,246,.08)', 'text' => '#2563eb', 'dot' => '#3b82f6'],
                            ];
                            $role = $user->role?->value ?? 'student';
                            $rc = $roleColors[$role] ?? $roleColors['student'];
                            $statusActive = ($user->status?->value ?? 'active') === 'active';
                        @endphp
                        <tr class="usr-row border-b" style="border-color: rgba(30,41,59,.04);">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-xs font-bold text-white" style="background: linear-gradient(135deg, {{ $rc['dot'] }}, {{ $rc['dot'] }}88);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.users.show', $user) }}" wire:navigate class="font-bold text-sm text-(--color-smoke) hover:underline">{{ $user->name }}</a>
                                        <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                            {{ $user->email }}
                                            @if($user->phone)
                                                <span class="mx-0.5">·</span>
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.809.542-1.255.37a13.928 13.928 0 01-6.583-4.715c-.286-.372-.292-.88-.012-1.258l.97-1.293c.274-.365.226-.88-.098-1.178L6.473 4.102c-.282-.282-.694-.358-1.052-.175a15.452 15.452 0 00-3.171 2.423z"/></svg>
                                                {{ $user->phone }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: {{ $rc['bg'] }}; color: {{ $rc['text'] }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $rc['dot'] }};"></span>
                                    {{ ucfirst($role) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: {{ $statusActive ? 'rgba(34,197,94,.08)' : 'rgba(239,68,68,.08)' }}; color: {{ $statusActive ? '#16a34a' : '#dc2626' }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $statusActive ? '#22c55e' : '#ef4444' }};"></span>
                                    {{ ucfirst($user->status?->value ?? 'active') }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[.625rem] text-[rgba(30,41,59,0.4)] flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                    {{ $user->created_at?->diffForHumans() }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" wire:navigate class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: rgba(245,130,32,.08); color: var(--color-terra);">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.users.show', $user) }}" wire:navigate class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: rgba(59,130,246,.08); color: #2563eb;">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(59,130,246,.06);">
                                    <svg class="w-8 h-8 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.782-3.07-1.416a6.5 6.5 0 01-1.055-.598m0 0a6.497 6.497 0 01-3.875-1.178m3.875 1.178L9 19.128m0 0a9.337 9.337 0 01-4.121-.952 4.125 4.125 0 017.533-2.493M9 19.128v-.003c0-1.113.285-2.16.782-3.07a6.5 6.5 0 011.055-.598m0 0a6.497 6.497 0 013.875-1.178M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm7.125 3.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
                                </div>
                                <h3 class="font-bold text-base text-(--color-smoke) mb-1">No Users Found</h3>
                                <p class="text-sm text-[rgba(30,41,59,0.5)]">Try adjusting your search or create a new user</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t" style="border-color: rgba(30,41,59,.06);">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
