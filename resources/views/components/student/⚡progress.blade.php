<?php

use Livewire\Component;

new class extends Component
{
    public $stats = [];
    public $courseProgress = [];

    public function mount()
    {
        $user = auth()->user();
        
        $this->stats = [
            'completed_lessons' => $user->enrollments()->sum('progress_percentage') / 100,
            'avg_score' => 86,
            'live_attended' => 5,
            'total_enrollments' => $user->enrollments()->count(),
        ];

        $this->courseProgress = $user->enrollments()
            ->with('course')
            ->get()
            ->map(fn($e) => [
                'course' => $e->course->title,
                'progress' => $e->progress_percentage,
            ])
            ->toArray();
    }
}; ?>

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-(--color-smoke)">My Progress</h1>
        <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Track your learning across all courses</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-card p-4 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['completed_lessons'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Lessons Completed</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-3xl font-bold text-(--color-terra)">{{ $stats['avg_score'] ?? 0 }}%</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Average Score</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-3xl font-bold text-(--color-smoke)">{{ $stats['live_attended'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Live Classes</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $stats['total_enrollments'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Enrolled Courses</div>
        </div>
    </div>

    <!-- Course Progress -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Course Progress</h2>
        <div class="space-y-4">
            @forelse($courseProgress as $progress)
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-medium text-sm text-(--color-smoke)">{{ $progress['course'] }}</span>
                        <span class="text-sm font-bold text-(--color-terra)">{{ $progress['progress'] }}%</span>
                    </div>
                    <div class="h-2 bg-[rgba(30,41,59,0.08)] rounded-full overflow-hidden">
                        <div class="h-full bg-linear-to-r from-(--color-terra) to-[#F58220] rounded-full" style="width: {{ $progress['progress'] }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-center text-[rgba(30,41,59,0.5)] py-4">You haven't enrolled in any courses yet</p>
            @endforelse
        </div>
    </div>

    <!-- Quiz Scores -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Quiz Scores</h2>
        <div class="space-y-2">
            <div class="flex items-center justify-between p-3 rounded-lg bg-[rgba(255,255,255,0.4)]">
                <span class="text-sm">Quiz 1 — Basic Greetings</span>
                <span class="pill pill-green">95%</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-lg bg-[rgba(255,255,255,0.4)]">
                <span class="text-sm">Quiz 2 — Present Tense</span>
                <span class="pill pill-green">88%</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-lg bg-[rgba(255,255,255,0.4)]">
                <span class="text-sm">Quiz 3 — Past Tense</span>
                <span class="pill pill-amber">Not Done</span>
            </div>
        </div>
    </div>
</div>