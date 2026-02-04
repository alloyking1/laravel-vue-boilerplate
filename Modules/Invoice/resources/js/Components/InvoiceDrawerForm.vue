<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from '@/components/ui/drawer';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';
import InvoiceController from '@/actions/Modules/Invoice/Http/Controllers/InvoiceController';

interface ClientFolder {
    id: number;
    name: string;
    email?: string | null;
    phone?: string | null;
    address?: string | null;
    notes?: string | null;
    invoiceCount: number;
}

interface Props {
    clients: ClientFolder[];
}

const props = defineProps<Props>();
const page = usePage();
const isOpen = ref(false);
const showClientForm = ref(false);

const form = useForm({
    invoice_client_id: '' as number | string,
    client_name: '',
    client_email: '',
    client_phone: '',
    client_address: '',
    client_notes: '',
    invoice_number: '',
    issue_date: '',
    due_date: '',
    status: 'draft',
    currency: 'USD',
    notes: '',
    tax: 0,
    subtotal: 0,
    total: 0,
    items: [
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
            form.client_address = '';
            return;
        }

        if (!value) {
            showClientForm.value = false;
            form.client_name = '';
            form.client_email = '';
            form.client_address = '';
            return;
        }

        showClientForm.value = false;
        const client = selectedClient.value;
        if (!client) return;

        form.client_name = client.name ?? '';
        form.client_email = client.email ?? '';
        form.client_address = client.address ?? '';
    },
);

const removeItem = (index: number) => {
    if (form.items.length === 1) return;
    form.items.splice(index, 1);
};

const submit = () => {
    form.subtotal = subtotal.value;
    form.total = total.value;

    form.post(InvoiceController.store.url(), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Invoice created successfully');
            resetForm();
            isOpen.value = false;
        },
        onError: () => {
            toast.error('Failed to create invoice');
        },
    });
};

const resetForm = () => {
    form.reset();
    form.items = [
        {
            description: '',
            quantity: 1,
            rate: 0,
        },
    ];
    form.status = 'draft';
    form.currency = 'USD';
    showClientForm.value = false;
};
</script>

<template>
    <Drawer v-model:open="isOpen" direction="right">
        <DrawerTrigger class="rounded-full border border-black bg-black px-5 py-2 text-sm font-medium text-white">
            Create invoice
        </DrawerTrigger>

        <DrawerContent side="right" :show-handle="false" class="rounded-none border-black/10 bg-white">
            <div class="flex h-full flex-col">
                <DrawerHeader class="sticky top-0 z-10 border-b border-black/10 bg-white px-6 py-5">
                    <div class="flex items-start justify-between gap-6">
                        <div>
                            <DrawerTitle>Create invoice</DrawerTitle>
                            <p class="text-sm text-black/50">Add invoice details, client info, and line items.</p>
                        </div>
                        <DrawerClose
                            class="text-xs font-semibold uppercase tracking-widest text-black/50 hover:text-black">
                            Close
                        </DrawerClose>
                    </div>
                </DrawerHeader>

                <form @submit.prevent="submit" class="flex-1 space-y-6 overflow-y-auto px-6 py-6">
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
                                        class="w-full rounded-lg border border-black/10 px-3 py-2 text-sm"
                                        placeholder="Qty" />
                                    <InputError :message="form.errors[`items.${index}.quantity`]" />
                                </div>
                                <div>
                                    <input v-model.number="item.rate" type="number" min="0" step="0.01"
                                        class="w-full rounded-lg border border-black/10 px-3 py-2 text-sm"
                                        placeholder="Rate" />
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
                            <label
                                class="text-xs font-semibold uppercase tracking-widest text-black/40">Currency</label>
                            <input v-model="form.currency" type="text"
                                class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm" />
                            <InputError :message="form.errors.currency" />
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Tax</label>
                            <input v-model.number="form.tax" type="number" min="0" step="0.01"
                                class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                                placeholder="0.00" />
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
                </form>

                <DrawerFooter class="sticky bottom-0 z-10 border-t border-black/10 bg-white px-6 py-4">
                    <div class="grid grid-cols-2 gap-3">
                        <DrawerClose
                            class="rounded-full border border-black/10 px-4 py-2 text-sm font-semibold text-black">
                            Cancel
                        </DrawerClose>
                        <button type="submit" @click="submit"
                            class="rounded-full border border-black bg-black px-4 py-2 text-sm font-semibold text-white">
                            Save invoice
                        </button>
                    </div>
                </DrawerFooter>
            </div>
        </DrawerContent>
    </Drawer>
</template>
