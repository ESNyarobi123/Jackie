<div class="space-y-8">
    <style>
        @keyframes crsFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes crsShimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .crs-fade-up { animation: crsFadeUp .4s ease-out both; }
        .crs-shimmer { background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.06) 50%, transparent 100%); background-size: 200% 100%; animation: crsShimmer 3s ease-in-out infinite; }
        .crs-row { transition: all .2s ease; }
        .crs-row:hover { background: rgba(245,130,32,.03); }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(59,130,246,.3) 0%, transparent 40%);"></div>
        <div class="absolute inset-0 crs-shimmer"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-[.6875rem] font-semibold mb-4" style="background: rgba(245,130,32,.15); color: #f58220; border: 1px solid rgba(245,130,32,.25);">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        Course Catalog
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">Courses</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)] max-w-md">Create, publish, and manage your course catalog.</p>
                </div>
                <a href="{{ route('admin.courses.create') }}" wire:navigate class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl text-sm font-bold transition-all hover:scale-105 active:scale-95" style="background: linear-gradient(135deg, #f58220, #e06c10); color: white; box-shadow: 0 8px 24px rgba(245,130,32,.35);">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Create Course
                </a>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="rounded-2xl p-5" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[rgba(30,41,59,0.3)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by title or slug..." class="w-full pl-10 pr-4 py-3 rounded-xl text-sm border-0 bg-[rgba(30,41,59,0.04)] focus:bg-[rgba(30,41,59,0.06)] focus:ring-2 focus:ring-[rgba(245,130,32,.3)] transition-all outline-none" />
                </div>
            </div>
            <div>
                <select wire:model.live="status" class="w-full px-4 py-3 rounded-xl text-sm border-0 bg-[rgba(30,41,59,0.04)] focus:bg-[rgba(30,41,59,0.06)] focus:ring-2 focus:ring-[rgba(245,130,32,.3)] transition-all outline-none cursor-pointer">
                    @foreach($this->statusOptions() as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="perPage" class="w-full px-4 py-3 rounded-xl text-sm border-0 bg-[rgba(30,41,59,0.04)] focus:bg-[rgba(30,41,59,0.06)] focus:ring-2 focus:ring-[rgba(245,130,32,.3)] transition-all outline-none cursor-pointer">
                    <option value="10">10 per page</option>
                    <option value="15">15 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="rounded-2xl overflow-hidden" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="h-1" style="background: linear-gradient(90deg, #f58220, #22c55e, #3b82f6);"></div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-[.5625rem] text-[rgba(30,41,59,0.4)] uppercase tracking-wider border-b" style="border-color: rgba(30,41,59,.06); background: rgba(248,249,250,.4);">
                        <th class="px-5 py-3.5 font-semibold">Course</th>
                        <th class="px-5 py-3.5 font-semibold">Status</th>
                        <th class="px-5 py-3.5 font-semibold">Lessons</th>
                        <th class="px-5 py-3.5 font-semibold">Enrollments</th>
                        <th class="px-5 py-3.5 font-semibold">Price</th>
                        <th class="px-5 py-3.5 font-semibold">Updated</th>
                        <th class="px-5 py-3.5 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($courses as $course)
                        @php
                            $status = $course->status?->value ?? 'draft';
                            $statusStyles = [
                                'published' => ['bg' => 'rgba(34,197,94,.08)', 'text' => '#16a34a', 'dot' => '#22c55e'],
                                'draft' => ['bg' => 'rgba(30,41,59,.04)', 'text' => 'rgba(30,41,59,.5)', 'dot' => 'rgba(30,41,59,.3)'],
                                'archived' => ['bg' => 'rgba(245,158,11,.08)', 'text' => '#b45309', 'dot' => '#f59e0b'],
                            ];
                            $ss = $statusStyles[$status] ?? $statusStyles['draft'];
                        @endphp
                        <tr class="crs-row border-b" style="border-color: rgba(30,41,59,.04);">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(245,130,32,.08);">
                                        <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.courses.show', $course) }}" wire:navigate class="font-bold text-sm text-(--color-smoke) hover:underline">{{ $course->title }}</a>
                                        <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">
                                            {{ $course->slug }}
                                            @if($course->creator)
                                                <span class="mx-0.5">·</span>by {{ $course->creator->name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[.5625rem] font-bold" style="background: {{ $ss['bg'] }}; color: {{ $ss['text'] }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $ss['dot'] }};"></span>
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[.5625rem] font-bold" style="background: rgba(59,130,246,.08); color: #2563eb;">
                                    {{ $course->lessons_count }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[.5625rem] font-bold" style="background: rgba(34,197,94,.08); color: #16a34a;">
                                    {{ $course->enrollments_count }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-sm font-bold text-(--color-smoke)">{{ $course->currency }} {{ number_format((float) $course->price_amount, 2) }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-[.625rem] text-[rgba(30,41,59,0.4)] flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                    {{ $course->updated_at?->diffForHumans() }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.courses.edit', $course) }}" wire:navigate class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: rgba(245,130,32,.08); color: var(--color-terra);">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.courses.show', $course) }}" wire:navigate class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[.625rem] font-semibold transition-all hover:scale-105" style="background: rgba(59,130,246,.08); color: #2563eb;">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(245,130,32,.06);">
                                    <svg class="w-8 h-8" style="color: rgba(245,130,32,.4);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                </div>
                                <h3 class="font-bold text-base text-(--color-smoke) mb-1">No Courses Found</h3>
                                <p class="text-sm text-[rgba(30,41,59,0.5)]">Try adjusting your search or create a new course</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courses->hasPages())
            <div class="p-4 border-t" style="border-color: rgba(30,41,59,.06);">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
