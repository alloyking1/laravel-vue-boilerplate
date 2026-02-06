<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import InvoiceDetailHeader from '@modules/Invoice/resources/js/Components/InvoiceDetailHeader.vue';
import InvoiceClientCard from '@modules/Invoice/resources/js/Components/InvoiceClientCard.vue';
import InvoiceItemsTable from '@modules/Invoice/resources/js/Components/InvoiceItemsTable.vue';
import InvoiceSummaryCard from '@modules/Invoice/resources/js/Components/InvoiceSummaryCard.vue';
import InvoiceStatusActions from '@modules/Invoice/resources/js/Components/InvoiceStatusActions.vue';
import InvoiceNotesCard from '@modules/Invoice/resources/js/Components/InvoiceNotesCard.vue';

interface InvoiceClient {
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
    invoice_number: string;
    status: string;
    issue_date?: string | null;
    due_date?: string | null;
    currency?: string | null;
    subtotal: number | string;
    tax: number | string;
    total: number | string;
    notes?: string | null;
    client?: InvoiceClient | null;
    items: InvoiceItem[];
}

interface Props {
    invoice: Invoice;
}

const props = defineProps<Props>();

const currency = computed(() => props.invoice.currency || 'USD');

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency.value,
    }).format(Number(value ?? 0));
};

const formatDate = (value?: string | null) => {
    if (!value) return '—';
    return new Date(value).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const sortedItems = computed(() => {
    return [...(props.invoice.items ?? [])].sort((a, b) => {
        return (a.position ?? 0) - (b.position ?? 0);
    });
});

const handlePrint = () => {
    window.print();
};
</script>

<template>

    <Head :title="`Invoice ${props.invoice.invoice_number}`" />

    <AppLayout>
        <div class="space-y-6 px-4 py-4">
            <InvoiceDetailHeader :invoice-number="props.invoice.invoice_number" :status="props.invoice.status"
                :issue-date="formatDate(props.invoice.issue_date)" :due-date="formatDate(props.invoice.due_date)">
                <template #actions>
                    <div class="no-print flex items-center gap-3">
                        <InvoiceStatusActions :invoice-id="props.invoice.id" :status="props.invoice.status" />
                        <button type="button" @click="handlePrint"
                            class="rounded-full border border-black/10 px-4 py-2 text-sm font-semibold text-black hover:border-black/30">
                            Print / PDF
                        </button>
                        <Link href="/invoices"
                            class="rounded-full border border-black/10 px-4 py-2 text-sm font-semibold text-black hover:border-black/30">
                            Back to invoices
                        </Link>
                    </div>
                </template>
            </InvoiceDetailHeader>

            <div class="grid gap-6 lg:grid-cols-[1.4fr_0.6fr]">
                <div class="space-y-6">
                    <InvoiceItemsTable :items="sortedItems" :format-currency="formatCurrency" />
                    <InvoiceNotesCard :notes="props.invoice.notes" />
                </div>
                <div class="space-y-6">
                    <InvoiceClientCard :client="props.invoice.client" />
                    <InvoiceSummaryCard :subtotal="props.invoice.subtotal" :tax="props.invoice.tax"
                        :total="props.invoice.total" :format-currency="formatCurrency" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
