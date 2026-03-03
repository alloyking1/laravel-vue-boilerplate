<?php

use Illuminate\Support\Facades\Route;
use Modules\EcommerceAnalytics\Http\Controllers\EcommerceAnalyticsController;
use Modules\EcommerceAnalytics\Http\Controllers\ShopifyController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('ecommerceanalytics', EcommerceAnalyticsController::class)->names('ecommerceanalytics');
    
    // Shopify Connection Routes
    Route::prefix('ecommerce-analytics/shopify')->name('ecommerceanalytics.shopify.')->group(function () {
        Route::get('/connect', [ShopifyController::class, 'connect'])->name('connect');
        Route::get('/redirect', [ShopifyController::class, 'redirect'])->name('redirect');
        Route::get('/callback', [ShopifyController::class, 'callback'])->name('callback');
    });
});
