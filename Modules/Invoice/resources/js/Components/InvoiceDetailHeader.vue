<script setup lang="ts">
import StatusPill from './StatusPill.vue';

interface Props {
    invoiceNumber: string;
    status: string;
    issueDate?: string | null;
    dueDate?: string | null;
}

defineProps<Props>();
</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-black/40">Invoice</p>
                <div class="mt-2 flex items-center gap-3">
                    <h1 class="text-3xl font-semibold text-black">{{ invoiceNumber }}</h1>
                    <StatusPill :status="status" />
                </div>
                <div class="mt-3 flex flex-wrap gap-4 text-sm text-black/50">
                    <span>Issued: <span class="text-black">{{ issueDate ?? '—' }}</span></span>
                    <span>Due: <span class="text-black">{{ dueDate ?? '—' }}</span></span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>
