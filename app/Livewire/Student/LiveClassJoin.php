<?php

namespace App\Livewire\Student;

use App\Enums\EnrollmentStatus;
use App\Models\LiveClass;
use App\Services\Video\JitsiMeetService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Livewire\Component;

class LiveClassJoin extends Component
{
    public LiveClass $liveClass;

    /** @var array<string, mixed> */
    public array $meeting = [];

    public bool $canJoin = false;

    public function mount(LiveClass $liveClass, JitsiMeetService $jitsi): void
    {
        $this->liveClass = $liveClass->load(['course:id,title,slug']);

        abort_if(! $this->studentHasAccess(), Response::HTTP_NOT_FOUND);

        $this->canJoin = $this->liveClass->isJoinable();

        if ($this->canJoin) {
            /** @var \App\Models\User $user */
            $user = auth()->user();

            $this->meeting = $jitsi->meetingPayload($this->liveClass, $user);
        }
    }

    public function render()
    {
        return view('livewire.student.live-class-join');
    }

    private function studentHasAccess(): bool
    {
        return auth()->user()
            ->enrollments()
            ->where('course_id', $this->liveClass->course_id)
            ->where('status', EnrollmentStatus::Active->value)
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->exists();
    }
}
