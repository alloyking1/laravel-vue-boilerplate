<?php

namespace Modules\Invoice\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Invoice\Models\InvoiceSender;
use Modules\Invoice\Services\InvoiceSenderService;

class InvoiceSenderController extends Controller
{
    public function index(Request $request): Response
    {
        $senders = InvoiceSender::where('user_id', $request->user()->id)
            ->withCount('invoices')
            ->orderBy('name')
            ->get()
            ->map(function (InvoiceSender $sender) {
                return [
                    'id' => $sender->id,
                    'name' => $sender->name,
                    'email' => $sender->email,
                    'phone' => $sender->phone,
                    'address' => $sender->address,
                    'notes' => $sender->notes,
                    'isDefault' => (bool) $sender->is_default,
                    'invoiceCount' => $sender->invoices_count,
                ];
            });

        return Inertia::render('invoice/Senders', [
            'senders' => $senders,
        ]);
    }

    public function store(Request $request, InvoiceSenderService $senderService): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $payload['user_id'] = $request->user()->id;

        $senderService->create($payload);

        return redirect()->back();
    }

    public function update(Request $request, InvoiceSender $sender, InvoiceSenderService $senderService): RedirectResponse
    {
        abort_unless($sender->user_id === $request->user()->id, 403);

        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $senderService->update($sender, $payload);

        return redirect()->back();
    }

    public function destroy(Request $request, InvoiceSender $sender): RedirectResponse
    {
        abort_unless($sender->user_id === $request->user()->id, 403);

        if ($sender->invoices()->exists()) {
            return redirect()->back()->withErrors([
                'sender' => 'Cannot delete a sender with invoices.',
            ]);
        }

        $sender->delete();

        return redirect()->back();
    }
}
