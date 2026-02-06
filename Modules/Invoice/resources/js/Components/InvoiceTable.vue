<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
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
defineEmits<{
    'edit': [invoiceId: number];
    'delete': [invoiceId: number];
}>();
</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white">
        <div
            class="grid grid-cols-6 gap-4 border-b border-black/10 px-6 py-4 text-xs font-semibold uppercase tracking-widest text-black/50">
            <span>Invoice</span>
            <span>Client</span>
            <span>Issue date</span>
            <span>Due date</span>
            <span class="text-right">Total</span>
            <span class="text-right">Action</span>
        </div>
        <div v-if="invoices.length" class="divide-y divide-black/5">
            <div v-for="invoice in invoices" :key="invoice.id"
                class="grid grid-cols-6 gap-4 px-6 py-4 text-sm text-black items-center">
                <Link :href="`/invoices/${invoice.id}`" class="space-y-2 hover:text-black/70 transition">
                    <p class="font-medium">{{ invoice.invoiceNumber }}</p>
                    <StatusPill :status="invoice.status" />
                </Link>
                <Link :href="`/invoices/${invoice.id}`" class="hover:text-black/70 transition">
                    <p class="font-medium">{{ invoice.client?.name ?? 'Unknown' }}</p>
                    <p class="text-xs text-black/50">{{ invoice.client?.email ?? '—' }}</p>
                </Link>
                <Link :href="`/invoices/${invoice.id}`" class="hover:text-black/70 transition">
                    {{ invoice.issueDate ?? '—' }}
                </Link>
                <Link :href="`/invoices/${invoice.id}`" class="hover:text-black/70 transition">
                    {{ invoice.dueDate ?? '—' }}
                </Link>
                <Link :href="`/invoices/${invoice.id}`" class="text-right font-semibold hover:text-black/70 transition">
                    {{ formatCurrency(invoice.total) }}
                </Link>
                <div class="flex items-center justify-end gap-3">
                    <button @click="$emit('edit', invoice.id)"
                        class="text-xs font-semibold text-black/60 hover:text-black transition">
                        Edit
                    </button>
                    <button @click="$emit('delete', invoice.id)"
                        class="text-xs font-semibold text-red-500/80 hover:text-red-600 transition">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        <div v-else class="px-6 py-8 text-sm text-black/50">
            No invoices yet. Create your first invoice to see it here.
        </div>
    </div>
</template>
