<div class="space-y-8">
    <style>
        @keyframes stuFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes stuShimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .stu-fade-up { animation: stuFadeUp .4s ease-out both; }
        .stu-fade-up-1 { animation-delay: .05s; }
        .stu-fade-up-2 { animation-delay: .1s; }
        .stu-fade-up-3 { animation-delay: .15s; }
        .stu-shimmer { background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.06) 50%, transparent 100%); background-size: 200% 100%; animation: stuShimmer 3s ease-in-out infinite; }
        .stu-row { transition: all .2s ease; }
        .stu-row:hover { background: rgba(245,130,32,.03); }
        .stu-card { transition: transform .25s ease, box-shadow .25s ease; }
        .stu-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,.08); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(59,130,246,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="absolute inset-0 stu-shimmer"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(59,130,246,.15); color: #3b82f6; border: 1px solid rgba(59,130,246,.25);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 8.753M12 6.75c-2.272 0-4.36.818-5.975 2.175m0 0A9.063 9.063 0 0112 6.75a9.063 9.063 0 015.975 2.175M12 6.75a9.063 9.063 0 015.975 2.175 9.063 9.063 0 01.491 8.753M12 6.75c-2.272 0-4.36.818-5.975 2.175a9.063 9.063 0 00-.491 8.753M15.75 19.5a1.5 1.5 0 01-1.5 1.5h-4.5a1.5 1.5 0 01-1.5-1.5V18a1.5 1.5 0 011.5-1.5h4.5a1.5 1.5 0 011.5 1.5v1.5z"/></svg>
                        Student Management
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">Students</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Browse and support student accounts. Track enrollments and activity.</p>
                </div>
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

    <!-- Students Table -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #3b82f6, #22c55e, #f58220);"></div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-[.5625rem] text-[rgba(30,41,59,0.4)] uppercase tracking-wider border-b" style="border-color: rgba(30,41,59,.06); background: rgba(248,249,250,.4);">
                        <th class="px-5 py-3.5 font-semibold">Student</th>
                        <th class="px-5 py-3.5 font-semibold">Enrollments</th>
                        <th class="px-5 py-3.5 font-semibold">Subscriptions</th>
                        <th class="px-5 py-3.5 font-semibold">Payments</th>
                        <th class="px-5 py-3.5 font-semibold">Status</th>
                        <th class="px-5 py-3.5 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($students as $student)
                        @php
                            $statusActive = ($student->status?->value ?? 'active') === 'active';
                            $initials = strtoupper(substr($student->name, 0, 1));
                            $hue = crc32($student->name) % 360;
                        @endphp
                        <tr class="stu-row border-b" style="border-color: rgba(30,41,59,.04);">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-xs font-bold text-white" style="background: hsl({{ $hue }}, 65%, 50%);">
                                        {{ $initials }}
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.students.show', $student) }}" wire:navigate class="font-bold text-sm text-(--color-smoke) hover:underline">{{ $student->name }}</a>
                                        <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                            {{ $student->email }}
                                            @if($student->phone)
                                                <span class="mx-0.5">·</span>{{ $student->phone }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[.5625rem] font-bold" style="background: rgba(245,130,32,.08); color: var(--color-terra);">
                                    {{ $student->enrollments_count }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[.5625rem] font-bold" style="background: rgba(34,197,94,.08); color: #16a34a;">
                                    {{ $student->subscriptions_count }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[.5625rem] font-bold" style="background: rgba(139,92,246,.08); color: #7c3aed;">
                                    {{ $student->payments_count }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: {{ $statusActive ? 'rgba(34,197,94,.08)' : 'rgba(239,68,68,.08)' }}; color: {{ $statusActive ? '#16a34a' : '#dc2626' }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $statusActive ? '#22c55e' : '#ef4444' }};"></span>
                                    {{ ucfirst($student->status?->value ?? 'active') }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.students.show', $student) }}" wire:navigate class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: rgba(59,130,246,.08); color: #2563eb;">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(59,130,246,.06);">
                                    <svg class="w-8 h-8 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 8.753M12 6.75c-2.272 0-4.36.818-5.975 2.175m0 0A9.063 9.063 0 0112 6.75a9.063 9.063 0 015.975 2.175M12 6.75a9.063 9.063 0 015.975 2.175 9.063 9.063 0 01.491 8.753M12 6.75c-2.272 0-4.36.818-5.975 2.175a9.063 9.063 0 00-.491 8.753"/></svg>
                                </div>
                                <h3 class="font-bold text-base text-(--color-smoke) mb-1">No Students Found</h3>
                                <p class="text-sm text-[rgba(30,41,59,0.5)]">Try adjusting your search</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="p-4 border-t" style="border-color: rgba(30,41,59,.06);">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
