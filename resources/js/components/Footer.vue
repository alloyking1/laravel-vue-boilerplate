<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const appName = page.props.name as string;
</script>

<template>
    <footer class="mx-auto w-full max-w-6xl border-t border-black/10 px-6 py-12">
        <div class="flex flex-wrap items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-xl border border-black bg-black text-sm text-white">
                    {{ appName?.charAt(0) || 'P' }}
                </div>
                <span class="font-semibold">{{ appName }}</span>
            </div>
            <p class="text-sm text-black/50">&copy; 2026 {{ appName }}. Finance clarity for ecommerce.</p>
        </div>
    </footer>
</template>
