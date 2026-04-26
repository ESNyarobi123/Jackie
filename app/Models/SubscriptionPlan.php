<?php

namespace App\Models;

use Database\Factories\SubscriptionPlanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

#[Fillable([
    'name',
    'slug',
    'description',
    'price_amount',
    'currency',
    'duration_days',
    'is_free_trial',
    'trial_days',
    'is_featured',
    'is_active',
    'sort_order',
    'features',
])]
class SubscriptionPlan extends Model
{
    /** @use HasFactory<SubscriptionPlanFactory> */
    use HasFactory;

    protected $attributes = [
        'price_amount' => '0',
        'currency' => 'TZS',
        'duration_days' => 30,
        'is_free_trial' => false,
        'trial_days' => 0,
        'is_featured' => false,
        'is_active' => true,
        'sort_order' => 0,
        'features' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'price_amount' => 'decimal:2',
            'is_free_trial' => 'bool',
            'is_featured' => 'bool',
            'is_active' => 'bool',
            'features' => 'array',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('price_amount');
    }
}
