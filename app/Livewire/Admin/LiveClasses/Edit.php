<?php

namespace App\Livewire\Admin\LiveClasses;

use App\Enums\LiveClassStatus;
use App\Models\Course;
use App\Models\LiveClass;
use App\Services\Video\JitsiMeetService;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class Edit extends Component
{
    public LiveClass $liveClass;

    public int $course_id = 0;
    public string $title = '';
    public ?string $description = null;
    public string $status = 'scheduled';
    public string $scheduled_at = '';
    public int $duration_minutes = 60;
    public string $room_name = '';

    /** @var array<int, array{id:int,title:string}> */
    public array $courses = [];

    public function mount(LiveClass $liveClass): void
    {
        $this->liveClass = $liveClass;
        $this->courses = Course::query()->orderBy('title')->get(['id', 'title'])->toArray();

        $this->course_id = (int) $liveClass->course_id;
        $this->title = (string) $liveClass->title;
        $this->description = $liveClass->description;
        $this->status = $liveClass->status?->value ?? (string) $liveClass->status;
        $this->scheduled_at = $liveClass->scheduled_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i');
        $this->duration_minutes = (int) $liveClass->duration_minutes;
        $this->room_name = (string) $liveClass->room_name;
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
            'room_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9_-]+$/', Rule::unique(LiveClass::class, 'room_name')->ignore($this->liveClass->id)],
        ];
    }

    public function save(JitsiMeetService $jitsi): void
    {
        $validated = $this->validate();

        $scheduledAt = Carbon::parse($validated['scheduled_at']);

        $this->liveClass->update([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'scheduled_at' => $scheduledAt,
            'duration_minutes' => $validated['duration_minutes'],
            'room_name' => $validated['room_name'],
            'join_url' => $jitsi->joinUrl($validated['room_name']),
        ]);

        $this->redirectRoute('admin.live-classes.show', $this->liveClass->fresh(), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.live-classes.edit');
    }
}
