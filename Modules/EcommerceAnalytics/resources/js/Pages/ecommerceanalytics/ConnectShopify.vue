<template>
    <AppLayout>
        <template #breadcrumbs>
            <Breadcrumbs :items="breadcrumbs" />
        </template>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Connect Shopify Store</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Connect your Shopify store to track sales, orders, and calculate profit.
                </p>
            </div>

            <!-- Connect Form -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form @submit.prevent="connectStore" class="space-y-4">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/40 dark:text-gray-400">
                            Your Shopify Store URL
                        </label>
                        <div class="mt-2 flex rounded-xl shadow-sm">
                            <input type="text" id="shop" v-model="shopDomain" placeholder="your-store-name"
                                class="flex-1 min-w-0 block w-full rounded-l-xl border border-black/10 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm transition-all focus:border-black focus:outline-none focus:ring-2 focus:ring-black/5 dark:focus:border-blue-500 dark:focus:ring-blue-500/50 dark:text-white"
                                required />
                            <span
                                class="inline-flex items-center px-3 rounded-r-xl border border-l-0 border-black/10 dark:border-gray-600 bg-black/[0.02] dark:bg-gray-900 text-black/50 dark:text-gray-400 text-sm">
                                .myshopify.com
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-black/50 dark:text-gray-400">
                            Enter your Shopify store name (e.g., if your store is mystore.myshopify.com, enter
                            "mystore")
                        </p>
                    </div>

                    <button type="submit" :disabled="processing"
                        class="w-full rounded-full border border-black bg-black px-4 py-2.5 text-sm font-semibold text-white transition-all hover:bg-black/90 focus:outline-none focus:ring-2 focus:ring-black/20 disabled:opacity-50 disabled:cursor-not-allowed dark:border-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
                        <span v-if="processing">Connecting...</span>
                        <span v-else>Connect Shopify Store</span>
                    </button>
                </form>
            </div>

            <!-- Connected Stores -->
            <div v-if="connectedStores.length > 0" class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Connected Stores</h2>
                </div>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li v-for="store in connectedStores" :key="store.id" class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ store.store_name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ store.store_url }}</p>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Connected
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Breadcrumbs from '@/components/Breadcrumbs.vue'
import type { BreadcrumbItem } from '@/types/breadcrumb'

interface ConnectedStore {
    id: number
    platform: string
    store_name: string
    store_url: string
    connection_status: string
    is_active: boolean
}

interface Props {
    connectedStores: ConnectedStore[]
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Analytics',
        href: '/ecommerce-analytics',
    },
    {
        title: 'Connect Shopify',
        href: '/ecommerce-analytics/shopify/connect',
    },
]

const shopDomain = ref('')
const processing = ref(false)

const connectStore = () => {
    if (!shopDomain.value) return

    processing.value = true

    const fullShopUrl = `${shopDomain.value}.myshopify.com`

    // OAuth requires full-page redirect - use GET request
    window.location.href = `/ecommerce-analytics/shopify/redirect?shop=${encodeURIComponent(fullShopUrl)}`
}
</script>
