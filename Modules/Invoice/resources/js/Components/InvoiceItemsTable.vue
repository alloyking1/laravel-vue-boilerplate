<script setup lang="ts">
interface InvoiceItem {
    id: number;
    description: string;
    quantity: number | string;
    rate: number | string;
    amount: number | string;
    position?: number | null;
}

interface Props {
    items: InvoiceItem[];
    formatCurrency: (value: number) => string;
}

defineProps<Props>();

const getAmount = (item: InvoiceItem) => {
    if (item.amount !== null && item.amount !== undefined) {
        return Number(item.amount);
    }
    return Number(item.quantity || 0) * Number(item.rate || 0);
};
</script>

<template>
    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white">
        <div
            class="grid grid-cols-4 gap-4 border-b border-black/10 px-6 py-4 text-xs font-semibold uppercase tracking-widest text-black/50">
            <span>Description</span>
            <span>Qty</span>
            <span>Rate</span>
            <span class="text-right">Amount</span>
        </div>
        <div v-if="items.length" class="divide-y divide-black/5">
            <div v-for="item in items" :key="item.id" class="grid grid-cols-4 gap-4 px-6 py-4 text-sm text-black">
                <span class="font-medium">{{ item.description }}</span>
                <span>{{ item.quantity }}</span>
                <span>{{ formatCurrency(Number(item.rate)) }}</span>
                <span class="text-right font-semibold">{{ formatCurrency(getAmount(item)) }}</span>
            </div>
        </div>
        <div v-else class="px-6 py-8 text-sm text-black/50">
            No line items found.
        </div>
    </div>
</template>
