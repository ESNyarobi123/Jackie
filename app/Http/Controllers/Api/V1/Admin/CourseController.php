<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\CourseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreCourseRequest;
use App\Http\Requests\Api\V1\Admin\UpdateCourseRequest;
use App\Http\Resources\V1\CourseResource;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $courses = $this->courseQuery()
            ->when($request->filled('status'), function (Builder $query) use ($request): void {
                $query->where('status', $request->string('status'));
            })
            ->paginate($request->integer('per_page', 15));

        return CourseResource::collection($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request): JsonResponse
    {
        $course = Course::query()->create([
            ...$this->coursePayload($request->validated()),
            'created_by' => $request->user()->id,
        ]);

        return CourseResource::make($this->hydrateCourse($course))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): CourseResource
    {
        return CourseResource::make($this->hydrateCourse($course));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course): CourseResource
    {
        $course->update($this->coursePayload($request->validated(), $course));

        return CourseResource::make($this->hydrateCourse($course->fresh()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): Response
    {
        $course->delete();

        return response()->noContent();
    }

    /**
     * Build the course listing query.
     */
    private function courseQuery(): Builder
    {
        return Course::query()
            ->with(['creator:id,name,email'])
            ->withCount(['lessons', 'enrollments', 'subscriptions'])
            ->latest();
    }

    /**
     * Normalize the course payload.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function coursePayload(array $validated, ?Course $course = null): array
    {
        $status = $validated['status'] ?? $course?->status?->value;
        $isPublished = $status === CourseStatus::Published->value;

        $validated['published_at'] = $isPublished
            ? ($validated['published_at'] ?? $course?->published_at ?? now())
            : null;

        return $validated;
    }

    /**
     * Load the course relations used by the API.
     */
    private function hydrateCourse(Course $course): Course
    {
        return $course->load(['creator:id,name,email', 'lessons'])
            ->loadCount(['lessons', 'enrollments', 'subscriptions']);
    }
}
