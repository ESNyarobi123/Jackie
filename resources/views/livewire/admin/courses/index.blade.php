<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Courses</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Create, publish, and manage your course catalog.</p>
        </div>

        <div class="shrink-0">
            <flux:button variant="primary" href="{{ route('admin.courses.create') }}" wire:navigate>
                Create course
            </flux:button>
        </div>
    </div>

    <div class="glass-card p-4 glass-soft-shadow space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <flux:field>
                <flux:label>Search</flux:label>
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Title or slug..." />
            </flux:field>

            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select wire:model.live="status">
                    @foreach($this->statusOptions() as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <flux:label>Per page</flux:label>
                <flux:select wire:model.live="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
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
                        <th class="px-5 py-3">Course</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Lessons</th>
                        <th class="px-5 py-3">Enrollments</th>
                        <th class="px-5 py-3">Price</th>
                        <th class="px-5 py-3">Updated</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($courses as $course)
                        <tr class="border-b border-[rgba(30,41,59,0.06)] hover:bg-[rgba(245,130,32,0.04)] transition">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[var(--color-smoke)]">
                                    <a class="hover:underline" href="{{ route('admin.courses.show', $course) }}" wire:navigate>
                                        {{ $course->title }}
                                    </a>
                                </div>
                                <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">
                                    {{ $course->slug }}
                                    @if($course->creator)
                                        <span class="mx-1">·</span>
                                        by {{ $course->creator->name }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                @php($status = $course->status?->value ?? (string) $course->status)
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $status === 'published' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $status === 'draft' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $status === 'archived' ? 'bg-amber-100 text-amber-700' : '' }}
                                ">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $course->lessons_count }}
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $course->enrollments_count }}
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $course->currency }} {{ number_format((float) $course->price_amount, 2) }}
                            </td>
                            <td class="px-5 py-4 text-xs text-[rgba(30,41,59,0.55)]">
                                {{ $course->updated_at?->diffForHumans() }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" href="{{ route('admin.courses.edit', $course) }}" wire:navigate>
                                        Edit
                                    </flux:button>
                                    <flux:button size="sm" variant="ghost" href="{{ route('admin.courses.show', $course) }}" wire:navigate>
                                        View
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-[rgba(30,41,59,0.55)]">
                                No courses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[rgba(30,41,59,0.06)]">
            {{ $courses->links() }}
        </div>
    </div>
</div>
