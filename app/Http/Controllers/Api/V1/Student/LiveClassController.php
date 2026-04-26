<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LiveClassResource;
use App\Models\LiveClass;
use App\Services\Video\JitsiMeetService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class LiveClassController extends Controller
{
    /**
     * Display live classes for the authenticated student's active courses.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $courseIds = $this->activeCourseIds($request);

        $liveClasses = LiveClass::query()
            ->visibleToStudents()
            ->with(['course:id,title,slug'])
            ->whereIn('course_id', $courseIds)
            ->where('scheduled_at', '>=', now()->subDays(7))
            ->oldest('scheduled_at')
            ->paginate($request->integer('per_page', 15));

        return LiveClassResource::collection($liveClasses);
    }

    /**
     * Display a live class the student is allowed to access.
     */
    public function show(Request $request, LiveClass $liveClass): LiveClassResource
    {
        $this->authorizeStudentAccess($request, $liveClass);

        return LiveClassResource::make($liveClass->load(['course:id,title,slug']));
    }

    /**
     * Return the Jitsi iframe payload for a joinable live class.
     */
    public function join(Request $request, LiveClass $liveClass, JitsiMeetService $jitsi): JsonResponse
    {
        $this->authorizeStudentAccess($request, $liveClass);

        abort_if(! $liveClass->isJoinable(), Response::HTTP_FORBIDDEN, 'Live class is not open for joining yet.');

        return response()->json([
            'message' => 'Live class meeting payload generated successfully.',
            'data' => [
                ...LiveClassResource::make($liveClass->load(['course:id,title,slug']))->resolve(),
                'meeting' => $jitsi->meetingPayload($liveClass, $request->user()),
            ],
        ]);
    }

    /**
     * Resolve active course IDs for the authenticated student.
     *
     * @return array<int, int>
     */
    private function activeCourseIds(Request $request): array
    {
        return $request->user()
            ->enrollments()
            ->active()
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->pluck('course_id')
            ->all();
    }

    /**
     * Ensure the student has active access to the live class course.
     */
    private function authorizeStudentAccess(Request $request, LiveClass $liveClass): void
    {
        $hasAccess = $request->user()
            ->enrollments()
            ->where('course_id', $liveClass->course_id)
            ->where('status', EnrollmentStatus::Active->value)
            ->where(function (Builder $query): void {
                $query->whereNull('access_expires_at')
                    ->orWhere('access_expires_at', '>=', now());
            })
            ->exists();

        abort_if(! $hasAccess, Response::HTTP_NOT_FOUND);
    }
}
