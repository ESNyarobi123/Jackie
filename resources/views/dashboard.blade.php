<x-layouts.app title="Dashboard">
    @if(auth()->user()->isAdmin())
        <livewire:admin.dashboard />
    @else
        <livewire:student.dashboard />
    @endif
</x-layouts.app>
