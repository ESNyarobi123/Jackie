<?php

namespace App\Services\Learning;

use App\Enums\EnrollmentStatus;
use App\Enums\LessonStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class LessonAccessService
{
    public function activeEnrollmentFor(User $user, Lesson $lesson): ?Enrollment
    {
        return $user->enrollments()
            ->where('course_id', $lesson->course_id)
            ->where('status', EnrollmentStatus::Active->value)
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->first();
    }

    public function firstPublishedLessonFor(User $user, Course $course): ?Lesson
    {
        $hasAccess = $user->enrollments()
            ->where('course_id', $course->id)
            ->where('status', EnrollmentStatus::Active->value)
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->exists();

        if (! $hasAccess) {
            return null;
        }

        return $course->lessons()->published()->first();
    }

    public function markCompleted(User $user, Lesson $lesson): ?Enrollment
    {
        $enrollment = $this->activeEnrollmentFor($user, $lesson);

        if ($enrollment === null) {
            return null;
        }

        $lessons = $lesson->course
            ->lessons()
            ->published()
            ->pluck('id')
            ->values();

        $lessonIndex = $lessons->search($lesson->id);

        if ($lessonIndex === false || $lessons->count() === 0) {
            return $enrollment;
        }

        $progress = (int) ceil((($lessonIndex + 1) / $lessons->count()) * 100);

        $enrollment->forceFill([
            'progress_percentage' => max((int) $enrollment->progress_percentage, $progress),
            'completed_at' => $progress >= 100 ? ($enrollment->completed_at ?? now()) : $enrollment->completed_at,
        ])->save();

        return $enrollment;
    }

    public function canOpenLesson(User $user, Lesson $lesson): bool
    {
        if ($lesson->status !== LessonStatus::Published) {
            return false;
        }

        return $this->activeEnrollmentFor($user, $lesson) !== null;
    }
}
