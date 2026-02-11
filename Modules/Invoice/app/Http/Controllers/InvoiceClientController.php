<?php

namespace Modules\Invoice\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Invoice\Models\InvoiceClient;
use Modules\Invoice\Services\InvoiceClientService;

class InvoiceClientController extends Controller
{
    public function index(): Response
    {
        $clients = InvoiceClient::withCount('invoices')
            ->orderBy('name')
            ->get()
            ->map(function (InvoiceClient $client) {
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                    'phone' => $client->phone,
                    'address' => $client->address,
                    'notes' => $client->notes,
                    'invoiceCount' => $client->invoices_count,
                ];
            });

        return Inertia::render('invoice/Clients', [
            'clients' => $clients,
        ]);
    }

    public function store(Request $request, InvoiceClientService $clientService): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $clientService->create($payload);

        return redirect()->back();
    }

    public function update(Request $request, InvoiceClient $client, InvoiceClientService $clientService): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $clientService->update($client, $payload);

        return redirect()->back();
    }

    public function destroy(InvoiceClient $client): RedirectResponse
    {
        if ($client->invoices()->exists()) {
            return redirect()->back()->withErrors([
                'client' => 'Cannot delete a client with invoices.',
            ]);
        }

        $client->delete();

        return redirect()->back();
    }
}
