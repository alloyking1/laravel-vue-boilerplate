<?php

use Illuminate\Support\Facades\Route;
use Modules\EcommerceAnalytics\Http\Controllers\EcommerceAnalyticsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('ecommerceanalytics', EcommerceAnalyticsController::class)->names('ecommerceanalytics');
});
