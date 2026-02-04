<script setup lang="ts">
import StatusPill from './StatusPill.vue';

interface Client {
    id: number;
    name: string;
    email?: string | null;
}

interface InvoiceRow {
    id: number;
    invoiceNumber: string;
    status: string;
    issueDate?: string | null;
    dueDate?: string | null;
    total: number;
    client?: Client | null;
}

interface Props {
    invoices: InvoiceRow[];
    formatCurrency: (value: number) => string;
}

defineProps<Props>();
</script>

<template>
    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white">
        <div
            class="grid grid-cols-5 gap-4 border-b border-black/10 px-6 py-4 text-xs font-semibold uppercase tracking-widest text-black/50">
            <span>Invoice</span>
            <span>Client</span>
            <span>Issue date</span>
            <span>Due date</span>
            <span class="text-right">Total</span>
        </div>
        <div v-if="invoices.length" class="divide-y divide-black/5">
            <div v-for="invoice in invoices" :key="invoice.id"
                class="grid grid-cols-5 gap-4 px-6 py-4 text-sm text-black">
                <div class="space-y-2">
                    <p class="font-medium">{{ invoice.invoiceNumber }}</p>
                    <StatusPill :status="invoice.status" />
                </div>
                <div>
                    <p class="font-medium">{{ invoice.client?.name ?? 'Unknown' }}</p>
                    <p class="text-xs text-black/50">{{ invoice.client?.email ?? '—' }}</p>
                </div>
                <span>{{ invoice.issueDate ?? '—' }}</span>
                <span>{{ invoice.dueDate ?? '—' }}</span>
                <span class="text-right font-semibold">{{ formatCurrency(invoice.total) }}</span>
            </div>
        </div>
        <div v-else class="px-6 py-8 text-sm text-black/50">
            No invoices yet. Create your first invoice to see it here.
        </div>
    </div>
</template>
