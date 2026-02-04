<script setup lang="ts">
import { login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import LandingHeader from '@/Components/LandingHeader.vue';
import ComingSoonSection from '@/Components/ComingSoonSection.vue';
</script>

<template>
    <div class="min-h-screen bg-white text-black">

        <Head title="Payzora" />

        <LandingHeader />

        <main>
            <section class="mx-auto grid w-full max-w-6xl gap-10 px-6 pb-12 pt-10 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-black/50">Built for ecommerce teams
                    </p>
                    <h1 class="text-4xl font-semibold leading-tight sm:text-5xl">
                        Track income, expenses, and invoices with a clean, modern workspace.
                    </h1>
                    <p class="text-lg text-black/60">
                        Payzora is a streamlined finance hub for ecommerce founders who want clarity without complexity.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <Link :href="register().url"
                            class="rounded-full border border-black bg-black px-6 py-3 text-sm font-semibold text-white hover:bg-black/90">
                            Start free
                        </Link>
                        <a href="#waitlist"
                            class="rounded-full border border-black px-6 py-3 text-sm font-semibold text-black hover:bg-black/5">
                            Join the waitlist
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-6 text-sm text-black/60">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-black"></span>
                            Invoice management
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-black"></span>
                            Income & expense tracking
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-black"></span>
                            Lightweight team workflows
                        </div>
                    </div>
                </div>
                <div class="rounded-3xl border border-black/10 bg-black/[0.02] p-6">
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-black/10 bg-white p-4">
                            <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Today</p>
                            <p class="mt-2 text-2xl font-semibold">$12,480.00</p>
                            <p class="text-sm text-black/50">Revenue collected</p>
                        </div>
                        <div class="rounded-2xl border border-black/10 bg-white p-4">
                            <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Outstanding</p>
                            <p class="mt-2 text-2xl font-semibold">$2,140.00</p>
                            <p class="text-sm text-black/50">3 invoices due</p>
                        </div>
                        <div class="rounded-2xl border border-black/10 bg-white p-4">
                            <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Expense watch</p>
                            <p class="mt-2 text-2xl font-semibold">$1,980.00</p>
                            <p class="text-sm text-black/50">Tools & ads</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto w-full max-w-6xl px-6 py-12">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="rounded-3xl border border-black/10 p-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Invoice module</p>
                        <h2 class="mt-4 text-2xl font-semibold">Send polished invoices in minutes.</h2>
                        <p class="mt-3 text-sm text-black/60">
                            Create, manage, and track invoices with client folders and real-time totals.
                        </p>
                    </div>
                    <div class="rounded-3xl border border-black/10 p-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Income & expense</p>
                        <h2 class="mt-4 text-2xl font-semibold">See your ecommerce cash flow clearly.</h2>
                        <p class="mt-3 text-sm text-black/60">
                            Categorize sales, ads, and fulfillment costs to understand true profitability.
                        </p>
                    </div>
                    <div class="rounded-3xl border border-black/10 p-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Automation</p>
                        <h2 class="mt-4 text-2xl font-semibold">Stay on top of outstanding payments.</h2>
                        <p class="mt-3 text-sm text-black/60">
                            Smart reminders and status tracking keep your invoices moving forward.
                        </p>
                    </div>
                </div>
            </section>

            <section class="mx-auto w-full max-w-6xl px-6 py-12">
                <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="rounded-3xl border border-black/10 bg-black/[0.02] p-8">
                        <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Invoice section</p>
                        <h2 class="mt-4 text-3xl font-semibold">Invoice workflows that feel effortless.</h2>
                        <p class="mt-3 text-sm text-black/60">
                            Draft invoices, save client details, and track status changes without leaving your
                            dashboard.
                        </p>
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl border border-black/10 bg-white p-4">
                                <p class="text-sm font-semibold">Client folders</p>
                                <p class="text-xs text-black/50">Organize invoices by customer.</p>
                            </div>
                            <div class="rounded-2xl border border-black/10 bg-white p-4">
                                <p class="text-sm font-semibold">Status tracking</p>
                                <p class="text-xs text-black/50">Draft, sent, overdue, paid.</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-black/10 p-8">
                        <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Income & expense</p>
                        <h2 class="mt-4 text-3xl font-semibold">Ecommerce cash flow in one place.</h2>
                        <p class="mt-3 text-sm text-black/60">
                            Compare ad spend with revenue, monitor margins, and export reports anytime.
                        </p>
                        <ul class="mt-6 space-y-3 text-sm text-black/60">
                            <li class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-black"></span>
                                Sales, refunds, and transaction fees tracked.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-black"></span>
                                Channel-level profitability snapshots.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-black"></span>
                                Monthly and weekly trend views.
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <ComingSoonSection />
        </main>
    </div>
</template>
