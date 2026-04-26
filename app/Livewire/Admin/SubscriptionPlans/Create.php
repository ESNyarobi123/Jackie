<?php

namespace App\Livewire\Admin\SubscriptionPlans;

use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public string $price_amount = '0';
    public string $currency = 'TZS';
    public int $duration_days = 30;
    public bool $is_free_trial = false;
    public int $trial_days = 0;
    public bool $is_featured = false;
    public bool $is_active = true;
    public int $sort_order = 0;
    public string $features_input = '';

    public function updatedName(): void
    {
        if ($this->slug === '') {
            $this->slug = Str::slug($this->name);
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique(SubscriptionPlan::class, 'slug')],
            'description' => ['nullable', 'string'],
            'price_amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:3650'],
            'is_free_trial' => ['boolean'],
            'trial_days' => ['required', 'integer', 'min:0', 'max:365'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'features_input' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $features = array_filter(array_map('trim', explode("\n", $validated['features_input'] ?? '')));

        SubscriptionPlan::query()->create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'price_amount' => $validated['price_amount'],
            'currency' => $validated['currency'],
            'duration_days' => $validated['duration_days'],
            'is_free_trial' => $validated['is_free_trial'],
            'trial_days' => $validated['trial_days'],
            'is_featured' => $validated['is_featured'],
            'is_active' => $validated['is_active'],
            'sort_order' => $validated['sort_order'],
            'features' => $features,
        ]);

        $this->redirectRoute('admin.subscription-plans.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.subscription-plans.create');
    }
}
