<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\PostTagController;

// Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');

    Route::prefix('tag')->group(function () {
        Route::get('/create', [PostTagController::class, 'create'])->name('tag.create');
    });
// });
