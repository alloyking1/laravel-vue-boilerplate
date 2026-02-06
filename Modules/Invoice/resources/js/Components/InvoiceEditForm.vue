<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';

interface ClientFolder {
    id: number;
    name: string;
    email?: string | null;
    phone?: string | null;
    address?: string | null;
    notes?: string | null;
}

interface InvoiceItem {
    id?: number;
    description: string;
    quantity: number | string;
    rate: number | string;
    amount?: number | string;
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
    tax?: number | string;
    subtotal?: number | string;
    total?: number | string;
    client?: ClientFolder | null;
    items: InvoiceItem[];
}

interface Props {
    invoice: Invoice;
    clients: ClientFolder[];
}

const props = defineProps<Props>();

const showClientForm = ref(false);

const form = useForm({
    invoice_client_id: props.invoice.invoice_client_id ?? '' as number | string,
    client_name: props.invoice.client?.name ?? '',
    client_email: props.invoice.client?.email ?? '',
    client_phone: props.invoice.client?.phone ?? '',
    client_address: props.invoice.client?.address ?? '',
    client_notes: props.invoice.client?.notes ?? '',
    invoice_number: props.invoice.invoice_number ?? '',
    issue_date: props.invoice.issue_date ?? '',
    due_date: props.invoice.due_date ?? '',
    status: props.invoice.status ?? 'draft',
    currency: props.invoice.currency ?? 'USD',
    notes: props.invoice.notes ?? '',
    tax: Number(props.invoice.tax ?? 0),
    subtotal: Number(props.invoice.subtotal ?? 0),
    total: Number(props.invoice.total ?? 0),
    items: props.invoice.items?.length
        ? props.invoice.items.map((item) => ({
            id: item.id,
            description: item.description,
            quantity: item.quantity,
            rate: item.rate,
            amount: item.amount,
            position: item.position ?? 0,
        }))
        : [
            {
                description: '',
                quantity: 1,
                rate: 0,
            },
        ],
});

const subtotal = computed(() => {
    return form.items.reduce((sum, item) => {
        const quantity = Number(item.quantity) || 0;
        const rate = Number(item.rate) || 0;
        return sum + quantity * rate;
    }, 0);
});

const total = computed(() => subtotal.value + (Number(form.tax) || 0));

const addItem = () => {
    form.items.push({
        description: '',
        quantity: 1,
        rate: 0,
    });
};

const selectedClient = computed(() => {
    if (!form.invoice_client_id) return null;
    return props.clients.find((client) => client.id === Number(form.invoice_client_id)) ?? null;
});

watch(
    () => form.invoice_client_id,
    (value) => {
        if (value === 'new') {
            showClientForm.value = true;
            form.client_name = '';
            form.client_email = '';
            form.client_phone = '';
            form.client_address = '';
            form.client_notes = '';
            return;
        }

        if (!value) {
            showClientForm.value = false;
            return;
        }

        showClientForm.value = false;
        const client = selectedClient.value;
        if (!client) return;

        form.client_name = client.name ?? '';
        form.client_email = client.email ?? '';
        form.client_phone = client.phone ?? '';
        form.client_address = client.address ?? '';
        form.client_notes = client.notes ?? '';
    },
    { immediate: true },
);

const removeItem = (index: number) => {
    if (form.items.length === 1) return;
    form.items.splice(index, 1);
};

