<?php

namespace App\Livewire\Student;

use Livewire\Component;

class Progress extends Component
{
    public $stats = [];

    public $courseProgress = [];

    public $quizScores = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadCourseProgress();
        $this->loadQuizScores();
    }

    public function loadStats()
    {
        $user = auth()->user();

        $enrollments = $user->enrollments()
            ->with(['course' => function ($query): void {
                $query->with(['lessons' => function ($q): void {
                    $q->published();
                }]);
            }])
            ->get();

        $completedLessons = 0;
        $totalLessons = 0;
        $totalScore = 0;
        $quizCount = 0;

        foreach ($enrollments as $enrollment) {
            if (! $enrollment->course) {
                continue;
            }

            $lessonCount = $enrollment->course->lessons->count();
            $totalLessons += $lessonCount;
            $completedLessons += (int) round(($enrollment->progress_percentage / 100) * $lessonCount);
        }

        $this->stats = [
            'completed_lessons' => $completedLessons,
            'total_lessons' => $totalLessons,
            'avg_score' => $quizCount > 0 ? round($totalScore / $quizCount) : 0,
            'live_attended' => 0,
            'total_enrollments' => $enrollments->count(),
            'overall_progress' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
        ];
    }

    public function loadCourseProgress()
    {
        $user = auth()->user();

        $enrollments = $user->enrollments()
            ->with('course')
            ->active()
            ->get();

        $this->courseProgress = $enrollments->map(function ($enrollment) {
            return [
                'course' => $enrollment->course?->title ?? 'Unknown',
                'progress' => $enrollment->progress_percentage ?? 0,
                'status' => $enrollment->status,
            ];
        })->toArray();
    }

    public function loadQuizScores()
    {
        $this->quizScores = [];
    }

    public function render()
    {
        return view('livewire.student.progress');
    }
}
