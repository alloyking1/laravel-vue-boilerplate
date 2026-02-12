<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { useVModel } from '@vueuse/core';
import { cn } from '@/lib/utils';

const props = defineProps<{
    modelValue?: string;
    class?: HTMLAttributes['class'];
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

const modelValue = useVModel(props, 'modelValue', emit, {
    passive: true,
    defaultValue: props.modelValue ?? '',
});
</script>

<template>
    <input v-model="modelValue" type="date"
        :class="cn('w-full rounded-xl border border-black/10 px-3 py-2 text-sm', props.class)">
</template>