const submit = () => {
    form.subtotal = subtotal.value;
    form.total = total.value;

    form.put(`/invoices/${props.invoice.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Invoice updated successfully');
        },
        onError: () => {
            toast.error('Failed to update invoice');
        },
    });
};
</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white p-6">
        <div class="flex items-start justify-between gap-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-black/40">Edit invoice</p>
                <p class="mt-2 text-sm text-black/50">Update details, client info, and line items.</p>
            </div>
            <Link :href="`/invoices/${props.invoice.id}`"
                class="rounded-full border border-black/10 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-black hover:border-black/30">
                Cancel
            </Link>
        </div>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div class="space-y-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-black/40">Client folder</p>
                <select v-model="form.invoice_client_id"
                    class="w-full rounded-xl border border-black/10 px-3 py-2 text-sm">
                    <option value="">Select existing client</option>
                    <option value="new">+ Create new client</option>
                    <option v-for="client in props.clients" :key="client.id" :value="client.id">
                        {{ client.name }}
                    </option>
                </select>
                <InputError :message="form.errors.invoice_client_id" />
            </div>

            <div v-if="showClientForm || selectedClient"
                class="space-y-4 rounded-xl border border-black/10 bg-black/[0.02] p-4">
                <p class="text-xs font-semibold uppercase tracking-widest text-black/40">
                    {{ showClientForm ? 'New client details' : 'Client information' }}
                </p>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Client
                            name</label>
                        <input v-model="form.client_name" type="text" :disabled="!showClientForm"
                            class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm disabled:bg-black/5 disabled:text-black/50"
                            placeholder="Acme Studio" />
                        <InputError :message="form.errors.client_name" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Client
                            email</label>
                        <input v-model="form.client_email" type="email" :disabled="!showClientForm"
                            class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm disabled:bg-black/5 disabled:text-black/50"
                            placeholder="hello@acme.com" />
                        <InputError :message="form.errors.client_email" />
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Client
                            phone</label>
                        <input v-model="form.client_phone" type="text" :disabled="!showClientForm"
                            class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm disabled:bg-black/5 disabled:text-black/50"
                            placeholder="+1 555 123 4567" />
                        <InputError :message="form.errors.client_phone" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Client
                            notes</label>
                        <input v-model="form.client_notes" type="text" :disabled="!showClientForm"
                            class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm disabled:bg-black/5 disabled:text-black/50"
                            placeholder="Preferred contact hours" />
                        <InputError :message="form.errors.client_notes" />
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Client
                        address</label>
                    <input v-model="form.client_address" type="text" :disabled="!showClientForm"
                        class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm disabled:bg-black/5 disabled:text-black/50"
                        placeholder="123 Main St, City, Country" />
                    <InputError :message="form.errors.client_address" />
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Invoice
                        number</label>
                    <input v-model="form.invoice_number" type="text"
                        class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                        placeholder="INV-0001" />
                    <InputError :message="form.errors.invoice_number" />
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Status</label>
                    <select v-model="form.status"
                        class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm">
                        <option value="draft">Draft</option>
                        <option value="sent">Sent</option>
                        <option value="overdue">Overdue</option>
                        <option value="paid">Paid</option>
                    </select>
                    <InputError :message="form.errors.status" />
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Issue
                        date</label>
                    <input v-model="form.issue_date" type="date"
                        class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm" />
                    <InputError :message="form.errors.issue_date" />
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Due
                        date</label>
                    <input v-model="form.due_date" type="date"
                        class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm" />
                    <InputError :message="form.errors.due_date" />
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Line items</label>
                <div class="mt-3 space-y-3">
                    <div v-for="(item, index) in form.items" :key="index"
                        class="grid gap-3 rounded-xl border border-black/10 p-3 md:grid-cols-[2fr_1fr_1fr_auto]">
                        <div>
                            <input v-model="item.description" type="text"
                                class="w-full rounded-lg border border-black/10 px-3 py-2 text-sm"
                                placeholder="Item description" />
                            <InputError :message="form.errors[`items.${index}.description`]" />
                        </div>
                        <div>
                            <input v-model.number="item.quantity" type="number" min="0" step="0.01"
                                class="w-full rounded-lg border border-black/10 px-3 py-2 text-sm" placeholder="Qty" />
                            <InputError :message="form.errors[`items.${index}.quantity`]" />
                        </div>
                        <div>
                            <input v-model.number="item.rate" type="number" min="0" step="0.01"
                                class="w-full rounded-lg border border-black/10 px-3 py-2 text-sm" placeholder="Rate" />
                            <InputError :message="form.errors[`items.${index}.rate`]" />
                        </div>
                        <div class="flex items-center justify-end">
                            <button type="button" @click="removeItem(index)"
                                class="text-xs font-semibold text-black/50 hover:text-black">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" @click="addItem" class="mt-3 text-xs font-semibold text-black">
                    + Add line item
                </button>
                <InputError :message="form.errors.items" />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Currency</label>
                    <input v-model="form.currency" type="text"
                        class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm" />
                    <InputError :message="form.errors.currency" />
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Tax</label>
                    <input v-model.number="form.tax" type="number" min="0" step="0.01"
                        class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm" placeholder="0.00" />
                    <InputError :message="form.errors.tax" />
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Notes</label>
                <textarea v-model="form.notes" rows="3"
                    class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                    placeholder="Optional notes"></textarea>
                <InputError :message="form.errors.notes" />
            </div>

            <div class="rounded-2xl border border-black/10 bg-black/5 p-4 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-black/50">Subtotal</span>
                    <span class="font-semibold text-black">{{ subtotal.toFixed(2) }}</span>
                </div>
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-black/50">Tax</span>
                    <span class="font-semibold text-black">{{ Number(form.tax || 0).toFixed(2) }}</span>
                </div>
                <div class="mt-3 flex items-center justify-between text-base font-semibold">
                    <span>Total</span>
                    <span>{{ total.toFixed(2) }}</span>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <Link :href="`/invoices/${props.invoice.id}`"
                    class="rounded-full border border-black/10 px-5 py-2 text-sm font-semibold text-black">
                    Cancel
                </Link>
                <button type="submit"
                    class="rounded-full border border-black bg-black px-5 py-2 text-sm font-semibold text-white">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</template>
