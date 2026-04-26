<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\LessonStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\UpdateLessonRequest;
use App\Http\Resources\V1\LessonResource;
use App\Models\Lesson;
use App\Services\Video\LessonMediaService;
use Illuminate\Http\Response;

class LessonController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson): LessonResource
    {
        return LessonResource::make($lesson->load('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson, LessonMediaService $media): LessonResource
    {
        $lesson->update($media->apply($this->lessonPayload($request->validated(), $lesson), $lesson));

        return LessonResource::make($lesson->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson, LessonMediaService $media): Response
    {
        $media->deleteLocalVideo($lesson);

        $lesson->delete();

        return response()->noContent();
    }

    /**
     * Normalize the lesson payload.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function lessonPayload(array $validated, Lesson $lesson): array
    {
        $status = $validated['status'] ?? $lesson->status?->value;
        $isPublished = $status === LessonStatus::Published->value;

        $validated['published_at'] = $isPublished
            ? ($validated['published_at'] ?? $lesson->published_at ?? now())
            : null;

        return $validated;
    }
}
