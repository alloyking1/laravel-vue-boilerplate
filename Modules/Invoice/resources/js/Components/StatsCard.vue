<script setup lang="ts">
interface Props {
    label: string;
    value: string | number;
    hint?: string;
}

defineProps<Props>();
</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white p-5 shadow-sm">
        <p class="text-xs font-medium uppercase tracking-widest text-black/50">
            {{ label }}
        </p>
        <div class="mt-3 text-2xl font-semibold text-black">
            {{ value }}
        </div>
        <p v-if="hint" class="mt-2 text-sm text-black/50">
            {{ hint }}
        </p>
    </div>
</template>
