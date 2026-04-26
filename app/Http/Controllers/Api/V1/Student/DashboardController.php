<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EnrollmentResource;
use App\Http\Resources\V1\PaymentResource;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        $activeEnrollments = $user->enrollments()
            ->with(['course'])
            ->active()
            ->latest('enrolled_at')
            ->limit(5)
            ->get();

        $recentPayments = $user->payments()
            ->with(['course'])
            ->latest('paid_at')
            ->limit(5)
            ->get();

        return response()->json([
            'data' => [
                'student' => UserResource::make($user->loadCount(['enrollments', 'subscriptions', 'payments']))->resolve(),
                'summary' => [
                    'active_enrollments' => $user->enrollments()->active()->count(),
                    'completed_enrollments' => $user->enrollments()->where('progress_percentage', 100)->count(),
                    'active_subscriptions' => $user->subscriptions()->active()->count(),
                    'expiring_subscriptions' => $user->subscriptions()
                        ->active()
                        ->whereBetween('access_ends_at', [now(), now()->addDays(7)])
                        ->count(),
                ],
                'active_enrollments' => EnrollmentResource::collection($activeEnrollments)->resolve(),
                'recent_payments' => PaymentResource::collection($recentPayments)->resolve(),
            ],
        ]);
    }
}
