<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" :class="className" v-bind="$attrs">
        <!-- Black rounded rectangle background -->
        <rect x="4" y="4" width="56" height="56" rx="12" ry="12" fill="black" />

        <!-- White P letter -->
        <text x="32" y="44" font-size="42" font-weight="700" font-family="system-ui, -apple-system, sans-serif"
            text-anchor="middle" fill="white" dominant-baseline="middle">
            P
        </text>
    </svg>
</template>
