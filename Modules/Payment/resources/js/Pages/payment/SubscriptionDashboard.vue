<template>

    <Head title="Subscription Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-6">
            <!-- Current Subscription Card -->
            <div v-if="subscription" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Current Subscription</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ subscription.type }}</p>
                    </div>
                    <span :class="[
                        'px-3 py-1 rounded-full text-xs font-semibold',
                        subscription.status === 'active' ? 'bg-green-100 text-green-800' :
                            subscription.status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                subscription.status === 'trialing' ? 'bg-blue-100 text-blue-800' :
                                    'bg-gray-100 text-gray-800'
                    ]">
                        {{ subscription.status }}
                    </span>
                </div>

                <!-- Subscription Details Grid -->
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Plan</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ subscription.paddle_plan || 'N/A' }}
                            </p>
                        </div>
                        <div v-if="subscription.trial_ends_at">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Trial Ends</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">
                                {{ formatDate(subscription.trial_ends_at) }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div v-if="subscription.ends_at">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Ends At</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ formatDate(subscription.ends_at) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Created</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ formatDate(subscription.created_at) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                    <button v-if="subscription.status === 'active' && !subscription.ends_at"
                        @click="showSwapModal = true"
                        class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        Change Plan
                    </button>

                    <button v-if="subscription.status === 'active' && !subscription.ends_at" @click="cancelSubscription"
                        :disabled="processing"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50">
                        {{ processing ? 'Processing...' : 'Cancel Subscription' }}
                    </button>

                    <button v-if="subscription.ends_at && subscription.status !== 'cancelled'"
                        @click="resumeSubscription" :disabled="processing"
                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50">
                        {{ processing ? 'Processing...' : 'Resume Subscription' }}
                    </button>
                </div>
            </div>

            <!-- No Subscription State -->
            <div v-else class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Active Subscription</h3>
                    <p class="text-sm text-gray-600 mb-6">You don't have an active subscription yet. Choose a plan to
                        get started.</p>
                    <Link href="/payments/create"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition-colors">
                        View Plans
                    </Link>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div v-if="transactions.length > 0" class="mt-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Transactions</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <div v-for="transaction in transactions" :key="transaction.id"
                            class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ transaction.currency }} {{ transaction.total }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ transaction.billed_at ? formatDateTime(transaction.billed_at) : 'Pending' }}
                                    </p>
                                </div>
                                <span :class="[
                                    'px-2 py-1 rounded text-xs font-medium',
                                    transaction.status === 'completed' ? 'bg-green-100 text-green-800' :
                                        transaction.status === 'billed' ? 'bg-green-100 text-green-800' :
                                            transaction.status === 'past_due' ? 'bg-red-100 text-red-800' :
                                                'bg-gray-100 text-gray-800'
                                ]">
                                    {{ transaction.status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Swap Plan Modal -->
        <div v-if="showSwapModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="fixed inset-0 bg-black/50 transition-opacity" @click="showSwapModal = false"></div>

                <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6 z-10">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Change Plan</h3>
                        <p class="text-sm text-gray-600 mt-1">Select a new plan to switch to</p>
                    </div>

                    <form @submit.prevent="swapPlan">
                        <div class="mb-4">
                            <label for="new_plan" class="block text-sm font-medium text-gray-700 mb-2">
                                New Plan ID
                            </label>
                            <input id="new_plan" v-model="swapForm.plan" type="text" required
                                placeholder="Enter Paddle price ID"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent" />
                            <p class="text-xs text-gray-500 mt-1">Enter the Paddle price ID for the new plan</p>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="showSwapModal = false"
                                class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" :disabled="processing"
                                class="flex-1 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors disabled:opacity-50">
                                {{ processing ? 'Processing...' : 'Change Plan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Link, router, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import type { BreadcrumbItem } from '@/types'

interface Subscription {
    id: number
    type: string
    status: string
    paddle_plan: string | null
    trial_ends_at: string | null
    ends_at: string | null
    created_at: string
}

interface Transaction {
    id: number
    status: string
    currency: string
    total: string
    billed_at: string | null
}

const props = defineProps<{
    subscription: Subscription | null
    transactions: Transaction[]
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Subscription',
        href: '/payments',
    },
]

const showSwapModal = ref(false)
const processing = ref(false)
const swapForm = ref({
    plan: ''
})

const formatDate = (dateString: string): string => {
    return new Date(dateString).toLocaleDateString()
}

const formatDateTime = (dateString: string): string => {
    return new Date(dateString).toLocaleString()
}

const swapPlan = () => {
    if (!props.subscription) return

    processing.value = true
    router.post('/payments/subscription/swap', swapForm.value, {
        onFinish: () => {
            processing.value = false
            showSwapModal.value = false
            swapForm.value.plan = ''
        }
    })
}

const cancelSubscription = () => {
    if (!props.subscription) return

    if (!confirm('Are you sure you want to cancel your subscription? You will continue to have access until the end of your billing period.')) {
        return
    }

    processing.value = true
    router.post('/payments/subscription/cancel', {}, {
        onFinish: () => {
            processing.value = false
        }
    })
}

const resumeSubscription = () => {
    if (!props.subscription) return

    processing.value = true
    router.post('/payments/subscription/resume', {}, {
        onFinish: () => {
            processing.value = false
        }
    })
}
</script>
