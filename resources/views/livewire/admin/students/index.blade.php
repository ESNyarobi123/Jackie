<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-[var(--color-smoke)]">Students</h1>
        <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Browse and support student accounts.</p>
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
                        <th class="px-5 py-3">Student</th>
                        <th class="px-5 py-3">Enrollments</th>
                        <th class="px-5 py-3">Subscriptions</th>
                        <th class="px-5 py-3">Payments</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($students as $student)
                        <tr class="border-b border-[rgba(30,41,59,0.06)] hover:bg-[rgba(245,130,32,0.04)] transition">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[var(--color-smoke)]">
                                    <a href="{{ route('admin.students.show', $student) }}" class="hover:underline" wire:navigate>
                                        {{ $student->name }}
                                    </a>
                                </div>
                                <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">
                                    {{ $student->email }}
                                    @if($student->phone)
                                        <span class="mx-1">·</span>{{ $student->phone }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">{{ $student->enrollments_count }}</td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">{{ $student->subscriptions_count }}</td>
                            <td class="px-5 py-4 text-[rgba(30,41,59,0.75)]">{{ $student->payments_count }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                    {{ ucfirst($student->status?->value ?? (string) $student->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <flux:button size="sm" variant="ghost" href="{{ route('admin.students.show', $student) }}" wire:navigate>
                                    View
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-[rgba(30,41,59,0.55)]">
                                No students found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[rgba(30,41,59,0.06)]">
            {{ $students->links() }}
        </div>
    </div>
</div>
