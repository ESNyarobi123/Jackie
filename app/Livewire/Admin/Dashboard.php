<?php

namespace App\Livewire\Admin;

use App\Enums\EnrollmentStatus;
use App\Enums\LiveClassStatus;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LiveClass;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $stats = [];

    public $recentUsers = [];

    public $recentEnrollments = [];

    public $recentSubscriptions = [];

    public $upcomingLiveClasses = [];

    public $enrollmentTrend = [];

    public $revenueTrend = [];

    public $subscriptionDistribution = [];

    public $enrollmentStatusDistribution = [];

    public function mount()
    {
        $this->calculateStats();
        $this->loadRecentUsers();
        $this->loadRecentEnrollments();
        $this->loadRecentSubscriptions();
        $this->loadUpcomingLiveClasses();
        $this->loadEnrollmentTrend();
        $this->loadRevenueTrend();
        $this->loadSubscriptionDistribution();
        $this->loadEnrollmentStatusDistribution();
    }

    public function calculateStats()
    {
        $this->stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', UserRole::Student)->count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'active_enrollments' => Enrollment::where('status', EnrollmentStatus::Active)->count(),
            'total_subscriptions' => Subscription::count(),
            'active_subscriptions' => Subscription::where('status', SubscriptionStatus::Active)->count(),
            'trial_subscriptions' => Subscription::where('status', SubscriptionStatus::Active)->whereNull('payment_id')->where('access_ends_at', '>', now())->count(),
            'courses_with_trial' => Course::where('has_free_trial', true)->count(),
            'total_revenue' => Payment::where('status', PaymentStatus::Paid)->sum('amount') ?? 0,
            'upcoming_live_classes' => LiveClass::where('scheduled_at', '>', now())->where('status', LiveClassStatus::Scheduled)->count(),
        ];
    }

    public function loadRecentUsers()
    {
        $this->recentUsers = User::latest()
            ->limit(5)
            ->get();
    }

    public function loadRecentEnrollments()
    {
        $this->recentEnrollments = Enrollment::with(['user', 'course'])
            ->latest('enrolled_at')
            ->limit(5)
            ->get();
    }

    public function loadRecentSubscriptions()
    {
        $this->recentSubscriptions = Subscription::with('user')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function loadUpcomingLiveClasses()
    {
        $this->upcomingLiveClasses = LiveClass::with('course')
            ->where('scheduled_at', '>', now())
            ->where('status', LiveClassStatus::Scheduled)
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get();
    }

    public function loadEnrollmentTrend()
    {
        $this->enrollmentTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i * 7)->startOfWeek();
            $count = Enrollment::whereBetween('enrolled_at', [$date, $date->copy()->addWeek()])->count();
            $this->enrollmentTrend[] = [
                'label' => $date->format('M d'),
                'value' => $count,
            ];
        }
    }

    public function loadRevenueTrend()
    {
        $this->revenueTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->startOfMonth();
            $revenue = Payment::where('status', PaymentStatus::Paid)
                ->whereBetween('paid_at', [$month, $month->copy()->addMonth()])
                ->sum('amount') ?? 0;
            $this->revenueTrend[] = [
                'label' => $month->format('M'),
                'value' => (int) $revenue,
            ];
        }
    }

    public function loadSubscriptionDistribution()
    {
        $this->subscriptionDistribution = [
            ['label' => 'Active', 'value' => Subscription::where('status', SubscriptionStatus::Active)->count(), 'color' => '#22c55e'],
            ['label' => 'Expired', 'value' => Subscription::where('status', SubscriptionStatus::Expired)->count(), 'color' => '#ef4444'],
            ['label' => 'Trial', 'value' => Subscription::where('status', SubscriptionStatus::Active)->whereNull('payment_id')->where('access_ends_at', '>', now())->count(), 'color' => '#f59e0b'],
        ];
    }

    public function loadEnrollmentStatusDistribution()
    {
        $this->enrollmentStatusDistribution = [
            ['label' => 'Active', 'value' => Enrollment::where('status', EnrollmentStatus::Active)->count(), 'color' => '#22c55e'],
            ['label' => 'Completed', 'value' => Enrollment::where('status', EnrollmentStatus::Completed)->count(), 'color' => '#3b82f6'],
            ['label' => 'Expired', 'value' => Enrollment::where('status', EnrollmentStatus::Expired)->count(), 'color' => '#ef4444'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
