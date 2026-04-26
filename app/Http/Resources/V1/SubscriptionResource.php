<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'payment_id' => $this->payment_id,
            'status' => $this->status?->value,
            'access_starts_at' => $this->access_starts_at,
            'access_ends_at' => $this->access_ends_at,
            'renewal_reminder_sent_at' => $this->renewal_reminder_sent_at,
            'expired_at' => $this->expired_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course' => CourseResource::make($this->whenLoaded('course')),
        ];
    }
}
