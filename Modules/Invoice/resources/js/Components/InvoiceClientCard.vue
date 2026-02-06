<script setup lang="ts">
interface Client {
    name: string;
    email?: string | null;
    phone?: string | null;
    address?: string | null;
    notes?: string | null;
}

interface Props {
    client?: Client | null;
}

defineProps<Props>();
</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-black/40">Billed to</p>
        <div v-if="client" class="mt-4 space-y-2">
            <p class="text-lg font-semibold text-black">{{ client.name }}</p>
            <div class="text-sm text-black/60 space-y-1">
                <p v-if="client.email">{{ client.email }}</p>
                <p v-if="client.phone">{{ client.phone }}</p>
                <p v-if="client.address" class="whitespace-pre-line">{{ client.address }}</p>
                <p v-if="client.notes" class="text-black/50">{{ client.notes }}</p>
            </div>
        </div>
        <p v-else class="mt-4 text-sm text-black/50">No client information attached.</p>
    </div>
</template>
