<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import CreateBusiness from '@/components/blocks/business/CreateBusiness.vue';
// import BusinessDashboard from '@/components/blocks/business/BusinessDashboard.vue';
import { Bus } from 'lucide-vue-next';
import business from '@/routes/business';
import { onMounted } from 'vue';


const props = defineProps<
    {
        business: any
    }
>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Business',
        href: dashboard().url,
    },
];

onMounted(() => {
    // console.log(hasBusiness());
});

const hasBusiness = () => {
    if (props.business.length > 0) {
        return true;
    }
    return false;
}
</script>

<template>

    <Head title="Business" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div v-if="!hasBusiness()">
                    <CreateBusiness />
                </div>
                <div v-else>
                    This is your biz
                    <!-- <BusinessDashboard /> -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
