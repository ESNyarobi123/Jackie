<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\LessonStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreLessonRequest;
use App\Http\Resources\V1\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\Video\LessonMediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CourseLessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course, Request $request): AnonymousResourceCollection
    {
        $lessons = $course->lessons()
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status'));
            })
            ->paginate($request->integer('per_page', 20));

        return LessonResource::collection($lessons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request, Course $course, LessonMediaService $media): JsonResponse
    {
        $lesson = $course->lessons()->create(
            $media->apply($this->lessonPayload($request->validated()))
        );

        return LessonResource::make($lesson)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Normalize the lesson payload.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function lessonPayload(array $validated, ?Lesson $lesson = null): array
    {
        $status = $validated['status'] ?? $lesson?->status?->value;
        $isPublished = $status === LessonStatus::Published->value;

        $validated['published_at'] = $isPublished
            ? ($validated['published_at'] ?? $lesson?->published_at ?? now())
            : null;

        return $validated;
    }
}
