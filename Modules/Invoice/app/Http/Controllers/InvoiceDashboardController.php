<?php

namespace Modules\Invoice\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Modules\Invoice\Models\Invoice;
use Modules\Invoice\Models\InvoiceClient;

class InvoiceDashboardController extends Controller
{
    public function index()
    {
        $outstandingStatuses = ['sent', 'overdue'];

        $stats = [
            'totalRevenue' => (float) Invoice::sum('total'),
            'outstandingAmount' => (float) Invoice::whereIn('status', $outstandingStatuses)->sum('total'),
            'outstandingCount' => Invoice::whereIn('status', $outstandingStatuses)->count(),
            'invoiceCount' => Invoice::count(),
        ];

        $invoices = Invoice::with('client')
            ->latest()
            ->take(15)
            ->get()
            ->map(function (Invoice $invoice) {
                return [
                    'id' => $invoice->id,
                    'invoiceNumber' => $invoice->invoice_number,
                    'status' => $invoice->status,
                    'issueDate' => optional($invoice->issue_date)->format('Y-m-d'),
                    'dueDate' => optional($invoice->due_date)->format('Y-m-d'),
                    'total' => (float) $invoice->total,
                    'client' => $invoice->client ? [
                        'id' => $invoice->client->id,
                        'name' => $invoice->client->name,
                        'email' => $invoice->client->email,
                    ] : null,
                ];
            });

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

        return Inertia::render('invoice/Dashboard', [
            'stats' => $stats,
            'invoices' => $invoices,
            'clients' => $clients,
        ]);
    }
}
