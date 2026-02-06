<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Controllers\InvoiceDashboardController;
use Modules\Invoice\Http\Controllers\InvoiceController;

Route::middleware(['auth', 'verified'])
	->prefix('invoices')
	->name('invoice.')
	->group(function () {
		Route::get('/', [InvoiceDashboardController::class, 'index'])->name('dashboard');
		Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
		Route::get('/{invoice}/api', [InvoiceController::class, 'getJson'])->name('api');
		Route::patch('/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('status');
		Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
		Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
		Route::post('/', [InvoiceController::class, 'store'])->name('store');
	});
