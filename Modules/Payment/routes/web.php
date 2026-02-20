<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Payment\Http\Controllers\PaymentWebhookController;

Route::post('payment/webhook', PaymentWebhookController::class)->name('payment.webhook');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('pricing', [PaymentController::class, 'create'])->name('pricing');
    Route::get('payments/checkout/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::post('payments/subscription/swap', [PaymentController::class, 'swap'])->name('payment.swap');
    Route::post('payments/subscription/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('payments/subscription/resume', [PaymentController::class, 'resume'])->name('payment.resume');
    Route::resource('payments', PaymentController::class)->names('payment');
});
