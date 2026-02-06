<?php

namespace Modules\Invoice\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Invoice\Http\Requests\StoreInvoiceRequest;
use Modules\Invoice\Http\Requests\UpdateInvoiceRequest;
use Inertia\Response;
use Modules\Invoice\Models\Invoice;
use Modules\Invoice\Services\InvoiceClientService;
use Modules\Invoice\Services\InvoiceService;

class InvoiceController extends Controller
{
    public function show(Request $request, Invoice $invoice): Response
    {
        abort_unless($request->user()?->id === $invoice->user_id, 403);

        return Inertia::render('invoice/Show', [
            'invoice' => $invoice->load(['client', 'items', 'user']),
        ]);
    }

    public function getJson(Request $request, Invoice $invoice): JsonResponse
    {
        abort_unless($request->user()?->id === $invoice->user_id, 403);

        return response()->json([
            'invoice' => $invoice->load(['client', 'items'])->toArray(),
        ]);
    }

    public function updateStatus(Request $request, Invoice $invoice): RedirectResponse
    {
        abort_unless($request->user()?->id === $invoice->user_id, 403);

        $validated = $request->validate([
            'status' => ['required', 'in:draft,sent,paid,overdue'],
        ]);

        $invoice->update([
            'status' => $validated['status'],
        ]);

        return back();
    }

    public function destroy(Request $request, Invoice $invoice): RedirectResponse
    {
        abort_unless($request->user()?->id === $invoice->user_id, 403);

        $invoice->items()->delete();
        $invoice->delete();

        return back();
    }

    public function update(
        UpdateInvoiceRequest $request,
        Invoice $invoice,
        InvoiceService $invoiceService,
        InvoiceClientService $clientService
    ): RedirectResponse {
        abort_unless($request->user()?->id === $invoice->user_id, 403);

        $payload = $request->validated();

        $clientId = $payload['invoice_client_id'] ?? null;
        if (! $clientId || $clientId === 'new') {
            $client = $clientService->create([
                'name' => $payload['client_name'],
                'email' => $payload['client_email'] ?? null,
                'phone' => $payload['client_phone'] ?? null,
                'address' => $payload['client_address'] ?? null,
                'notes' => $payload['client_notes'] ?? null,
            ]);

            $clientId = $client->id;
        }

        $invoiceService->updateWithItems($invoice, [
            'invoice_client_id' => $clientId,
            'invoice_number' => $payload['invoice_number'] ?? $invoice->invoice_number,
            'status' => $payload['status'] ?? $invoice->status,
            'issue_date' => $payload['issue_date'] ?? null,
            'due_date' => $payload['due_date'] ?? null,
            'subtotal' => $payload['subtotal'] ?? 0,
            'tax' => $payload['tax'] ?? 0,
            'total' => $payload['total'] ?? 0,
            'currency' => $payload['currency'] ?? null,
            'notes' => $payload['notes'] ?? null,
            'items' => $payload['items'],
        ]);

        return redirect()->back();
    }

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
