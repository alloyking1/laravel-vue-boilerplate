<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import TeamController from "@/actions/App/Http/Controllers/TeamController";
import BusinessController from '@/actions/App/Http/Controllers/BusinessController';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Users, BriefcaseBusiness, Building2, ShieldHalf, FileText } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Invoices',
        href: '/invoices',
        icon: FileText,
    },
    {
        title: 'Senders',
        href: '/invoices/senders',
        icon: Building2,
    },
    {
        title: 'Business',
        href: '#',
        icon: BriefcaseBusiness,
        isDropdown: true,
        dropdownItems: [
            {
                title: 'My Business',
                href: BusinessController.index(),
                icon: Building2,
            },
            {
                title: 'Teams/Departments',
                href: '/teams',
                icon: ShieldHalf,
            },
            {
                title: 'Staff/Employees',
                href: TeamController.create(),
                icon: Users,
            },
        ],
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];

</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <!-- <Sidebar collapsible="offcanvas" variant="floating"> -->
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
