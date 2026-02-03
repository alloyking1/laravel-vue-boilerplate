<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Controllers\InvoiceDashboardController;
use Modules\Invoice\Http\Controllers\InvoiceController;

Route::middleware(['auth', 'verified'])
	->prefix('invoices')
	->name('invoice.')
	->group(function () {
		Route::get('/', [InvoiceDashboardController::class, 'index'])->name('dashboard');
		Route::post('/', [InvoiceController::class, 'store'])->name('store');
	});
