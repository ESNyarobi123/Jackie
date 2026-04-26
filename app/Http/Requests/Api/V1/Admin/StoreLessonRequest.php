<?php

namespace App\Http\Requests\Api\V1\Admin;

use App\Enums\LessonContentType;
use App\Enums\LessonStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;

class StoreLessonRequest extends FormRequest
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
        $courseId = $this->route('course')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lessons', 'slug')->where(fn ($query) => $query->where('course_id', $courseId)),
            ],
            'summary' => ['nullable', 'string', 'max:255'],
            'content_type' => ['required', Rule::enum(LessonContentType::class)],
            'status' => ['required', Rule::enum(LessonStatus::class)],
            'media_source' => ['nullable', Rule::in(['upload', 'url', 'asset'])],
            'video_file' => [
                'exclude_unless:media_source,upload',
                'required_if:media_source,upload',
                File::types(['mp4', 'mov', 'webm', 'm4v'])->max(512 * 1024),
            ],
            'video_provider' => ['required_if:media_source,asset', 'nullable', 'string', 'max:100'],
            'video_asset' => ['required_if:media_source,asset', 'nullable', 'string', 'max:255'],
            'resource_url' => ['required_if:media_source,url', 'nullable', 'url', 'max:2048'],
            'duration_seconds' => ['required', 'integer', 'min:0'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'is_preview' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
