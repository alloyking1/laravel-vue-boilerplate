<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import AppLayout from '@/layouts/AppLayout.vue';
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
} from '@/components/ui/drawer';
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
import InputError from '@/components/InputError.vue';

interface Client {
    id: number;
    name: string;
    email?: string | null;
    phone?: string | null;
    address?: string | null;
    notes?: string | null;
    invoiceCount: number;
}

interface Props {
    clients: Client[];
}

const props = defineProps<Props>();

const drawerOpen = ref(false);
const editingClient = ref<Client | null>(null);
const deleteDialogOpen = ref(false);
const deleteClientId = ref<number | null>(null);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    notes: '',
});

const openCreate = () => {
    editingClient.value = null;
    form.reset();
    drawerOpen.value = true;
};

const openEdit = (client: Client) => {
    editingClient.value = client;
    form.name = client.name ?? '';
    form.email = client.email ?? '';
    form.phone = client.phone ?? '';
    form.address = client.address ?? '';
    form.notes = client.notes ?? '';
    drawerOpen.value = true;
};

const submit = () => {
    if (editingClient.value) {
        form.put(`/invoices/clients/${editingClient.value.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Client updated');
                drawerOpen.value = false;
            },
            onError: () => toast.error('Failed to update client'),
        });
        return;
    }

    form.post('/invoices/clients', {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Client created');
            drawerOpen.value = false;
        },
        onError: () => toast.error('Failed to create client'),
    });
};

const requestDelete = (clientId: number) => {
    deleteClientId.value = clientId;
    deleteDialogOpen.value = true;
};

const confirmDelete = () => {
    if (!deleteClientId.value) return;

    router.delete(`/invoices/clients/${deleteClientId.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Client deleted');
            deleteDialogOpen.value = false;
            deleteClientId.value = null;
        },
        onError: () => toast.error('Failed to delete client'),
    });
};
</script>

<template>

    <Head title="Invoice Clients" />

    <AppLayout>
        <div class="space-y-6 px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-black">Clients</h1>
                    <p class="mt-2 text-sm text-black/50">Manage invoice client folders and contact details.</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link href="/invoices"
                        class="rounded-full border border-black/10 px-4 py-2 text-sm font-semibold text-black hover:border-black/30">
                        Back to invoices
                    </Link>
                    <button type="button" @click="openCreate"
                        class="rounded-full border border-black bg-black px-5 py-2 text-sm font-medium text-white">
                        New client
                    </button>
                </div>
            </div>

            <div class="rounded-2xl border border-black/10 bg-white">
                <div
                    class="grid grid-cols-[1.6fr_1fr_1fr_100px] gap-4 border-b border-black/10 px-6 py-4 text-xs font-semibold uppercase tracking-widest text-black/50">
                    <span>Client</span>
                    <span>Contact</span>
                    <span>Invoices</span>
                    <span class="text-right">Action</span>
                </div>
                <div v-if="props.clients.length" class="divide-y divide-black/5">
                    <div v-for="client in props.clients" :key="client.id"
                        class="grid grid-cols-[1.6fr_1fr_1fr_100px] gap-4 px-6 py-4 text-sm text-black items-center">
                        <div>
                            <p class="font-medium">{{ client.name }}</p>
                            <p class="text-xs text-black/50" v-if="client.address">{{ client.address }}</p>
                        </div>
                        <div class="text-sm text-black/70">
                            <p v-if="client.email">{{ client.email }}</p>
                            <p v-if="client.phone">{{ client.phone }}</p>
                        </div>
                        <div class="text-sm text-black/70">{{ client.invoiceCount }} invoice(s)</div>
                        <div class="flex items-center justify-end gap-3">
                            <button @click="openEdit(client)"
                                class="text-xs font-semibold text-black/60 hover:text-black transition">
                                Edit
                            </button>
                            <button @click="requestDelete(client.id)"
                                class="text-xs font-semibold text-red-500/80 hover:text-red-600 transition">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else class="px-6 py-8 text-sm text-black/50">
                    No clients yet. Create your first client to get started.
                </div>
            </div>
        </div>

        <Drawer v-model:open="drawerOpen" direction="right">
            <DrawerContent side="right" :show-handle="false" class="rounded-none border-black/10 bg-white">
                <div class="flex h-full flex-col">
                    <DrawerHeader class="sticky top-0 z-10 border-b border-black/10 bg-white px-6 py-5">
                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <DrawerTitle>{{ editingClient ? 'Edit client' : 'New client' }}</DrawerTitle>
                                <p class="text-sm text-black/50">Manage client contact information.</p>
                            </div>
                            <DrawerClose
                                class="text-xs font-semibold uppercase tracking-widest text-black/50 hover:text-black">
                                Close
                            </DrawerClose>
                        </div>
                    </DrawerHeader>

                    <form @submit.prevent="submit" class="flex-1 space-y-6 overflow-y-auto px-6 py-6">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Client
                                name</label>
                            <input v-model="form.name" type="text"
                                class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                                placeholder="Acme Studio" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="text-xs font-semibold uppercase tracking-widest text-black/40">Email</label>
                                <input v-model="form.email" type="email"
                                    class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                                    placeholder="hello@acme.com" />
                                <InputError :message="form.errors.email" />
                            </div>
                            <div>
                                <label
                                    class="text-xs font-semibold uppercase tracking-widest text-black/40">Phone</label>
                                <input v-model="form.phone" type="text"
                                    class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                                    placeholder="+1 555 123 4567" />
                                <InputError :message="form.errors.phone" />
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Address</label>
                            <textarea v-model="form.address" rows="3"
                                class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                                placeholder="123 Main St, City, Country" />
                            <InputError :message="form.errors.address" />
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Notes</label>
                            <textarea v-model="form.notes" rows="3"
                                class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                                placeholder="Preferred contact hours" />
                            <InputError :message="form.errors.notes" />
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
                                {{ editingClient ? 'Save changes' : 'Create client' }}
                            </button>
                        </div>
                    </DrawerFooter>
                </div>
            </DrawerContent>
        </Drawer>

        <AlertDialog v-model:open="deleteDialogOpen">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Delete client?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This will remove the client. You cannot delete clients that already have invoices.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="confirmDelete" class="bg-red-600 hover:bg-red-700">
                        Delete
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AppLayout>
</template>
