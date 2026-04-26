<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'provider' => $this->provider?->value,
            'status' => $this->status?->value,
            'reference' => $this->reference,
            'provider_reference' => $this->provider_reference,
            'amount' => (float) $this->amount,
            'currency' => $this->currency,
            'paid_at' => $this->paid_at,
            'failed_at' => $this->failed_at,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course' => CourseResource::make($this->whenLoaded('course')),
            'subscription' => SubscriptionResource::make($this->whenLoaded('subscription')),
        ];
    }
}
