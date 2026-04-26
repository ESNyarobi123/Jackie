<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Services\Learning\LessonAccessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LessonMediaController extends Controller
{
    public function __invoke(Request $request, Lesson $lesson, LessonAccessService $access): BinaryFileResponse|RedirectResponse
    {
        abort_unless($access->canOpenLesson($request->user(), $lesson), Response::HTTP_NOT_FOUND);

        if ($lesson->video_provider === 'local' && is_string($lesson->video_asset)) {
            abort_unless(Storage::disk('local')->exists($lesson->video_asset), Response::HTTP_NOT_FOUND);

            $response = response()->file(Storage::disk('local')->path($lesson->video_asset), [
                'Content-Type' => Storage::disk('local')->mimeType($lesson->video_asset) ?: 'application/octet-stream',
            ]);

            $response->setPrivate();
            $response->setMaxAge(300);

            return $response;
        }

        if (is_string($lesson->resource_url) && $lesson->resource_url !== '') {
            return redirect()->away($lesson->resource_url);
        }

        abort(Response::HTTP_NOT_FOUND);
    }
}
