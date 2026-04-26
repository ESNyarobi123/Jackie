<?php

namespace App\Livewire\Student;

use App\Enums\LessonContentType;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Services\Learning\LessonAccessService;
use Illuminate\Http\Response;
use Livewire\Component;

class LessonPlayer extends Component
{
    public Lesson $lesson;

    public Enrollment $enrollment;

    public ?Lesson $previousLesson = null;

    public ?Lesson $nextLesson = null;

    public function mount(Lesson $lesson, LessonAccessService $access): void
    {
        $this->lesson = $lesson->load('course');

        abort_unless($access->canOpenLesson(auth()->user(), $this->lesson), Response::HTTP_NOT_FOUND);

        $enrollment = $access->activeEnrollmentFor(auth()->user(), $this->lesson);

        abort_if($enrollment === null, Response::HTTP_NOT_FOUND);

        $this->enrollment = $enrollment;
        $this->loadNeighbors();
    }

    public function markComplete(LessonAccessService $access): void
    {
        $enrollment = $access->markCompleted(auth()->user(), $this->lesson);

        if ($enrollment !== null) {
            $this->enrollment = $enrollment;
        }

        if ($this->nextLesson !== null) {
            $this->redirectRoute('student.lessons.show', $this->nextLesson, navigate: true);

            return;
        }

        $this->dispatch('notify', message: 'Lesson completed.');
    }

    public function getMediaUrlProperty(): ?string
    {
        if ($this->lesson->video_provider === 'local' || $this->lesson->resource_url !== null) {
            return route('student.lessons.media', $this->lesson);
        }

        return null;
    }

    public function getIsVideoProperty(): bool
    {
        return $this->lesson->content_type === LessonContentType::Video;
    }

    public function render()
    {
        return view('livewire.student.lesson-player');
    }

    private function loadNeighbors(): void
    {
        $lessons = $this->lesson
            ->course
            ->lessons()
            ->published()
            ->get(['id', 'course_id', 'title', 'slug', 'sort_order']);

        $index = $lessons->search(fn (Lesson $lesson): bool => $lesson->id === $this->lesson->id);

        if ($index === false) {
            return;
        }

        $this->previousLesson = $lessons->get($index - 1);
        $this->nextLesson = $lessons->get($index + 1);
    }
}
