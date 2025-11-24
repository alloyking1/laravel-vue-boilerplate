<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
// import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css' // vue-sonner v2 requires this import

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <div class="">
        <div class="max-w-7xl mx-auto pb-8">
            <div class="p-8 md:flex md:justify-between md:items-center grid">
                <h1 class="text-4xl font-bold">
                    {{ $page.props.name ?? 'Blog' }} Blog
                </h1>
                <p class="text-gray-500">Stories, insights, and advice that will transform how you design and build for
                    the web.</p>
            </div>
            <hr class="">
            <Toaster />
            <slot />
        </div>
    </div>
</template>
