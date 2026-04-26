<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $canSeeProtectedAssets = $request->user()?->isAdmin() === true;

        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content_type' => $this->content_type?->value,
            'status' => $this->status?->value,
            'video_provider' => $this->video_provider,
            'video_asset' => $this->when($canSeeProtectedAssets, $this->video_asset),
            'resource_url' => $this->when($canSeeProtectedAssets, $this->resource_url),
            'duration_seconds' => $this->duration_seconds,
            'sort_order' => $this->sort_order,
            'is_preview' => $this->is_preview,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
