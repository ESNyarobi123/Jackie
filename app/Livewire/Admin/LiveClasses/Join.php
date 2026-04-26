<?php

namespace App\Livewire\Admin\LiveClasses;

use App\Models\LiveClass;
use App\Services\Video\JitsiMeetService;
use Livewire\Component;

class Join extends Component
{
    public LiveClass $liveClass;

    /** @var array<string, mixed> */
    public array $meeting = [];

    public function mount(LiveClass $liveClass, JitsiMeetService $jitsi): void
    {
        $this->liveClass = $liveClass->load(['course', 'creator']);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $this->meeting = $jitsi->meetingPayload($this->liveClass, $user, moderator: true);
    }

    public function render()
    {
        return view('livewire.admin.live-classes.join');
    }
}
