<script setup lang="ts">
interface Props {
    subtotal: number | string;
    tax: number | string;
    total: number | string;
    formatCurrency: (value: number) => string;
}

defineProps<Props>();
</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-black/40">Summary</p>
        <div class="mt-4 space-y-3 text-sm">
            <div class="flex items-center justify-between text-black/60">
                <span>Subtotal</span>
                <span class="font-semibold text-black">{{ formatCurrency(Number(subtotal)) }}</span>
            </div>
            <div class="flex items-center justify-between text-black/60">
                <span>Tax</span>
                <span class="font-semibold text-black">{{ formatCurrency(Number(tax)) }}</span>
            </div>
            <div class="border-t border-black/10 pt-3 flex items-center justify-between text-base font-semibold">
                <span>Total</span>
                <span>{{ formatCurrency(Number(total)) }}</span>
            </div>
        </div>
    </div>
</template>
