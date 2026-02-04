<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { login, register } from '@/routes';
</script>

<template>
    <header class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-6">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-2xl border border-black bg-black text-white">
                P
            </div>
            <span class="text-lg font-semibold tracking-tight">Payzora</span>
        </div>
        <div class="flex items-center gap-3">
            <Link :href="login().url" class="text-sm font-medium text-black/70 hover:text-black">Login</Link>
            <Link :href="register().url"
                class="rounded-full border border-black bg-black px-4 py-2 text-sm font-medium text-white hover:bg-black/90">
                Get started
            </Link>
        </div>
    </header>
</template>
