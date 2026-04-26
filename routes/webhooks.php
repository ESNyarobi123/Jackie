<?php

use App\Enums\PaymentProvider;
use App\Http\Controllers\Api\V1\Webhooks\PaymentWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('v1/webhooks/payments/{provider}', PaymentWebhookController::class)
    ->whereIn('provider', collect(PaymentProvider::cases())->map->value->all())
    ->name('api.v1.webhooks.payments');
