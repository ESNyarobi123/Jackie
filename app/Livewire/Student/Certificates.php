<?php

namespace App\Livewire\Student;

use Livewire\Component;

class Certificates extends Component
{
    public $certificates = [];

    public $stats = [];

    public function mount()
    {
        $this->loadCertificates();
        $this->calculateStats();
    }

    public function loadCertificates()
    {
        $user = auth()->user();

        $enrollments = $user->enrollments()
            ->with('course')
            ->where('progress_percentage', '>=', 100)
            ->get();

        $this->certificates = $enrollments->map(function ($enrollment) {
            return [
                'id' => $enrollment->id,
                'course' => $enrollment->course?->title ?? 'Unknown',
                'completed_at' => $enrollment->updated_at?->format('M d, Y') ?? 'Recently',
                'score' => $enrollment->progress_percentage ?? 100,
            ];
        })->toArray();
    }

    public function calculateStats()
    {
        $total = count($this->certificates);

        $this->stats = [
            'total' => $total,
            'earned' => $total,
            'courses' => auth()->user()->enrollments()->count(),
        ];
    }

    public function downloadCertificate($enrollmentId)
    {
        $this->dispatch('notify', message: 'Certificate download coming soon!');
    }

    public function render()
    {
        return view('livewire.student.certificates');
    }
}
