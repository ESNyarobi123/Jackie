<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\LiveClassProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreLiveClassRequest;
use App\Http\Requests\Api\V1\Admin\UpdateLiveClassRequest;
use App\Http\Resources\V1\LiveClassResource;
use App\Models\Course;
use App\Models\LiveClass;
use App\Services\Video\JitsiMeetService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class LiveClassController extends Controller
{
    /**
     * Display a listing of live classes.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $liveClasses = LiveClass::query()
            ->with(['course:id,title,slug', 'creator:id,name,email'])
            ->when($request->filled('status'), function (Builder $query) use ($request): void {
                $query->where('status', $request->string('status'));
            })
            ->when($request->filled('course_id'), function (Builder $query) use ($request): void {
                $query->where('course_id', $request->integer('course_id'));
            })
            ->latest('scheduled_at')
            ->paginate($request->integer('per_page', 15));

        return LiveClassResource::collection($liveClasses);
    }

    /**
     * Store a newly created live class.
     */
    public function store(StoreLiveClassRequest $request, JitsiMeetService $jitsi): JsonResponse
    {
        $validated = $request->validated();
        $course = Course::query()->findOrFail($validated['course_id']);
        $roomName = $validated['room_name'] ?? $jitsi->makeRoomName(
            course: $course,
            title: $validated['title'],
            scheduledAt: Carbon::parse($validated['scheduled_at']),
        );

        $liveClass = LiveClass::query()->create([
            ...$validated,
            'created_by' => $request->user()->id,
            'provider' => LiveClassProvider::Jitsi,
            'room_name' => $roomName,
            'join_url' => $jitsi->joinUrl($roomName),
        ]);

        return LiveClassResource::make($this->hydrateLiveClass($liveClass))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified live class.
     */
    public function show(LiveClass $liveClass): LiveClassResource
    {
        return LiveClassResource::make($this->hydrateLiveClass($liveClass));
    }

    /**
     * Update the specified live class.
     */
    public function update(UpdateLiveClassRequest $request, LiveClass $liveClass, JitsiMeetService $jitsi): LiveClassResource
    {
        $validated = $request->validated();

        if (array_key_exists('room_name', $validated)) {
            $validated['join_url'] = $jitsi->joinUrl($validated['room_name']);
        }

        $liveClass->update($validated);

        return LiveClassResource::make($this->hydrateLiveClass($liveClass->fresh()));
    }

    /**
     * Remove the specified live class.
     */
    public function destroy(LiveClass $liveClass): Response
    {
        $liveClass->delete();

        return response()->noContent();
    }

    /**
     * Load relations needed by the API.
     */
    private function hydrateLiveClass(LiveClass $liveClass): LiveClass
    {
        return $liveClass->load(['course:id,title,slug', 'creator:id,name,email']);
    }
}
