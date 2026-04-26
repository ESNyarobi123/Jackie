<?php

namespace App\Livewire\Admin\Courses;

use App\Enums\LessonContentType;
use App\Enums\LessonStatus;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\Video\LessonMediaService;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public Course $course;

    public bool $showCreateLessonModal = false;

    public ?int $editingLessonId = null;

    public string $lesson_title = '';
    public string $lesson_slug = '';
    public ?string $lesson_summary = null;
    public string $lesson_content_type = 'video';
    public string $lesson_status = 'draft';
    public string $lesson_media_source = 'upload';
    public ?string $lesson_video_provider = null;
    public ?string $lesson_video_asset = null;
    public ?string $lesson_resource_url = null;
    public $lesson_video_file = null;
    public int $lesson_duration_seconds = 0;
    public int $lesson_sort_order = 1;
    public bool $lesson_is_preview = false;
    public ?string $lesson_published_at = null;

    public function mount(Course $course): void
    {
        $this->course = $course->load(['creator:id,name,email', 'lessons']);
        $this->lesson_sort_order = max(1, (int) $this->course->lessons()->max('sort_order') + 1);
    }

    public function openCreateLesson(): void
    {
        $this->resetLessonForm();
        $this->showCreateLessonModal = true;
    }

    public function openEditLesson(int $lessonId): void
    {
        $lesson = Lesson::query()
            ->where('course_id', $this->course->id)
            ->findOrFail($lessonId);

        $this->resetValidation();
        $this->editingLessonId = $lesson->id;
        $this->lesson_title = $lesson->title;
        $this->lesson_slug = $lesson->slug;
        $this->lesson_summary = $lesson->summary;
        $this->lesson_content_type = $lesson->content_type?->value ?? LessonContentType::Video->value;
        $this->lesson_status = $lesson->status?->value ?? LessonStatus::Draft->value;
        $this->lesson_media_source = $this->mediaSourceFor($lesson);
        $this->lesson_video_provider = $lesson->video_provider;
        $this->lesson_video_asset = $lesson->video_asset;
        $this->lesson_resource_url = $lesson->resource_url;
        $this->lesson_video_file = null;
        $this->lesson_duration_seconds = (int) $lesson->duration_seconds;
        $this->lesson_sort_order = (int) $lesson->sort_order;
        $this->lesson_is_preview = (bool) $lesson->is_preview;
        $this->lesson_published_at = $lesson->published_at?->format('Y-m-d\TH:i');
        $this->showCreateLessonModal = true;
    }

    public function updatedLessonTitle(): void
    {
        if ($this->lesson_slug === '') {
            $this->lesson_slug = Str::slug($this->lesson_title);
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function lessonRules(): array
    {
        return [
            'lesson_title' => ['required', 'string', 'max:255'],
            'lesson_slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lessons', 'slug')
                    ->where(fn ($query) => $query->where('course_id', $this->course->id))
                    ->ignore($this->editingLessonId),
            ],
            'lesson_summary' => ['nullable', 'string', 'max:255'],
            'lesson_content_type' => ['required', Rule::enum(LessonContentType::class)],
            'lesson_status' => ['required', Rule::enum(LessonStatus::class)],
            'lesson_media_source' => ['required', Rule::in(['upload', 'url', 'asset'])],
            'lesson_video_file' => [
                Rule::requiredIf($this->editingLessonId === null && $this->lesson_content_type === LessonContentType::Video->value && $this->lesson_media_source === 'upload'),
                'nullable',
                File::types(['mp4', 'mov', 'webm', 'm4v'])->max(512 * 1024),
            ],
            'lesson_video_provider' => [
                Rule::requiredIf($this->lesson_content_type === LessonContentType::Video->value && $this->lesson_media_source === 'asset'),
                'nullable',
                'string',
                'max:100',
            ],
            'lesson_video_asset' => [
                Rule::requiredIf($this->lesson_content_type === LessonContentType::Video->value && $this->lesson_media_source === 'asset'),
                'nullable',
                'string',
                'max:255',
            ],
            'lesson_resource_url' => [
                Rule::requiredIf(in_array($this->lesson_media_source, ['url'], true) || in_array($this->lesson_content_type, [LessonContentType::Pdf->value, LessonContentType::Link->value], true)),
                'nullable',
                'url',
                'max:2048',
            ],
            'lesson_duration_seconds' => ['required', 'integer', 'min:0'],
            'lesson_sort_order' => ['required', 'integer', 'min:1'],
            'lesson_is_preview' => ['boolean'],
            'lesson_published_at' => ['nullable', 'date'],
        ];
    }

    public function createLesson(): void
    {
        $this->saveLesson();
    }

    public function saveLesson(): void
    {
        $validated = $this->validate($this->lessonRules());

        $lesson = $this->editingLessonId === null
            ? null
            : Lesson::query()
                ->where('course_id', $this->course->id)
                ->findOrFail($this->editingLessonId);

        $payload = $this->lessonPayload($validated, $lesson);

        if ($lesson === null) {
            Lesson::query()->create([
                'course_id' => $this->course->id,
                ...$payload,
            ]);
        } else {
            $lesson->update($payload);
        }

        $this->course = $this->course->fresh()->load(['creator:id,name,email', 'lessons']);
        $this->showCreateLessonModal = false;
        $this->resetLessonForm();
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function lessonPayload(array $validated, ?Lesson $lesson): array
    {
        $publishedAt = $validated['lesson_published_at'];
        if ($validated['lesson_status'] === LessonStatus::Published->value && $publishedAt === null) {
            $publishedAt = $lesson?->published_at ?? now();
        }

        $payload = [
            'title' => $validated['lesson_title'],
            'slug' => $validated['lesson_slug'],
            'summary' => $validated['lesson_summary'],
            'content_type' => $validated['lesson_content_type'],
            'status' => $validated['lesson_status'],
            'duration_seconds' => $validated['lesson_duration_seconds'],
            'sort_order' => $validated['lesson_sort_order'],
            'is_preview' => $validated['lesson_is_preview'],
            'published_at' => $publishedAt,
        ];

        if ($validated['lesson_media_source'] === 'upload' && $this->lesson_video_file !== null) {
            $payload['media_source'] = 'upload';
            $payload['video_file'] = $this->lesson_video_file;
        }

        if ($validated['lesson_media_source'] === 'url') {
            $payload['media_source'] = 'url';
            $payload['resource_url'] = $validated['lesson_resource_url'];
        }

        if ($validated['lesson_media_source'] === 'asset') {
            $payload['media_source'] = 'asset';
            $payload['video_provider'] = $validated['lesson_video_provider'];
            $payload['video_asset'] = $validated['lesson_video_asset'];
        }

        return app(LessonMediaService::class)->apply($payload, $lesson);
    }

    public function deleteLesson(int $lessonId): void
    {
        $lesson = Lesson::query()
            ->where('course_id', $this->course->id)
            ->findOrFail($lessonId);

        app(LessonMediaService::class)->deleteLocalVideo($lesson);

        $lesson->delete();
        $this->course = $this->course->fresh()->load(['creator:id,name,email', 'lessons']);
    }

    private function resetLessonForm(): void
    {
        $this->lesson_title = '';
        $this->lesson_slug = '';
        $this->lesson_summary = null;
        $this->lesson_content_type = LessonContentType::Video->value;
        $this->lesson_status = LessonStatus::Draft->value;
        $this->lesson_media_source = 'upload';
        $this->lesson_video_provider = null;
        $this->lesson_video_asset = null;
        $this->lesson_resource_url = null;
        $this->lesson_video_file = null;
        $this->lesson_duration_seconds = 0;
        $this->lesson_sort_order = max(1, (int) $this->course->lessons()->max('sort_order') + 1);
        $this->lesson_is_preview = false;
        $this->lesson_published_at = null;
        $this->editingLessonId = null;
    }

    private function mediaSourceFor(Lesson $lesson): string
    {
        if ($lesson->video_provider === 'local') {
            return 'upload';
        }

        if ($lesson->video_provider === 'url' || $lesson->resource_url !== null) {
            return 'url';
        }

        return $lesson->video_asset !== null ? 'asset' : 'upload';
    }

    public function render()
    {
        return view('livewire.admin.courses.show');
    }
}
