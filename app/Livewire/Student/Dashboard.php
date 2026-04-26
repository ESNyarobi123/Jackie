<?php

namespace App\Livewire\Student;

use App\Models\LiveClass;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Dashboard extends Component
{
    public $stats = [];
    public $activeEnrollments = [];
    public $nextLiveClass = null;
    public $subscription = null;
    public $recommendedCourses = [];

    public function mount()
    {
        $user = auth()->user();
        
        // Get active enrollments with courses
        $this->activeEnrollments = $user->enrollments()
            ->active()
            ->with(['course' => fn ($query) => $query->withCount('lessons')])
            ->latest('enrolled_at')
            ->limit(3)
            ->get();
        
        // Calculate stats
        $this->calculateStats();
        
        // Get next upcoming live class
        $this->loadNextLiveClass();
        
        // Get subscription
        $this->subscription = $user->subscriptions()
            ->where('status', 'active')
            ->first();

        // Check if on free trial
        $this->stats['is_trial'] = $this->subscription?->payment_id === null && $this->subscription?->access_ends_at?->gt(now());
        $this->stats['trial_ends_at'] = $this->subscription?->payment_id === null ? $this->subscription?->access_ends_at : null;
        $this->stats['trial_days_left'] = $this->stats['is_trial'] ? now()->diffInDays($this->stats['trial_ends_at']) : 0;

        $this->recommendedCourses = \App\Models\Course::query()
            ->published()
            ->withCount('lessons')
            ->orderByDesc('is_featured')
            ->latest()
            ->limit(3)
            ->get()
            ->toArray();
    }

    public function calculateStats()
    {
        $user = auth()->user();
        
        $enrollments = $user->enrollments()
            ->active()
            ->with(['course' => fn ($query) => $query->withCount('lessons')])
            ->get();

        $completedLessons = $enrollments->sum(function ($enrollment): int {
            $lessonsCount = (int) ($enrollment->course?->lessons_count ?? 0);
            $progress = (int) ($enrollment->progress_percentage ?? 0);

            return (int) floor(($progress / 100) * $lessonsCount);
        });
        
        $this->stats = [
            'active_courses' => $enrollments->count(),
            'avg_progress' => $enrollments->avg('progress_percentage') ?? 0,
            'total_lessons_completed' => $completedLessons,
            'certificates' => $user->certificates()->count(),
        ];
    }

    public function loadNextLiveClass()
    {
        $courseIds = auth()->user()
            ->enrollments()
            ->active()
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->pluck('course_id');
        
        $this->nextLiveClass = LiveClass::query()
            ->whereIn('course_id', $courseIds)
            ->visibleToStudents()
            ->where('scheduled_at', '>', now()->subHours(2))
            ->orderBy('scheduled_at')
            ->with('course')
            ->first();
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
