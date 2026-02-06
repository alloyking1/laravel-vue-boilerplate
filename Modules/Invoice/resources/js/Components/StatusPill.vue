<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    status: string;
}

const props = defineProps<Props>();

const classes = computed(() => {
    switch (props.status) {
        case 'paid':
            return 'bg-emerald-500 text-white';
        case 'overdue':
            return 'bg-red-600 text-white';
        case 'sent':
            return 'bg-amber-500 text-black';
        default:
            return 'bg-black/5 text-black';
    }
});
</script>

<template>
    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium capitalize" :class="classes">
        {{ status }}
    </span>
</template>
