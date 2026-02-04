<?php

namespace Modules\Invoice\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Invoice\Http\Requests\StoreInvoiceRequest;
use Modules\Invoice\Services\InvoiceClientService;
use Modules\Invoice\Services\InvoiceService;

class InvoiceController extends Controller
{
    public function store(
        StoreInvoiceRequest $request,
        InvoiceService $invoiceService,
        InvoiceClientService $clientService
    ): RedirectResponse {
        $payload = $request->validated();

        $clientId = $payload['invoice_client_id'] ?? null;
        if (! $clientId) {
            $client = $clientService->create([
                'name' => $payload['client_name'],
                'email' => $payload['client_email'] ?? null,
                'phone' => $payload['client_phone'] ?? null,
                'address' => $payload['client_address'] ?? null,
                'notes' => $payload['client_notes'] ?? null,
            ]);

            $clientId = $client->id;
        }

        $invoiceService->createWithItems([
            'user_id' => $request->user()->id,
            'invoice_client_id' => $clientId,
            'invoice_number' => $payload['invoice_number'] ?? null,
            'status' => $payload['status'] ?? 'draft',
            'issue_date' => $payload['issue_date'] ?? null,
            'due_date' => $payload['due_date'] ?? null,
            'subtotal' => $payload['subtotal'] ?? 0,
            'tax' => $payload['tax'] ?? 0,
            'total' => $payload['total'] ?? 0,
            'currency' => $payload['currency'] ?? null,
            'notes' => $payload['notes'] ?? null,
            'items' => $payload['items'],
        ]);

        return redirect()->back()->with('success', 'Invoice created successfully.');
    }
}
