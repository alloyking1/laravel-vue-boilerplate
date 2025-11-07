<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="max-w-6xl mx-auto h-screen">
        <div class="flex items-center justify-center min-h-screen">
            <div>
                <h1 class="text-8xl mb-4">Payzora</h1>
                <h1 class="scroll-m-20 text-2xl font-extrabold tracking-tight lg:text-6xl motion-preset-float">
                    Global payment solution for businesses and freelancers
                </h1>
                <p class="pt-2 motion-preset-typewriter-[24]">
                    Invoicing, Payroll, Bill Payment, Airtime, Data Purchase
                </p>

                <div class="mt-2">
                    <Link :href="register().url" class="mr-4">
                    <button class="border p-2 rounded-2xl">Get Started</button>
                    </Link>

                    <Link :href="login().url" class="ml-4">
                    <button class="border p-2 rounded-2xl bg-white text-grey-600">Login</button>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
