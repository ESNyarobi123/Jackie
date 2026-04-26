<?php

namespace App\Livewire\Admin\Courses;

use App\Enums\CourseStatus;
use App\Models\Course;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Course $course;

    public string $title = '';
    public string $slug = '';
    public ?string $excerpt = null;
    public ?string $description = null;
    public string $status = 'draft';
    public string $price_amount = '0';
    public string $currency = 'TZS';
    public int $duration_days = 30;
    public bool $is_featured = false;
    public bool $has_free_trial = false;
    public int $free_trial_days = 0;
    public ?string $published_at = null;

    public function mount(Course $course): void
    {
        $this->course = $course;

        $this->title = (string) $course->title;
        $this->slug = (string) $course->slug;
        $this->excerpt = $course->excerpt;
        $this->description = $course->description;
        $this->status = $course->status?->value ?? (string) $course->status;
        $this->price_amount = (string) $course->price_amount;
        $this->currency = (string) $course->currency;
        $this->duration_days = (int) $course->duration_days;
        $this->is_featured = (bool) $course->is_featured;
        $this->has_free_trial = (bool) $course->has_free_trial;
        $this->free_trial_days = (int) $course->free_trial_days;
        $this->published_at = $course->published_at?->format('Y-m-d\TH:i');
    }

    public function updatedTitle(): void
    {
        if ($this->slug === '') {
            $this->slug = Str::slug($this->title);
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique(Course::class, 'slug')->ignore($this->course->id)],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(CourseStatus::class)],
            'price_amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:3650'],
            'is_featured' => ['boolean'],
            'has_free_trial' => ['boolean'],
            'free_trial_days' => ['required', 'integer', 'min:0', 'max:365'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($validated['status'] === CourseStatus::Published->value && $validated['published_at'] === null) {
            $validated['published_at'] = $this->course->published_at ?? now();
        }

        $this->course->update($validated);

        $this->redirectRoute('admin.courses.show', $this->course->fresh(), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.courses.edit');
    }
}
