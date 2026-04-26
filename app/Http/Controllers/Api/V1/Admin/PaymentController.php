<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $payments = Payment::query()
            ->with(['course:id,title,slug'])
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status'));
            })
            ->when($request->filled('provider'), function ($query) use ($request): void {
                $query->where('provider', $request->string('provider'));
            })
            ->latest('paid_at')
            ->latest()
            ->paginate($request->integer('per_page', 20));

        return PaymentResource::collection($payments);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment): PaymentResource
    {
        return PaymentResource::make(
            $payment->load(['course:id,title,slug', 'subscription.course:id,title,slug'])
        );
    }
}
