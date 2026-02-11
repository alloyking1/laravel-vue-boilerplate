<?php

namespace Modules\Invoice\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Modules\Invoice\Models\Invoice;
use Modules\Invoice\Models\InvoiceClient;
use Modules\Invoice\Models\InvoiceSender;
use Modules\Invoice\Services\InvoiceService;

class InvoiceDashboardController extends Controller
{
    public function index(InvoiceService $invoiceService)
    {
        $outstandingStatuses = ['sent', 'overdue'];
        $paidStatuses = ['paid'];

        $stats = [
            'totalRevenue' => (float) Invoice::sum('total'),
            'paidRevenue' => (float) Invoice::whereIn('status', $paidStatuses)->sum('total'),
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

        $senders = InvoiceSender::orderBy('name')
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
                ];
            });

        return Inertia::render('invoice/Dashboard', [
            'stats' => $stats,
            'invoices' => $invoices,
            'clients' => $clients,
            'senders' => $senders,
            'nextInvoiceNumber' => $invoiceService->nextInvoiceNumber(),
        ]);
    }
}
