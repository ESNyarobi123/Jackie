<?php

namespace App\Http\Requests\Api\V1\Admin;

use App\Enums\LiveClassStatus;
use App\Models\LiveClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLiveClassRequest extends FormRequest
{
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
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'required', Rule::enum(LiveClassStatus::class)],
            'scheduled_at' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:360'],
            'room_name' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z0-9_-]+$/', Rule::unique(LiveClass::class, 'room_name')],
            'settings' => ['nullable', 'array'],
            'settings.configOverwrite' => ['nullable', 'array'],
            'settings.interfaceConfigOverwrite' => ['nullable', 'array'],
        ];
    }
}
