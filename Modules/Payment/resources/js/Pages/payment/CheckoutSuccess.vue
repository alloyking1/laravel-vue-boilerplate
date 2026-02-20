<template>
    <div class="max-w-4xl mx-auto px-6 py-14">
        <div
            class="bg-gradient-to-br from-white via-gray-50 to-white border border-gray-200 rounded-3xl p-8 shadow-2xl md:grid md:grid-cols-[160px_1fr] md:items-center gap-6">
            <!-- Icon Section -->
            <div class="grid place-items-center mb-6 md:mb-0">
                <CelebrationIcon />
                <span
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gray-200 bg-white text-xs font-semibold text-gray-900 mt-3">
                    Payment confirmed
                </span>
            </div>

            <!-- Content Section -->
            <div class="space-y-6">
                <div class="space-y-2.5">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                        You're all set 🎉
                    </h1>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Thanks! Your checkout is complete. Below is a quick snapshot of your subscription and the latest
                        transaction.
                    </p>
                </div>

                <!-- Cards Grid -->
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Subscription Card -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-4.5 space-y-2">
                        <p class="font-semibold text-gray-900">Subscription</p>
                        <div v-if="subscription" class="text-sm text-gray-700 space-y-1">
                            <div><strong>Status:</strong> {{ subscription.status }}</div>
                            <div><strong>Type:</strong> {{ subscription.type }}</div>
                            <div>
                                <strong>Trial ends:</strong>
                                {{ subscription.trial_ends_at ? formatDate(subscription.trial_ends_at) : '—' }}
                            </div>
                        </div>
                        <div v-else class="text-sm text-gray-500">
                            No subscription record yet. This can take a few moments after checkout.
                        </div>
                    </div>

                    <!-- Transaction Card -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-4.5 space-y-2">
                        <p class="font-semibold text-gray-900">Latest transaction</p>
                        <div v-if="transaction" class="text-sm text-gray-700 space-y-1">
                            <div><strong>Status:</strong> {{ transaction.status }}</div>
                            <div><strong>Total:</strong> {{ transaction.currency }} {{ transaction.total }}</div>
                            <div>
                                <strong>Billed at:</strong>
                                {{ transaction.billed_at ? formatDateTime(transaction.billed_at) : '—' }}
                            </div>
                        </div>
                        <div v-else class="text-sm text-gray-500">
                            No transaction record yet. It should appear once the webhook is processed.
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-3 items-center">
                    <Link href="/payments"
                        class="inline-flex items-center justify-center px-5 py-3 rounded-full bg-gray-900 text-white text-sm font-semibold shadow-lg hover:bg-gray-800 transition-colors">
                        Back to payments
                    </Link>
                    <span class="text-xs text-gray-400">
                        Need help? Reply to your receipt email.
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import CelebrationIcon from '../../Components/CelebrationIcon.vue'

interface Subscription {
    status: string
    type: string
    trial_ends_at: string | null
}

interface Transaction {
    status: string
    currency: string
    total: string
    billed_at: string | null
}

defineProps<{
    subscription: Subscription | null
    transaction: Transaction | null
}>()

const formatDate = (dateString: string): string => {
    return new Date(dateString).toLocaleDateString()
}

const formatDateTime = (dateString: string): string => {
    return new Date(dateString).toLocaleString()
}
</script>
