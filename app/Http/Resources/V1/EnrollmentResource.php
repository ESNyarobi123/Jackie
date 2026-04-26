<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'subscription_id' => $this->subscription_id,
            'status' => $this->status?->value,
            'enrolled_at' => $this->enrolled_at,
            'access_expires_at' => $this->access_expires_at,
            'progress_percentage' => $this->progress_percentage,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course' => CourseResource::make($this->whenLoaded('course')),
            'subscription' => SubscriptionResource::make($this->whenLoaded('subscription')),
        ];
    }
}
