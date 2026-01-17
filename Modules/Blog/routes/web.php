<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\PostTagController;
use Modules\Blog\Http\Controllers\PostCategoryController;

// Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');

    Route::prefix('blog/tag')->group(function () {
        Route::get('/create', [PostTagController::class, 'create'])->name('tag.create');
        Route::post('/store', [PostTagController::class, 'store'])->name('tag.store');
        Route::post('/delete/{id}', [PostTagController::class, 'delete'])->name('tag.delete');
    });

    Route::prefix('blog/category')->group(function () {
        Route::get('/create', [PostCategoryController::class, 'create'])->name('tag.create');
        Route::post('/store', [PostCategoryController::class, 'store'])->name('tag.store');
        Route::post('/delete/{id}', [PostCategoryController::class, 'delete'])->name('tag.delete');
    });
// });
