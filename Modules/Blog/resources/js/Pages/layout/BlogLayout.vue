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
    <div class="bg-black">
        <!-- <AppLayout :breadcrumbs="breadcrumbs"> -->
        <Toaster />
        <slot />
        <!-- </AppLayout> -->
    </div>
</template>
