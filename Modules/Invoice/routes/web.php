<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Controllers\InvoiceDashboardController;
use Modules\Invoice\Http\Controllers\InvoiceClientController;
use Modules\Invoice\Http\Controllers\InvoiceSenderController;
use Modules\Invoice\Http\Controllers\InvoiceController;

Route::middleware(['auth', 'verified'])
	->prefix('invoices')
	->name('invoice.')
	->group(function () {
		Route::get('/', [InvoiceDashboardController::class, 'index'])->name('dashboard');
		Route::get('/clients', [InvoiceClientController::class, 'index'])->name('clients');
		Route::post('/clients', [InvoiceClientController::class, 'store'])->name('clients.store');
		Route::put('/clients/{client}', [InvoiceClientController::class, 'update'])->name('clients.update');
		Route::delete('/clients/{client}', [InvoiceClientController::class, 'destroy'])->name('clients.destroy');
		Route::get('/senders', [InvoiceSenderController::class, 'index'])->name('senders');
		Route::post('/senders', [InvoiceSenderController::class, 'store'])->name('senders.store');
		Route::put('/senders/{sender}', [InvoiceSenderController::class, 'update'])->name('senders.update');
		Route::delete('/senders/{sender}', [InvoiceSenderController::class, 'destroy'])->name('senders.destroy');
		Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
		Route::get('/{invoice}/api', [InvoiceController::class, 'getJson'])->name('api');
		Route::patch('/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('status');
		Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
		Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
		Route::post('/', [InvoiceController::class, 'store'])->name('store');
	});
