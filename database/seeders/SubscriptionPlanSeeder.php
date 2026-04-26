<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'description' => 'Try our platform free for 7 days. Access all courses with limited features.',
                'price_amount' => 0,
                'currency' => 'TZS',
                'duration_days' => 7,
                'is_free_trial' => true,
                'trial_days' => 7,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 1,
                'features' => ['Access to all courses', '7-day free trial', 'Limited lesson access', 'No certificate'],
            ],
            [
                'name' => 'Monthly',
                'slug' => 'monthly',
                'description' => 'Full access to all courses with monthly billing. Cancel anytime.',
                'price_amount' => 25000,
                'currency' => 'TZS',
                'duration_days' => 30,
                'is_free_trial' => false,
                'trial_days' => 0,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
                'features' => ['Access to all courses', 'Full lesson access', 'Live class access', 'Quizzes & assignments', 'Certificate on completion', 'Cancel anytime'],
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Best value! Full access with priority support and exclusive content.',
                'price_amount' => 55000,
                'currency' => 'TZS',
                'duration_days' => 90,
                'is_free_trial' => false,
                'trial_days' => 0,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
                'features' => ['Access to all courses', 'Full lesson access', 'Live class access', 'Quizzes & assignments', 'Certificate on completion', 'Priority support', 'Exclusive content', '3 months access'],
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::query()->create($plan);
        }
    }
}
