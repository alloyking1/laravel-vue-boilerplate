<script setup lang="ts">
interface Sender {
    name: string;
    email?: string | null;
    phone?: string | null;
    address?: string | null;
    notes?: string | null;
}

interface Props {
    sender?: Sender | null;
}

defineProps<Props>();
</script>

<template>
    <div class="invoice-card rounded-2xl border border-black/10 bg-white p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-black/40">From</p>
        <div v-if="sender" class="mt-4 space-y-2">
            <p class="text-lg font-semibold text-black">{{ sender.name }}</p>
            <div class="text-sm text-black/60 space-y-1">
                <p v-if="sender.email">{{ sender.email }}</p>
                <p v-if="sender.phone">{{ sender.phone }}</p>
                <p v-if="sender.address" class="whitespace-pre-line">{{ sender.address }}</p>
                <p v-if="sender.notes" class="text-black/50">{{ sender.notes }}</p>
            </div>
        </div>
        <p v-else class="mt-4 text-sm text-black/50">No sender information attached.</p>
    </div>
</template>
