<?php

namespace Modules\Invoice\Services;

use Illuminate\Support\Facades\DB;
use Modules\Invoice\Models\Invoice;
use Modules\Invoice\Models\InvoiceItem;

class InvoiceService
{
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function createWithItems(array $payload): Invoice
    {
        return DB::transaction(function () use ($payload) {
            $items = $payload['items'] ?? [];
            unset($payload['items']);

            $payload['invoice_number'] = $payload['invoice_number'] ?: $this->generateInvoiceNumber();

            $tax = (float) ($payload['tax'] ?? 0);
            $subtotal = 0;
            foreach ($items as $item) {
                $quantity = (float) ($item['quantity'] ?? 0);
                $rate = (float) ($item['rate'] ?? 0);
                $subtotal += $quantity * $rate;
            }

            $payload['subtotal'] = $subtotal;
            $payload['total'] = $subtotal + $tax;

            $invoice = Invoice::create($payload);

            foreach ($items as $index => $item) {
                $quantity = (float) ($item['quantity'] ?? 0);
                $rate = (float) ($item['rate'] ?? 0);
                $amount = $quantity * $rate;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $quantity,
                    'rate' => $rate,
                    'amount' => $amount,
                    'position' => $index,
                ]);
            }

            return $invoice;
        });
    }

    public function update(Invoice $invoice, array $data): Invoice
    {
        $invoice->update($data);

        return $invoice;
    }

    public function updateWithItems(Invoice $invoice, array $payload): Invoice
    {
        return DB::transaction(function () use ($invoice, $payload) {
            $items = $payload['items'] ?? [];
            unset($payload['items']);

            $tax = (float) ($payload['tax'] ?? 0);
            $subtotal = 0;
            foreach ($items as $item) {
                $quantity = (float) ($item['quantity'] ?? 0);
                $rate = (float) ($item['rate'] ?? 0);
                $subtotal += $quantity * $rate;
            }

            $payload['subtotal'] = $subtotal;
            $payload['total'] = $subtotal + $tax;

            $invoice->update($payload);
            $invoice->items()->delete();

            foreach ($items as $index => $item) {
                $quantity = (float) ($item['quantity'] ?? 0);
                $rate = (float) ($item['rate'] ?? 0);
                $amount = $quantity * $rate;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $quantity,
                    'rate' => $rate,
                    'amount' => $amount,
                    'position' => $index,
                ]);
            }

            return $invoice;
        });
    }

    private function generateInvoiceNumber(): string
    {
        $sequence = str_pad((string) (Invoice::count() + 1), 4, '0', STR_PAD_LEFT);

        return 'INV-' . now()->format('Ymd') . '-' . $sequence;
    }
}
