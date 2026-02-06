<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import InvoiceEditForm from '@modules/Invoice/resources/js/Components/InvoiceEditForm.vue';

interface ClientFolder {
    id: number;
    name: string;
    email?: string | null;
    phone?: string | null;
    address?: string | null;
    notes?: string | null;
}

interface InvoiceItem {
    id: number;
    description: string;
    quantity: number | string;
    rate: number | string;
    amount: number | string;
    position?: number | null;
}

interface Invoice {
    id: number;
    invoice_client_id?: number | null;
    invoice_number: string;
    status: string;
    issue_date?: string | null;
    due_date?: string | null;
    currency?: string | null;
    notes?: string | null;
    subtotal?: number | string;
    tax?: number | string;
    total?: number | string;
    client?: ClientFolder | null;
    items: InvoiceItem[];
}

interface Props {
    invoice: Invoice;
    clients: ClientFolder[];
}

const props = defineProps<Props>();
</script>

<template>

    <Head :title="`Edit ${props.invoice.invoice_number}`" />

    <AppLayout>
        <div class="space-y-6 px-4 py-4">
            <InvoiceEditForm :invoice="props.invoice" :clients="props.clients" />
        </div>
    </AppLayout>
</template>
