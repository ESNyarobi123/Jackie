<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Services\Learning\LessonAccessService;
use Livewire\Component;

class Courses extends Component
{
    public $enrollments = [];
    public $activeTab = 'active';
    public $stats = [];
    public $searchQuery = '';

    public function mount()
    {
        $this->loadEnrollments();
        $this->calculateStats();
    }

    public function loadEnrollments()
    {
        $this->enrollments = auth()->user()
            ->enrollments()
            ->with(['course', 'subscription'])
            ->latest('enrolled_at')
            ->get()
            ->toArray();
    }

    public function calculateStats()
    {
        $enrollments = collect($this->enrollments);
        
        $this->stats = [
            'total' => $enrollments->count(),
            'active' => $enrollments->where('status', 'active')->count(),
            'completed' => $enrollments->where('status', 'completed')->count(),
            'expired' => $enrollments->where('status', 'expired')->count(),
            'avg_progress' => $enrollments->avg('progress_percentage') ?? 0,
        ];
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function continueCourse($courseId, LessonAccessService $access): void
    {
        $course = Course::query()->findOrFail($courseId);
        $lesson = $access->firstPublishedLessonFor(auth()->user(), $course);

        if ($lesson === null) {
            $this->dispatch('notify', message: 'No lesson available.');

            return;
        }

        $this->redirectRoute('student.lessons.show', $lesson, navigate: true);
    }

    public function renewCourse($enrollmentId): void
    {
        $this->dispatch('notify', message: 'Renewal happens from Payments page.');

        $this->redirectRoute('student.payments', navigate: true);
    }

    public function getFilteredEnrollmentsProperty()
    {
        $enrollments = collect($this->enrollments);
        
        if ($this->searchQuery) {
            $enrollments = $enrollments->filter(fn($e) => 
                str_contains(strtolower($e['course']['title']), strtolower($this->searchQuery))
            );
        }
        
        if ($this->activeTab !== 'all') {
            $enrollments = $enrollments->where('status', $this->activeTab);
        }
        
        return $enrollments;
    }

    public function render()
    {
        return view('livewire.student.courses');
    }
}
