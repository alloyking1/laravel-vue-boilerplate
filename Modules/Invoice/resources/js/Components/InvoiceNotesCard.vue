<script setup lang="ts">
interface Props {
    notes?: string | null;
}

defineProps<Props>();
</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-black/40">Notes</p>
        <p v-if="notes" class="mt-4 text-sm text-black/70 whitespace-pre-line">{{ notes }}</p>
        <p v-else class="mt-4 text-sm text-black/50">No notes added.</p>
    </div>
</template>
