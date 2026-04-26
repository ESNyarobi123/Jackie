<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Enums\LessonStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EnrollmentResource;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $enrollments = $request->user()->enrollments()
            ->active()
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->with(['course.lessons' => fn ($query) => $query->where('status', LessonStatus::Published->value), 'subscription'])
            ->latest('enrolled_at')
            ->paginate($request->integer('per_page', 15));

        return EnrollmentResource::collection($enrollments);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Request $request): EnrollmentResource
    {
        $enrollment = Enrollment::query()
            ->whereBelongsTo($request->user())
            ->whereBelongsTo($course)
            ->active()
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->with(['course.lessons' => fn ($query) => $query->where('status', LessonStatus::Published->value), 'subscription'])
            ->first();

        if ($enrollment === null) {
            throw new NotFoundHttpException();
        }

        return EnrollmentResource::make($enrollment);
    }
}
