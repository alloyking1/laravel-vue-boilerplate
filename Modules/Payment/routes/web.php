<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Payment\Http\Controllers\PaymentWebhookController;

Route::post('payment/webhook', PaymentWebhookController::class)->name('payment.webhook');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('payments', PaymentController::class)->names('payment');
});
