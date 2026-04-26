<?php

namespace App\Livewire\Student;

use App\Models\LiveClass;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class LiveClasses extends Component
{
    public $upcomingClasses = [];
    public $pastClasses = [];
    public $stats = [];

    public function mount()
    {
        $this->loadClasses();
        $this->calculateStats();
    }

    public function loadClasses()
    {
        $courseIds = auth()->user()
            ->enrollments()
            ->active()
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->pluck('course_id');
        
        $this->upcomingClasses = LiveClass::query()
            ->whereIn('course_id', $courseIds)
            ->visibleToStudents()
            ->where('scheduled_at', '>', now()->subHours(2))
            ->orderBy('scheduled_at')
            ->with('course')
            ->get()
            ->toArray();
            
        $this->pastClasses = LiveClass::query()
            ->whereIn('course_id', $courseIds)
            ->where('status', 'ended')
            ->orderBy('scheduled_at', 'desc')
            ->with('course')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function calculateStats()
    {
        $upcoming = collect($this->upcomingClasses);
        $past = collect($this->pastClasses);

        $this->stats = [
            'upcoming' => $upcoming->count(),
            'this_week' => $upcoming->filter(fn ($c) => \Carbon\Carbon::parse($c['scheduled_at'])->isCurrentWeek())->count(),
            'attended' => $past->count(),
            'recordings' => 0,
        ];
    }

    public function joinClass($classId)
    {
        $this->dispatch('notify', message: 'Joining live class...');
    }

    public function setReminder($classId)
    {
        $this->dispatch('notify', message: 'Reminder set!');
    }

    public function render()
    {
        return view('livewire.student.live-classes');
    }
}
