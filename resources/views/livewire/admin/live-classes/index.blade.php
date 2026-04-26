<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Live classes</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Schedule and manage live sessions.</p>
        </div>

        <div class="shrink-0">
            <flux:button variant="primary" href="{{ route('admin.live-classes.create') }}" wire:navigate>
                Create live class
            </flux:button>
        </div>
    </div>

    <div class="glass-card p-4 glass-soft-shadow">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <flux:field class="md:col-span-2">
                <flux:label>Search</flux:label>
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Title..." />
            </flux:field>

            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select wire:model.live="status">
                    <option value="">All statuses</option>
                    @foreach($statusOptions as $value)
                        <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <flux:label>Course</flux:label>
                <flux:select wire:model.live="courseId">
                    <option value="0">All courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </flux:select>
            </flux:field>
        </div>
    </div>

    <div class="glass-card p-0 glass-soft-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[rgba(248,249,250,0.55)]">
                    <tr class="text-left text-xs text-[rgba(30,41,59,0.65)] border-b border-[rgba(30,41,59,0.08)]">
                        <th class="px-5 py-3">Session</th>
                        <th class="px-5 py-3">Course</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Scheduled</th>
                        <th class="px-5 py-3">Duration</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($liveClasses as $liveClass)
                        @php($status = $liveClass->status?->value ?? (string) $liveClass->status)
                        <tr class="border-b border-[rgba(30,41,59,0.06)] hover:bg-[rgba(245,130,32,0.04)] transition">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[var(--color-smoke)]">
                                    <a href="{{ route('admin.live-classes.show', $liveClass) }}" class="hover:underline" wire:navigate>
                                        {{ $liveClass->title }}
                                    </a>
                                </div>
                                <div class="text-xs text-[rgba(30,41,59,0.55)] mt-1 break-all">
                                    {{ $liveClass->room_name }}
                                </div>
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $liveClass->course->title ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs
                                    {{ in_array($status, ['scheduled','live'], true) ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}
                                ">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $liveClass->scheduled_at?->format('M d, Y H:i') ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">
                                {{ $liveClass->duration_minutes }} min
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" href="{{ route('admin.live-classes.edit', $liveClass) }}" wire:navigate>
                                        Edit
                                    </flux:button>
                                    <flux:button size="sm" variant="ghost" href="{{ route('admin.live-classes.show', $liveClass) }}" wire:navigate>
                                        View
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-[rgba(30,41,59,0.55)]">
                                No live classes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[rgba(30,41,59,0.06)]">
            {{ $liveClasses->links() }}
        </div>
    </div>
</div>
