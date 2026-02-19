<template>

    <Head title="Pricing Plans" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 overflow-x-auto rounded-xl p-6">
            <!-- Header Section -->
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Plan</h1>
                <p class="text-lg text-gray-600">
                    Select the perfect plan for your needs. All plans include a 7-day free trial.
                </p>

                <!-- Billing Toggle -->
                <div class="flex items-center justify-center gap-3 mt-6">
                    <span
                        :class="['text-sm font-medium transition-colors', billingPeriod === 'monthly' ? 'text-gray-900' : 'text-gray-500']">
                        Monthly
                    </span>
                    <button @click="toggleBillingPeriod" type="button" :class="[
                        'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2',
                        billingPeriod === 'yearly' ? 'bg-gray-900' : 'bg-gray-200'
                    ]">
                        <span :class="[
                            'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                            billingPeriod === 'yearly' ? 'translate-x-5' : 'translate-x-0'
                        ]" />
                    </button>
                    <span
                        :class="['text-sm font-medium transition-colors', billingPeriod === 'yearly' ? 'text-gray-900' : 'text-gray-500']">
                        Yearly
                    </span>
                    <span v-if="billingPeriod === 'yearly'"
                        class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                        Save 20%
                    </span>
                </div>
            </div>

            <!-- Pricing Cards -->
            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto w-full">
                <!-- Individual Plan -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 hover:shadow-lg transition-shadow">
                    <div class="mb-6">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">Individual</h3>
                        <p class="text-sm text-gray-600">Perfect for solo professionals and freelancers</p>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-5xl font-bold text-gray-900">
                                {{ billingPeriod === 'monthly' ? '$29' : '$279' }}
                            </span>
                            <span class="text-gray-600">{{ billingPeriod === 'monthly' ? '/month' : '/year' }}</span>
                        </div>
                        <p v-if="billingPeriod === 'yearly'" class="text-sm text-green-600 mt-2">
                            $23.25/month - Save $69/year
                        </p>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Unlimited projects</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>10GB storage</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Email support</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Basic analytics</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>API access</span>
                        </li>
                    </ul>

                    <button
                        @click="selectPlan('individual', billingPeriod === 'monthly' ? priceIds.individual_monthly : priceIds.individual_yearly)"
                        :disabled="processing"
                        class="w-full px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ processing ? 'Processing...' : 'Get Started' }}
                    </button>
                </div>

                <!-- Business Plan (Featured) -->
                <div
                    class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-xl border-2 border-gray-900 p-8 relative transform md:scale-105">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span class="px-4 py-1 bg-green-500 text-white text-xs font-semibold rounded-full shadow-lg">
                            MOST POPULAR
                        </span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-2xl font-semibold text-white mb-2">Business</h3>
                        <p class="text-sm text-gray-300">For growing teams and organizations</p>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-5xl font-bold text-white">
                                {{ billingPeriod === 'monthly' ? '$99' : '$950' }}
                            </span>
                            <span class="text-gray-300">{{ billingPeriod === 'monthly' ? '/month' : '/year' }}</span>
                        </div>
                        <p v-if="billingPeriod === 'yearly'" class="text-sm text-green-400 mt-2">
                            $79.17/month - Save $238/year
                        </p>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 text-sm text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Everything in Individual</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Unlimited team members</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>100GB storage</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Priority support</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Advanced analytics</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Custom integrations</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>SSO & advanced security</span>
                        </li>
                    </ul>

                    <button
                        @click="selectPlan('business', billingPeriod === 'monthly' ? priceIds.business_monthly : priceIds.business_yearly)"
                        :disabled="processing"
                        class="w-full px-6 py-3 bg-white text-gray-900 rounded-lg font-medium hover:bg-gray-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ processing ? 'Processing...' : 'Get Started' }}
                    </button>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="max-w-3xl mx-auto w-full mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Can I change plans later?</h3>
                        <p class="text-sm text-gray-600">Yes, you can upgrade or downgrade your plan at any time from
                            your subscription dashboard.</p>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-2">What payment methods do you accept?</h3>
                        <p class="text-sm text-gray-600">We accept all major credit cards, debit cards, and PayPal
                            through our secure payment processor, Paddle.</p>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Can I cancel anytime?</h3>
                        <p class="text-sm text-gray-600">Yes, you can cancel your subscription at any time. You'll
                            continue to have access until the end of your billing period.</p>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Do you offer refunds?</h3>
                        <p class="text-sm text-gray-600">Yes, we offer a 30-day money-back guarantee if you're not
                            satisfied with our service.</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { router, Head, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import type { BreadcrumbItem } from '@/types'

// Declare Paddle global type
declare global {
    interface Window {
        Paddle: any
    }
}

interface Props {
    priceIds: {
        individual_monthly: string
        individual_yearly: string
        business_monthly: string
        business_yearly: string
    }
}

const props = defineProps<Props>()
const page = usePage()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pricing Plans',
        href: '/pricing',
    },
]

const billingPeriod = ref<'monthly' | 'yearly'>('monthly')
const processing = ref(false)
const paddleInitialized = ref(false)

// Initialize Paddle
onMounted(() => {
    if (window.Paddle) {
        const token = page.props.paddle_client_token as string
        const isSandbox = page.props.paddle_sandbox as boolean
        
        // Set environment before initializing
        if (isSandbox) {
            window.Paddle.Environment.set('sandbox')
        }
        
        window.Paddle.Initialize({
            token: token,
            eventCallback: function(event: any) {
                if (event.name === 'checkout.completed') {
                    // Redirect to success page
                    router.visit('/payments/checkout/success')
                }
            }
        })
        paddleInitialized.value = true
    }
})

const toggleBillingPeriod = () => {
    billingPeriod.value = billingPeriod.value === 'monthly' ? 'yearly' : 'monthly'
}

const selectPlan = (planName: string, priceId: string) => {
    if (!priceId || priceId.includes('replace_me')) {
        alert('Please configure this price ID in your .env file')
        return
    }

    if (!paddleInitialized.value || !window.Paddle) {
        alert('Payment system is loading, please try again in a moment')
        return
    }

    processing.value = true

    const user = page.props.auth?.user as any
    
    // Open Paddle checkout
    window.Paddle.Checkout.open({
        items: [
            {
                priceId: priceId,
                quantity: 1
            }
        ],
        customer: {
            email: user?.email || undefined
        },
        customData: {
            user_id: user?.id?.toString() || '',
            plan_name: planName
        },
        settings: {
            displayMode: 'overlay',
            theme: 'light',
            locale: 'en',
            successUrl: window.location.origin + '/payments/checkout/success',
        }
    })

    processing.value = false
}
</script>
