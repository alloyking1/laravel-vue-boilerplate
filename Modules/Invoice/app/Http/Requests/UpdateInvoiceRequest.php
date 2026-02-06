<?php

namespace Modules\Invoice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $invoiceId = $this->route('invoice')?->id;

        return [
            'invoice_client_id' => ['nullable', 'exists:invoice_clients,id'],
            'client_name' => ['required_without:invoice_client_id', 'string', 'max:255'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:255'],
            'client_address' => ['nullable', 'string'],
            'client_notes' => ['nullable', 'string'],
            'invoice_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('invoices', 'invoice_number')->ignore($invoiceId),
            ],
            'status' => ['nullable', 'string', 'in:draft,sent,overdue,paid'],
            'issue_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'currency' => ['nullable', 'string', 'max:3'],
            'notes' => ['nullable', 'string'],
            'subtotal' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'total' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ];
    }
}
