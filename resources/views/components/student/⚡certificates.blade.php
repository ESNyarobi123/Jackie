<?php

use Livewire\Component;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use Illuminate\Support\Str;

new class extends Component
{
    public $certificates = [];
    public $inProgress = [];
    public $stats = [];

    public function mount()
    {
        $this->syncCertificates();
        $this->loadData();
    }

    /**
     * Create missing certificates for completed enrollments.
     */
    public function syncCertificates(): void
    {
        $user = auth()->user();

        $completed = $user->enrollments()
            ->where('progress_percentage', '>=', 100)
            ->with('course')
            ->get();

        foreach ($completed as $enrollment) {
            if (! $enrollment->course) {
                continue;
            }

            $exists = Certificate::query()
                ->where('user_id', $user->id)
                ->where('course_id', $enrollment->course_id)
                ->exists();

            if ($exists) {
                continue;
            }

            $score = (int) QuizAttempt::query()
                ->where('user_id', $user->id)
                ->whereHas('quiz', fn ($q) => $q->where('course_id', $enrollment->course_id))
                ->avg('score_percentage');

            Certificate::query()->create([
                'user_id' => $user->id,
                'course_id' => $enrollment->course_id,
                'enrollment_id' => $enrollment->id,
                'score_percentage' => $score,
                'certificate_number' => Str::upper('CERT-'.Str::random(10)),
                'issued_at' => $enrollment->completed_at ?? now(),
                'metadata' => [],
            ]);
        }
    }

    public function loadData()
    {
        $user = auth()->user();
        
        $issuedCertificates = Certificate::query()
            ->where('user_id', $user->id)
            ->with('course:id,title,slug')
            ->latest('issued_at')
            ->get();

        $this->certificates = $issuedCertificates->map(fn ($c) => [
            'id' => $c->id,
            'course' => $c->course?->title ?? '—',
            'course_id' => $c->course_id,
            'completed_at' => $c->issued_at?->format('M d, Y') ?? 'Recently',
            'completed_date' => $c->issued_at,
            'score' => (int) $c->score_percentage,
            'download_url' => $c->pdf_path ? \Illuminate\Support\Facades\Storage::url($c->pdf_path) : null,
        ])->toArray();
        
        // Get in-progress courses
        $this->inProgress = $user->enrollments()
            ->where('progress_percentage', '<', 100)
            ->where('progress_percentage', '>', 0)
            ->with('course')
            ->orderByDesc('progress_percentage')
            ->limit(5)
            ->get();
            
        // Calculate stats
        $this->stats = [
            'total' => count($this->certificates),
            'this_month' => collect($this->certificates)->where('completed_date', '>=', now()->startOfMonth())->count(),
            'in_progress' => $user->enrollments()->where('progress_percentage', '<', 100)->where('progress_percentage', '>', 0)->count(),
            'average_score' => count($this->certificates) > 0 ? round(collect($this->certificates)->avg('score')) : 0,
        ];
    }

    public function downloadCertificate($certId)
    {
        $cert = Certificate::query()->where('user_id', auth()->id())->findOrFail($certId);

        if (! $cert->pdf_path) {
            $this->dispatch('notify', message: 'Certificate PDF is not generated yet.');

            return;
        }

        return redirect()->to(\Illuminate\Support\Facades\Storage::url($cert->pdf_path));
    }

    public function shareCertificate($certId)
    {
        $this->dispatch('notify', message: 'Share link copied to clipboard!');
    }
}; ?>

<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-(--color-terra)">{{ $stats['total'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Certificates</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-green-500">{{ $stats['this_month'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">This Month</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-blue-500">{{ $stats['in_progress'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">In Progress</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-purple-500">{{ $stats['average_score'] ?? 0 }}%</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Avg Score</div>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-(--color-smoke)">My Certificates</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Your achievements and credentials</p>
        </div>
        @if(count($certificates) > 0)
            <button class="btn-glass-outline text-sm" wire:click="$dispatch('notify', {message: 'Sharing all certificates...'})">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                Share All
            </button>
        @endif
    </div>

    <!-- Certificates Grid -->
    <div class="grid gap-4">
        @forelse($certificates as $cert)
            <div class="glass-card p-5 glass-elevated" style="background: linear-gradient(135deg, rgba(245,130,32,0.08), rgba(255,255,255,0.6));">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-xl shrink-0 flex items-center justify-center text-3xl bg-[rgba(245,130,32,0.15)]">🎓</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-bold text-lg text-(--color-smoke)">{{ $cert['course'] }}</h3>
                            <span class="pill pill-green text-xs">{{ $cert['score'] }}%</span>
                        </div>
                        <p class="text-sm text-[rgba(30,41,59,0.6)] mt-1">Certificate of Completion</p>
                        <p class="text-xs text-[rgba(30,41,59,0.5)] mt-1">
                            <span class="flex items-center gap-1">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                Completed {{ $cert['completed_at'] }}
                            </span>
                        </p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <button wire:click="downloadCertificate({{ $cert['id'] }})" class="btn-premium text-sm">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Download
                        </button>
                        <button wire:click="shareCertificate({{ $cert['id'] }})" class="btn-glass-outline text-sm">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            Share
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card p-8 text-center glass-elevated">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-[rgba(245,130,32,0.1)] flex items-center justify-center text-4xl">📜</div>
                <h3 class="font-bold text-xl text-(--color-smoke) mb-2">No Certificates Yet</h3>
                <p class="text-sm text-[rgba(30,41,59,0.6)] mb-4 max-w-md mx-auto">Complete your enrolled courses with at least 80% score to earn your digital certificates.</p>
                <a href="{{ route('student.courses') }}" class="btn-premium">
                    Continue Learning
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Locked Certificates -->
    @if(count($inProgress) > 0)
    <div class="glass-card p-5 glass-soft-shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-(--color-smoke)">Courses in Progress</h2>
            <span class="text-sm text-[rgba(30,41,59,0.5)]">Complete to unlock certificates</span>
        </div>
        <div class="space-y-3">
            @foreach($inProgress as $enrollment)
                <div class="flex items-center gap-3 p-3 rounded-lg bg-[rgba(255,255,255,0.4)] opacity-75">
                    <div class="w-10 h-10 rounded-lg shrink-0 flex items-center justify-center text-lg bg-[rgba(30,41,59,0.08)]">🔒</div>
                    <div class="flex-1">
                        <h4 class="font-medium text-sm text-(--color-smoke)">{{ $enrollment->course->title }}</h4>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="h-1.5 flex-1 bg-[rgba(30,41,59,0.08)] rounded-full overflow-hidden">
                                <div class="h-full bg-(--color-terra) rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                            </div>
                            <span class="text-xs text-[rgba(30,41,59,0.5)]">{{ $enrollment->progress_percentage }}%</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>