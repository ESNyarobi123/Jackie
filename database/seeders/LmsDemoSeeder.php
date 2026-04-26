<?php

namespace Database\Seeders;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentProvider;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class LmsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Jackie Admin',
            'email' => 'admin@jackieenglish.test',
        ]);

        $student = User::factory()->student()->create([
            'name' => 'Amina Hassan',
            'email' => 'student@jackieenglish.test',
        ]);

        User::factory()->count(3)->student()->create();

        $spokenEnglish = Course::factory()
            ->published()
            ->for($admin, 'creator')
            ->create([
                'title' => 'Spoken English Mastery',
                'slug' => 'spoken-english-mastery',
                'price_amount' => 25000,
                'duration_days' => 30,
            ]);

        Lesson::factory()
            ->count(6)
            ->for($spokenEnglish)
            ->published()
            ->sequence(fn (Sequence $sequence) => [
                'sort_order' => $sequence->index + 1,
                'title' => 'Spoken English Lesson '.($sequence->index + 1),
                'slug' => 'spoken-english-lesson-'.($sequence->index + 1),
            ])
            ->create();

        $businessEnglish = Course::factory()
            ->published()
            ->for($admin, 'creator')
            ->create([
                'title' => 'Business English Bootcamp',
                'slug' => 'business-english-bootcamp',
                'price_amount' => 35000,
                'duration_days' => 45,
            ]);

        Lesson::factory()
            ->count(4)
            ->for($businessEnglish)
            ->published()
            ->sequence(fn (Sequence $sequence) => [
                'sort_order' => $sequence->index + 1,
                'title' => 'Business English Lesson '.($sequence->index + 1),
                'slug' => 'business-english-lesson-'.($sequence->index + 1),
            ])
            ->create();

        $payment = Payment::factory()
            ->for($student)
            ->for($spokenEnglish)
            ->create([
                'provider' => PaymentProvider::Manual,
                'reference' => 'PAY-DEMO-0001',
                'provider_reference' => 'MANUAL-DEMO-0001',
                'amount' => 25000,
            ]);

        $subscription = Subscription::factory()
            ->active()
            ->for($student)
            ->for($spokenEnglish)
            ->for($payment)
            ->create([
                'access_starts_at' => now()->subWeek(),
                'access_ends_at' => now()->addDays(23),
            ]);

        $payment->update([
            'subscription_id' => $subscription->id,
        ]);

        Enrollment::factory()
            ->active()
            ->for($student)
            ->for($spokenEnglish)
            ->create([
                'subscription_id' => $subscription->id,
                'status' => EnrollmentStatus::Active,
                'progress_percentage' => 38,
            ]);
    }
}
