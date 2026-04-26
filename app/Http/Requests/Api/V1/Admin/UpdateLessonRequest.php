<?php

namespace App\Http\Requests\Api\V1\Admin;

use App\Enums\LessonContentType;
use App\Enums\LessonStatus;
use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateLessonRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->filled('slug') && $this->filled('title')) {
            $this->merge([
                'slug' => Str::slug((string) $this->string('title')),
            ]);
        }

        if (! $this->filled('media_source')) {
            $mediaSource = match (true) {
                $this->hasFile('video_file') => 'upload',
                $this->filled('resource_url') => 'url',
                $this->filled('video_asset') => 'asset',
                default => null,
            };

            if ($mediaSource !== null) {
                $this->merge(['media_source' => $mediaSource]);
            }
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        /** @var Lesson $lesson */
        $lesson = $this->route('lesson');

        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('lessons', 'slug')
                    ->where(fn ($query) => $query->where('course_id', $lesson->course_id))
                    ->ignore($lesson->id),
            ],
            'summary' => ['sometimes', 'nullable', 'string', 'max:255'],
            'content_type' => ['sometimes', 'required', Rule::enum(LessonContentType::class)],
            'status' => ['sometimes', 'required', Rule::enum(LessonStatus::class)],
            'media_source' => ['sometimes', 'nullable', Rule::in(['upload', 'url', 'asset'])],
            'video_file' => [
                'exclude_unless:media_source,upload',
                'required_if:media_source,upload',
                File::types(['mp4', 'mov', 'webm', 'm4v'])->max(512 * 1024),
            ],
            'video_provider' => ['sometimes', 'required_if:media_source,asset', 'nullable', 'string', 'max:100'],
            'video_asset' => ['sometimes', 'required_if:media_source,asset', 'nullable', 'string', 'max:255'],
            'resource_url' => ['sometimes', 'required_if:media_source,url', 'nullable', 'url', 'max:2048'],
            'duration_seconds' => ['sometimes', 'required', 'integer', 'min:0'],
            'sort_order' => ['sometimes', 'required', 'integer', 'min:1'],
            'is_preview' => ['sometimes', 'boolean'],
            'published_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
