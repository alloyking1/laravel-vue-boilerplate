<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified', 'subscribed'])->group(function () {
    
    Route::prefix('businesses')->group(function () {
        Route::get('/index', [BusinessController::class, 'index'])->name('business.index');
        Route::post('/store/{id?}', [BusinessController::class, 'store'])->name('business.store');
        // Route::get('/destroy/{id}', [BusinessController::class, 'destroy'])->name('business.destroy');
    });

    
    Route::prefix('teams')->group(function () {
        Route::get('/create', [TeamController::class, 'create'])
            ->name('teams.create');
    });


});
