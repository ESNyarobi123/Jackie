<?php

namespace App\Livewire\Admin\LiveClasses;

use App\Enums\LiveClassProvider;
use App\Enums\LiveClassStatus;
use App\Models\Course;
use App\Models\LiveClass;
use App\Services\Video\JitsiMeetService;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class Create extends Component
{
    public int $course_id = 0;
    public string $title = '';
    public ?string $description = null;
    public string $status = 'scheduled';
    public string $scheduled_at = '';
    public int $duration_minutes = 60;
    public ?string $room_name = null;

    /** @var array<int, array{id:int,title:string}> */
    public array $courses = [];

    public function mount(): void
    {
        $this->courses = Course::query()->orderBy('title')->get(['id', 'title'])->toArray();
        $this->scheduled_at = now()->addDay()->format('Y-m-d\TH:i');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(LiveClassStatus::class)],
            'scheduled_at' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:360'],
            'room_name' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z0-9_-]+$/', Rule::unique(LiveClass::class, 'room_name')],
        ];
    }

    public function save(JitsiMeetService $jitsi): void
    {
        $validated = $this->validate();

        $course = Course::query()->findOrFail($validated['course_id']);
        $scheduledAt = Carbon::parse($validated['scheduled_at']);
        $roomName = $validated['room_name'] ?: $jitsi->makeRoomName(
            course: $course,
            title: $validated['title'],
            scheduledAt: $scheduledAt,
        );

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $liveClass = LiveClass::query()->create([
            'course_id' => $validated['course_id'],
            'created_by' => $user->id,
            'provider' => LiveClassProvider::Jitsi->value,
            'status' => $validated['status'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'room_name' => $roomName,
            'join_url' => $jitsi->joinUrl($roomName),
            'scheduled_at' => $scheduledAt,
            'duration_minutes' => $validated['duration_minutes'],
            'settings' => [],
        ]);

        $this->redirectRoute('admin.live-classes.show', $liveClass, navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.live-classes.create');
    }
}
