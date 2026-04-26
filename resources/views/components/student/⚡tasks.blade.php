<?php

use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Lesson;

new class extends Component
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
        
        // Get active enrollments with courses and their published lessons
        $enrollments = $user->enrollments()
            ->active()
            ->with(['course' => function($query) {
                $query->with(['lessons' => function($q) {
                    $q->published()->orderBy('sort_order');
                }]);
            }])
            ->get();
        
        $this->pendingTasks = [];
        $this->completedTasks = [];
        
        foreach ($enrollments as $enrollment) {
            if (!$enrollment->course) continue;
            
            $totalLessons = $enrollment->course->lessons->count();
            if ($totalLessons === 0) continue;
            
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
        usort($this->pendingTasks, function($a, $b) {
            if (isset($a['is_next']) && !isset($b['is_next'])) return -1;
            if (!isset($a['is_next']) && isset($b['is_next'])) return 1;
            return 0;
        });
    }

    public function formatDuration($seconds)
    {
        if (!$seconds) return '—';
        $mins = floor($seconds / 60);
        return $mins < 60 ? "{$mins} min" : floor($mins / 60) . 'h ' . ($mins % 60) . 'm';
    }

    public function getTypeIcon($type)
    {
        return match($type) {
            'video' => '🎥',
            'audio' => '🎧',
            'document' => '📄',
            'quiz' => '❓',
            default => '📚',
        };
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function startTask($taskId)
    {
        // Navigate to lesson
        $this->dispatch('notify', message: 'Starting lesson...');
    }

    public function markComplete($taskId)
    {
        // Mark lesson as complete and refresh
        $this->dispatch('notify', message: 'Lesson marked as complete!');
        $this->loadTasks();
        $this->calculateStats();
    }
}; ?>

<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-(--color-terra)">{{ $stats['total'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Total Tasks</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-amber-500">{{ $stats['pending'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Pending</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-green-500">{{ $stats['completed'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Completed</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-blue-500">{{ $stats['progress'] ?? 0 }}%</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Progress</div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-(--color-smoke)">My Tasks</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Your learning journey, one lesson at a time</p>
        </div>
        @if($stats['pending'] > 0)
            <div class="text-sm text-[rgba(30,41,59,0.6)]">
                🎯 <span class="font-semibold text-(--color-terra)">{{ $stats['pending'] }}</span> tasks waiting for you
            </div>
        @endif
    </div>

    <!-- Progress Bar -->
    <div class="glass-card p-4">
        <div class="flex items-center justify-between text-sm mb-2">
            <span class="text-[rgba(30,41,59,0.7)]">Overall Progress</span>
            <span class="font-bold text-(--color-terra)">{{ $stats['progress'] ?? 0 }}%</span>
        </div>
        <div class="h-3 bg-[rgba(30,41,59,0.08)] rounded-full overflow-hidden">
            <div class="h-full bg-linear-to-r from-(--color-terra) to-[#F58220] rounded-full transition-all duration-700"
                 style="width: {{ $stats['progress'] ?? 0 }}%"></div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 border-b border-[rgba(30,41,59,0.08)] pb-1">
        <button wire:click="setTab('pending')" 
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-t-lg transition-colors {{ $activeTab === 'pending' ? 'text-(--color-terra) border-b-2 border-(--color-terra) bg-[rgba(245,130,32,0.05)]' : 'text-[rgba(30,41,59,0.6)] hover:text-(--color-smoke)' }}">
            <span>⏳</span>
            Pending
            <span class="pill pill-amber text-xs py-0.5 px-2">{{ count($pendingTasks) }}</span>
        </button>
        <button wire:click="setTab('completed')" 
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-t-lg transition-colors {{ $activeTab === 'completed' ? 'text-(--color-terra) border-b-2 border-(--color-terra) bg-[rgba(245,130,32,0.05)]' : 'text-[rgba(30,41,59,0.6)] hover:text-(--color-smoke)' }}">
            <span>✅</span>
            Completed
            <span class="pill pill-green text-xs py-0.5 px-2">{{ count($completedTasks) }}</span>
        </button>
    </div>

    <!-- Tasks List -->
    <div class="space-y-3">
        @if($activeTab === 'pending')
            @forelse($pendingTasks as $index => $task)
                <div class="glass-card p-4 glass-soft-shadow hover:shadow-lg transition-all {{ isset($task['is_next']) ? 'border-l-4 border-l-(--color-terra)' : '' }}">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl shrink-0 flex items-center justify-center text-xl {{ isset($task['is_next']) ? 'bg-[rgba(245,130,32,0.15)]' : 'bg-[rgba(30,41,59,0.06)]' }}">
                            {{ $task['thumbnail'] }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-semibold text-(--color-smoke)">{{ $task['title'] }}</h3>
                                @if(isset($task['is_next']))
                                    <span class="pill pill-terra text-xs">Next Up</span>
                                @endif
                            </div>
                            <p class="text-xs text-[rgba(30,41,59,0.6)] mt-1">
                                {{ $task['course'] }} • {{ $task['duration'] }} • {{ $task['due'] }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(isset($task['is_next']))
                                <button wire:click="startTask({{ $task['id'] }})" class="btn-premium text-sm">
                                    Start Now
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                </button>
                            @else
                                <button wire:click="startTask({{ $task['id'] }})" class="btn-glass-outline text-sm">
                                    View
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass-card p-8 text-center glass-elevated">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-[rgba(34,197,94,0.1)] flex items-center justify-center text-4xl">🎉</div>
                    <h3 class="font-bold text-xl text-(--color-smoke) mb-2">All Caught Up!</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.6)] mb-4">You've completed all your tasks. Time to explore new courses?</p>
                    <a href="{{ route('home') }}#courses" class="btn-premium">
                        Browse Courses
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>
            @endforelse
        @else
            @forelse($completedTasks as $task)
                <div class="glass-card p-4 glass-soft-shadow opacity-80 hover:opacity-100 transition-opacity">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl shrink-0 flex items-center justify-center text-xl bg-[rgba(34,197,94,0.1)]">
                            {{ $task['thumbnail'] }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-(--color-smoke) line-through">{{ $task['title'] }}</h3>
                            <p class="text-xs text-[rgba(30,41,59,0.6)] mt-1">
                                {{ $task['course'] }} • {{ $task['duration'] }} • Completed {{ $task['completed_at'] }}
                            </p>
                        </div>
                        <span class="pill pill-green">Done</span>
                    </div>
                </div>
            @empty
                <div class="glass-card p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[rgba(30,41,59,0.06)] flex items-center justify-center text-3xl">📝</div>
                    <h3 class="font-bold text-lg text-(--color-smoke) mb-2">No Completed Tasks Yet</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.6)]">Start learning to see your progress here!</p>
                </div>
            @endforelse
        @endif
    </div>
</div>