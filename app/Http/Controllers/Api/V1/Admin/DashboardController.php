<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\CourseStatus;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'total_students' => User::query()->where('role', UserRole::Student->value)->count(),
                'published_courses' => Course::query()->where('status', CourseStatus::Published->value)->count(),
                'active_subscriptions' => Subscription::query()->where('status', SubscriptionStatus::Active->value)->count(),
                'pending_payments' => Payment::query()->where('status', PaymentStatus::Pending->value)->count(),
                'paid_revenue_total' => (float) Payment::query()
                    ->where('status', PaymentStatus::Paid->value)
                    ->sum('amount'),
            ],
        ]);
    }
}
