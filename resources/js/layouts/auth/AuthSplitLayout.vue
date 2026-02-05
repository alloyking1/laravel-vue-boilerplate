<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const name = page.props.name;
const quote = page.props.quote;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="relative grid h-dvh flex-col items-center justify-center lg:max-w-none lg:grid-cols-2">
        <!-- Left Panel with Gradient Background -->
        <div
            class="relative hidden h-full flex-col overflow-hidden bg-gradient-to-br from-black via-black/95 to-black/90 p-10 text-white lg:flex">
            <!-- Animated Background Elements -->
            <div class="absolute -left-24 -top-24 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>

            <!-- Logo & Brand -->
            <Link :href="home()" class="relative z-20 flex items-center gap-3 text-lg font-semibold">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-2xl border border-white/20 bg-black/10 backdrop-blur-sm">
                    <AppLogoIcon class="size-6 fill-current text-white" />
                </div>
                <span>{{ name }}</span>
            </Link>

            <!-- Center Content -->
            <div class="relative z-20 my-auto space-y-8">
                <div class="space-y-4">
                    <h2 class="text-4xl font-bold leading-tight">Welcome back to {{ name }}</h2>
                    <p class="text-lg text-white/70">Finance clarity for ecommerce founders</p>
                </div>

                <!-- Feature Highlights -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-white/80">Track invoices & payments</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-white/80">Monitor income & expenses</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-white/80">Clean, modern dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Quote Section -->
            <div v-if="quote" class="relative z-20 mt-auto">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
                    <blockquote class="space-y-3">
                        <p class="text-lg leading-relaxed">&ldquo;{{ quote.message }}&rdquo;</p>
                        <footer class="text-sm text-white/60">— {{ quote.author }}</footer>
                    </blockquote>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form Area -->
        <div class="flex min-h-full items-center justify-center bg-white px-8 py-12 sm:px-0 lg:p-12">
            <div class="mx-auto w-full max-w-[420px] space-y-8">
                <!-- Mobile Logo -->
                <Link :href="home()" class="flex items-center justify-center gap-3 lg:hidden">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl border border-black bg-black">
                        <AppLogoIcon class="size-6 fill-current text-white" />
                    </div>
                    <span class="text-lg font-semibold">{{ name }}</span>
                </Link>

                <!-- Form Header -->
                <div class="space-y-3 text-center">
                    <h1 v-if="title" class="text-3xl font-bold tracking-tight">{{ title }}</h1>
                    <p v-if="description" class="text-sm text-black/60">{{ description }}</p>
                </div>

                <!-- Form Content -->
                <slot />
            </div>
        </div>
    </div>
</template>
