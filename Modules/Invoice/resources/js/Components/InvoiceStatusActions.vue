<script setup lang="ts">
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Props {
    invoiceId: number;
    status: string;
}

const props = defineProps<Props>();

const statuses = [
    { value: 'draft', label: 'Draft' },
    { value: 'sent', label: 'Sent' },
    { value: 'paid', label: 'Paid' },
    { value: 'overdue', label: 'Overdue' },
];

const form = useForm({
    status: props.status,
});

const isProcessing = computed(() => form.processing);

const setStatus = (status: string) => {
    if (status === props.status || form.processing) return;
    form.status = status;
    form.patch(`/invoices/${props.invoiceId}/status`, {
        preserveScroll: true,
        onSuccess: () => toast.success('Status updated'),
        onError: () => toast.error('Failed to update status'),
    });
};
</script>

<template>
    <div class="flex flex-wrap gap-2">
        <button v-for="option in statuses" :key="option.value" type="button"
            :disabled="option.value === status || isProcessing" @click="setStatus(option.value)" :class="[
                'rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-widest transition',
                option.value === status
                    ? 'border-black bg-black text-white'
                    : 'border-black/10 text-black hover:border-black/30',
                isProcessing ? 'opacity-60' : '',
            ]">
            {{ option.label }}
        </button>
    </div>
</template>
