<?php

namespace App\Livewire\Student;

use App\Services\Learning\LessonAccessService;
use Livewire\Component;

class Tasks extends Component
{
    public $pendingTasks = [];
    public $completedTasks = [];
    public $activeTab = 'pending';
    public $stats = [];

    public function mount()
    {
        $this->loadTasks();
        $this->calculateStats();
    }

    public function calculateStats()
    {
        $totalPending = count($this->pendingTasks);
        $totalCompleted = count($this->completedTasks);
        $total = $totalPending + $totalCompleted;

        $this->stats = [
            'total' => $total,
            'pending' => $totalPending,
            'completed' => $totalCompleted,
            'progress' => $total > 0 ? round(($totalCompleted / $total) * 100) : 0,
        ];
    }

    public function loadTasks()
    {
        $user = auth()->user();
        
        $enrollments = $user->enrollments()
            ->active()
            ->where(function ($query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->with(['course' => function ($query): void {
                $query->with(['lessons' => function ($q): void {
                    $q->published()->orderBy('sort_order');
                }]);
            }])
            ->get();
        
        $this->pendingTasks = [];
        $this->completedTasks = [];
        
        foreach ($enrollments as $enrollment) {
            if (! $enrollment->course) {
                continue;
            }
            
            $totalLessons = $enrollment->course->lessons->count();
            if ($totalLessons === 0) {
                continue;
            }
            
            // Calculate completed lessons based on progress percentage
            $completedCount = (int) round(($enrollment->progress_percentage / 100) * $totalLessons);
            $lessonIndex = 0;
            
            foreach ($enrollment->course->lessons as $lesson) {
                $taskData = [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'course' => $enrollment->course->title,
                    'course_id' => $enrollment->course->id,
                    'type' => $lesson->content_type?->value ?? 'video',
                    'duration' => $this->formatDuration($lesson->duration_seconds),
                    'thumbnail' => $this->getTypeIcon($lesson->content_type?->value),
                ];
                
                // Lessons before completed count are done, current one is pending
                if ($lessonIndex < $completedCount) {
                    $taskData['completed_at'] = $enrollment->updated_at?->format('M d, Y') ?? 'Recently';
                    $this->completedTasks[] = $taskData;
                } elseif ($lessonIndex === $completedCount) {
                    $taskData['due'] = 'Next up';
                    $taskData['is_next'] = true;
                    $this->pendingTasks[] = $taskData;
                } else {
                    $taskData['due'] = 'Upcoming';
                    $this->pendingTasks[] = $taskData;
                }
                
                $lessonIndex++;
            }
        }
        
        // Sort pending: next up first, then upcoming
        usort($this->pendingTasks, function ($a, $b) {
            if (isset($a['is_next']) && ! isset($b['is_next'])) {
                return -1;
            }

            if (! isset($a['is_next']) && isset($b['is_next'])) {
                return 1;
            }

            return 0;
        });
    }

    public function formatDuration($seconds)
    {
        if (! $seconds) {
            return '—';
        }

        $mins = floor($seconds / 60);

        return $mins < 60 ? "{$mins} min" : floor($mins / 60).'h '.($mins % 60).'m';
    }

    public function getTypeIcon($type)
    {
        return match ($type) {
            'video' => '🎥',
            'pdf' => '📄',
            'link' => '🔗',
            default => '📚',
        };
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function startTask($taskId): void
    {
        $this->redirectRoute('student.lessons.show', $taskId, navigate: true);
    }

    public function markComplete($taskId, LessonAccessService $access): void
    {
        $lesson = \App\Models\Lesson::query()->findOrFail($taskId);
        $access->markCompleted(auth()->user(), $lesson);

        $this->loadTasks();
        $this->calculateStats();
    }

    public function render()
    {
        return view('livewire.student.tasks');
    }
}
