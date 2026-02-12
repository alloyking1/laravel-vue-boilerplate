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

interface Sender {
    id: number;
    name: string;
    email?: string | null;
    phone?: string | null;
    address?: string | null;
    notes?: string | null;
    isDefault?: boolean;
    invoiceCount: number;
}

interface Props {
    senders: Sender[];
}

const props = defineProps<Props>();

const drawerOpen = ref(false);
const editingSender = ref<Sender | null>(null);
const deleteDialogOpen = ref(false);
const deleteSenderId = ref<number | null>(null);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    notes: '',
});

const openCreate = () => {
    editingSender.value = null;
    form.reset();
    drawerOpen.value = true;
};

const openEdit = (sender: Sender) => {
    editingSender.value = sender;
    form.name = sender.name ?? '';
    form.email = sender.email ?? '';
    form.phone = sender.phone ?? '';
    form.address = sender.address ?? '';
    form.notes = sender.notes ?? '';
    drawerOpen.value = true;
};

const submit = () => {
    if (editingSender.value) {
        form.put(`/invoices/senders/${editingSender.value.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Sender updated');
                drawerOpen.value = false;
            },
            onError: () => toast.error('Failed to update sender'),
        });
        return;
    }

    form.post('/invoices/senders', {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Sender created');
            drawerOpen.value = false;
        },
        onError: () => toast.error('Failed to create sender'),
    });
};

const requestDelete = (senderId: number) => {
    deleteSenderId.value = senderId;
    deleteDialogOpen.value = true;
};

const confirmDelete = () => {
    if (!deleteSenderId.value) return;

    router.delete(`/invoices/senders/${deleteSenderId.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Sender deleted');
            deleteDialogOpen.value = false;
            deleteSenderId.value = null;
        },
        onError: () => toast.error('Failed to delete sender'),
    });
};
</script>

<template>

    <Head title="Invoice Senders" />

    <AppLayout>
        <div class="space-y-6 px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-black">Senders</h1>
                    <p class="mt-2 text-sm text-black/50">Manage sender business details for invoices.</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link href="/invoices"
                        class="rounded-full border border-black/10 px-4 py-2 text-sm font-semibold text-black hover:border-black/30">
                        Back to invoices
                    </Link>
                    <button type="button" @click="openCreate"
                        class="rounded-full border border-black bg-black px-5 py-2 text-sm font-medium text-white">
                        New sender
                    </button>
                </div>
            </div>

            <div class="rounded-2xl border border-black/10 bg-white">
                <div
                    class="grid grid-cols-[1.6fr_1fr_1fr_100px] gap-4 border-b border-black/10 px-6 py-4 text-xs font-semibold uppercase tracking-widest text-black/50">
                    <span>Sender</span>
                    <span>Contact</span>
                    <span>Invoices</span>
                    <span class="text-right">Action</span>
                </div>
                <div v-if="props.senders.length" class="divide-y divide-black/5">
                    <div v-for="sender in props.senders" :key="sender.id"
                        class="grid grid-cols-[1.6fr_1fr_1fr_100px] gap-4 px-6 py-4 text-sm text-black items-center">
                        <div>
                            <p class="font-medium">{{ sender.name }}</p>
                            <p class="text-xs text-black/50" v-if="sender.address">{{ sender.address }}</p>
                        </div>
                        <div class="text-sm text-black/70">
                            <p v-if="sender.email">{{ sender.email }}</p>
                            <p v-if="sender.phone">{{ sender.phone }}</p>
                        </div>
                        <div class="text-sm text-black/70">{{ sender.invoiceCount }} invoice(s)</div>
                        <div class="flex items-center justify-end gap-3">
                            <button @click="openEdit(sender)"
                                class="text-xs font-semibold text-black/60 hover:text-black transition">
                                Edit
                            </button>
                            <button @click="requestDelete(sender.id)"
                                class="text-xs font-semibold text-red-500/80 hover:text-red-600 transition">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else class="px-6 py-8 text-sm text-black/50">
                    No senders yet. Create your first sender to get started.
                </div>
            </div>
        </div>

        <Drawer v-model:open="drawerOpen" direction="right">
            <DrawerContent side="right" :show-handle="false" class="rounded-none border-black/10 bg-white">
                <div class="flex h-full flex-col">
                    <DrawerHeader class="sticky top-0 z-10 border-b border-black/10 bg-white px-6 py-5">
                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <DrawerTitle>{{ editingSender ? 'Edit sender' : 'New sender' }}</DrawerTitle>
                                <p class="text-sm text-black/50">Manage sender business information.</p>
                            </div>
                            <DrawerClose
                                class="text-xs font-semibold uppercase tracking-widest text-black/50 hover:text-black">
                                Close
                            </DrawerClose>
                        </div>
                    </DrawerHeader>

                    <form @submit.prevent="submit" class="flex-1 space-y-6 overflow-y-auto px-6 py-6">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-widest text-black/40">Company
                                name</label>
                            <input v-model="form.name" type="text"
                                class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                                placeholder="Your Company" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="text-xs font-semibold uppercase tracking-widest text-black/40">Email</label>
                                <input v-model="form.email" type="email"
                                    class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm"
                                    placeholder="billing@company.com" />
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
                                placeholder="Extra details (optional)" />
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
                                {{ editingSender ? 'Save changes' : 'Create sender' }}
                            </button>
                        </div>
                    </DrawerFooter>
                </div>
            </DrawerContent>
        </Drawer>

        <AlertDialog v-model:open="deleteDialogOpen">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Delete sender?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This will remove the sender. You cannot delete a sender that already has invoices.
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
