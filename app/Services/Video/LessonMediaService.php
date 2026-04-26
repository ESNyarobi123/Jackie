<?php

namespace App\Services\Video;

use App\Models\Lesson;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LessonMediaService
{
    private const Disk = 'local';

    private const VideoDirectory = 'lesson-videos';

    /**
     * Apply lesson media fields and store uploads when provided.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    public function apply(array $validated, ?Lesson $lesson = null): array
    {
        $mediaSource = $validated['media_source'] ?? null;
        $videoFile = $validated['video_file'] ?? null;

        unset($validated['media_source'], $validated['video_file']);

        if ($videoFile instanceof UploadedFile) {
            $path = $this->storeUploadedVideo($videoFile);
            $this->deleteLocalVideo($lesson);

            return [
                ...$validated,
                'video_provider' => 'local',
                'video_asset' => $path,
                'resource_url' => null,
            ];
        }

        if ($mediaSource === 'url') {
            $this->deleteLocalVideo($lesson);

            return [
                ...$validated,
                'video_provider' => 'url',
                'video_asset' => null,
            ];
        }

        if ($mediaSource === 'asset') {
            $this->deleteLocalVideo($lesson);

            return [
                ...$validated,
                'resource_url' => null,
            ];
        }

        return $validated;
    }

    /**
     * Remove a local uploaded video when a lesson is replaced or deleted.
     */
    public function deleteLocalVideo(?Lesson $lesson): void
    {
        if ($lesson?->video_provider !== 'local' || ! is_string($lesson->video_asset)) {
            return;
        }

        Storage::disk(self::Disk)->delete($lesson->video_asset);
    }

    /**
     * Store an uploaded lesson video on the private disk.
     */
    private function storeUploadedVideo(UploadedFile $file): string
    {
        return $file->store(self::VideoDirectory, self::Disk);
    }
}
