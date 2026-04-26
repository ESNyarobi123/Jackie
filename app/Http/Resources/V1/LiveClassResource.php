<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $canSeeJoinDetails = $request->user()?->isAdmin() === true
            || $request->routeIs('api.v1.student.live-classes.join');

        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'created_by' => $this->created_by,
            'provider' => $this->provider?->value,
            'status' => $this->status?->value,
            'title' => $this->title,
            'description' => $this->description,
            'room_name' => $this->when($canSeeJoinDetails, $this->room_name),
            'join_url' => $this->when($canSeeJoinDetails, $this->join_url),
            'scheduled_at' => $this->scheduled_at,
            'duration_minutes' => $this->duration_minutes,
            'ends_at' => $this->scheduled_at?->copy()->addMinutes($this->duration_minutes),
            'can_join' => $this->when($this->resource->exists, fn (): bool => $this->resource->isJoinable()),
            'settings' => $this->settings,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course' => CourseResource::make($this->whenLoaded('course')),
            'creator' => UserResource::make($this->whenLoaded('creator')),
        ];
    }
}
