<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import AppLayout from '@/layouts/AppLayout.vue';
import StatsCard from '@modules/Invoice/resources/js/Components/StatsCard.vue';
import InvoiceTable from '@modules/Invoice/resources/js/Components/InvoiceTable.vue';
import InvoiceDrawerForm from '@modules/Invoice/resources/js/Components/InvoiceDrawerForm.vue';
import InvoiceEditDrawerForm from '@modules/Invoice/resources/js/Components/InvoiceEditDrawerForm.vue';

interface Stats {
    totalRevenue: number;
    outstandingAmount: number;
    outstandingCount: number;
    invoiceCount: number;
}

interface ClientFolder {
    id: number;
    name: string;
    email?: string | null;
    phone?: string | null;
    address?: string | null;
    notes?: string | null;
    invoiceCount: number;
}

interface Client {
    id: number;
    name: string;
    email?: string | null;
}

interface InvoiceItem {
    id: number;
    description: string;
    quantity: number | string;
    rate: number | string;
    amount: number | string;
    position?: number | null;
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

interface InvoiceFull {
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
    invoices: InvoiceRow[];
    clients: ClientFolder[];
    stats: Stats;
}

const props = defineProps<Props>();
const selectedClientId = ref<number | null>(null);
const editDrawerOpen = ref(false);
const editingInvoice = ref<InvoiceFull | null>(null);
const isLoadingInvoice = ref(false);
const deleteDialogOpen = ref(false);
const deleteInvoiceId = ref<number | null>(null);

const handleEditInvoice = async (invoiceId: number) => {
    isLoadingInvoice.value = true;
    try {
        const response = await fetch(`/invoices/${invoiceId}/api`, {
            headers: {
                'Accept': 'application/json',
            }
        });

        if (response.ok) {
            const data = await response.json();
            editingInvoice.value = data.invoice as InvoiceFull;
            editDrawerOpen.value = true;
        } else {
            console.error('Failed to fetch invoice:', response.statusText);
        }
    } catch (error) {
        console.error('Failed to fetch invoice:', error);
    } finally {
        isLoadingInvoice.value = false;
    }
};

const handleDeleteInvoice = (invoiceId: number) => {
    deleteInvoiceId.value = invoiceId;
    deleteDialogOpen.value = true;
};

const confirmDeleteInvoice = () => {
    if (!deleteInvoiceId.value) return;

    router.delete(`/invoices/${deleteInvoiceId.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Invoice deleted');
            deleteDialogOpen.value = false;
            deleteInvoiceId.value = null;
        },
        onError: () => toast.error('Failed to delete invoice'),
    });
};

const filteredInvoices = computed(() => {
    if (!selectedClientId.value) return props.invoices;
    return props.invoices.filter((invoice) => invoice.client?.id === selectedClientId.value);
});

const selectedClientName = computed(() => {
    if (!selectedClientId.value) return null;
    return props.clients.find((c) => c.id === selectedClientId.value)?.name;
});

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(value ?? 0);
};
</script>

<template>

    <Head title="Invoice Dashboard" />

    <AppLayout>
        <div class="space-y-8 px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-black">Invoices</h1>
                    <p class="mt-2 text-sm text-black/50">
                        Track revenue, monitor outstanding payments, and manage client folders.
                    </p>
                </div>
                <InvoiceDrawerForm :clients="props.clients" />
            </div>

            <div class="grid gap-4 md:grid-cols-4">
                <StatsCard label="Total revenue" :value="formatCurrency(props.stats.totalRevenue)"
                    hint="All invoices" />
                <StatsCard label="Outstanding" :value="formatCurrency(props.stats.outstandingAmount)"
                    :hint="`${props.stats.outstandingCount} unpaid`" />
                <StatsCard label="Invoices" :value="props.stats.invoiceCount" hint="Total created" />
                <StatsCard label="Folders" :value="props.clients.length" hint="Invoice clients" />
            </div>

            <div class="grid gap-6 lg:grid-cols-[260px_1fr]">
                <div class="rounded-2xl border border-black/10 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold uppercase tracking-widest text-black/50">Client folders</h2>
                        <button v-if="selectedClientId" @click="selectedClientId = null"
                            class="text-xs font-semibold text-black hover:text-black/60">
                            Clear
                        </button>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div v-if="!props.clients.length" class="text-sm text-black/50">
                            No clients yet. Create your first invoice to add clients.
                        </div>
                        <button v-for="client in props.clients" :key="client.id" @click="selectedClientId = client.id"
                            :class="[
                                'flex w-full items-center justify-between rounded-xl border px-3 py-2 text-left text-sm transition-all',
                                selectedClientId === client.id
                                    ? 'border-black bg-black text-white'
                                    : 'border-black/10 text-black hover:border-black/30',
                            ]">
                            <span class="font-medium">{{ client.name }}</span>
                            <span :class="selectedClientId === client.id ? 'text-white/70' : 'text-black/50'"
                                class="text-xs">{{ client.invoiceCount }}</span>
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <div v-if="selectedClientName"
                        class="flex items-center justify-between rounded-xl border border-black/10 bg-black/[0.02] px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-black/50">Showing invoices for:</span>
                            <span class="font-medium text-black">{{ selectedClientName }}</span>
                        </div>
                        <span class="text-sm text-black/50">{{ filteredInvoices.length }} invoice(s)</span>
                    </div>
                    <InvoiceTable :invoices="filteredInvoices" :format-currency="formatCurrency"
                        @edit="handleEditInvoice" @delete="handleDeleteInvoice" />
                </div>
            </div>
        </div>
        <InvoiceEditDrawerForm v-if="editingInvoice" :is-open="editDrawerOpen" :invoice="editingInvoice"
            :clients="props.clients" @update:open="(open) => editDrawerOpen = open" />
        <AlertDialog v-model:open="deleteDialogOpen">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Delete invoice?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This will move the invoice to trash. You can restore it later.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="confirmDeleteInvoice" class="bg-red-600 hover:bg-red-700">
                        Delete
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AppLayout>
</template>
