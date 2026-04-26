<?php

namespace App\Livewire\Admin\Courses;

use App\Enums\CourseStatus;
use App\Models\Course;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Create extends Component
{
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
            'slug' => ['required', 'string', 'max:255', Rule::unique(Course::class, 'slug')],
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
            $validated['published_at'] = now();
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $course = Course::query()->create([
            ...$validated,
            'created_by' => $user->id,
        ]);

        $this->redirectRoute('admin.courses.show', $course, navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.courses.create');
    }
}
