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

    public function mount()
    {
        $this->calculateStats();
        $this->loadRecentUsers();
        $this->loadRecentEnrollments();
        $this->loadRecentSubscriptions();
        $this->loadUpcomingLiveClasses();
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

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
