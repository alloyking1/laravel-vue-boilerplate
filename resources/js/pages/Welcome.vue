<script setup lang="ts">
import { login, register } from '@/routes';
import { Head, Link, usePage } from '@inertiajs/vue3';
import GuestLayout from '@/layouts/GuestLayout.vue';
import LandingHeader from '@/Components/LandingHeader.vue';
import ComingSoonSection from '@/Components/ComingSoonSection.vue';
import Footer from '@/Components/Footer.vue';

const page = usePage();
const appName = page.props.name as string;
</script>

<template>
    <GuestLayout>
        <div class="min-h-screen bg-white text-black">

            <Head :title="`${appName} - Finance Hub for Ecommerce`" />

            <LandingHeader />

            <main>
                <!-- Hero Section -->
                <section class="relative mx-auto w-full max-w-6xl px-6 pb-20 pt-16">
                    <div class="grid gap-12 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="space-y-8">
                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-black/10 bg-black/[0.02] px-4 py-2">
                                <span class="h-2 w-2 animate-pulse rounded-full bg-black"></span>
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-black/60">Built for
                                    ecommerce teams</p>
                            </div>
                            <h1 class="text-5xl font-bold leading-[1.1] tracking-tight sm:text-6xl lg:text-7xl">
                                Track income, expenses, and invoices
                                <span
                                    class="block bg-gradient-to-r from-black to-black/60 bg-clip-text text-transparent">
                                    with clarity.
                                </span>
                            </h1>
                            <p class="text-xl leading-relaxed text-black/70">
                                {{ appName }} is a streamlined finance hub for ecommerce founders who want clarity
                                without
                                complexity.
                            </p>
                            <div class="flex flex-wrap gap-4 pt-4">
                                <Link :href="register().url"
                                    class="group relative overflow-hidden rounded-full border border-black bg-black px-8 py-4 text-sm font-semibold text-white transition-all hover:scale-105">
                                    <span class="relative z-10">Start free</span>
                                    <div
                                        class="absolute inset-0 -z-0 bg-gradient-to-r from-black/80 to-black opacity-0 transition-opacity group-hover:opacity-100">
                                    </div>
                                </Link>
                                <a href="#waitlist"
                                    class="rounded-full border-2 border-black px-8 py-4 text-sm font-semibold text-black transition-all hover:bg-black hover:text-white">
                                    Join the waitlist
                                </a>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-8 sm:grid-cols-3">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="mt-1 flex h-6 w-6 items-center justify-center rounded-lg bg-black text-white">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                            <path fill-rule="evenodd"
                                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold">Invoice management</p>
                                        <p class="text-xs text-black/50">Professional invoices</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div
                                        class="mt-1 flex h-6 w-6 items-center justify-center rounded-lg bg-black text-white">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold">Income tracking</p>
                                        <p class="text-xs text-black/50">Real-time revenue</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div
                                        class="mt-1 flex h-6 w-6 items-center justify-center rounded-lg bg-black text-white">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold">Expense watch</p>
                                        <p class="text-xs text-black/50">Monitor costs</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="absolute -right-4 -top-4 h-32 w-32 rounded-full bg-black/5 blur-3xl"></div>
                            <div class="absolute -bottom-8 -left-4 h-32 w-32 rounded-full bg-black/5 blur-3xl"></div>
                            <div
                                class="relative rounded-3xl border border-black/10 bg-gradient-to-br from-white to-black/[0.02] p-6 shadow-xl">
                                <div class="space-y-4">
                                    <div
                                        class="rounded-2xl border border-black/10 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                                        <p class="text-xs font-semibold uppercase tracking-widest text-black/40">Today
                                        </p>
                                        <p class="mt-3 text-3xl font-bold">$12,480.00</p>
                                        <p class="mt-1 text-sm text-black/50">Revenue collected</p>
                                        <div class="mt-3 flex items-center gap-1 text-xs font-semibold text-green-600">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            +24% from last week
                                        </div>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-black/10 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                                        <p class="text-xs font-semibold uppercase tracking-widest text-black/40">
                                            Outstanding</p>
                                        <p class="mt-3 text-3xl font-bold">$2,140.00</p>
                                        <p class="mt-1 text-sm text-black/50">3 invoices due</p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-black/10 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                                        <p class="text-xs font-semibold uppercase tracking-widest text-black/40">Expense
                                            watch</p>
                                        <p class="mt-3 text-3xl font-bold">$1,980.00</p>
                                        <p class="mt-1 text-sm text-black/50">Tools & ads</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Features Grid -->
                <section class="mx-auto w-full max-w-6xl px-6 py-24">
                    <div class="mb-12 text-center">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-black/50">Everything you need
                        </p>
                        <h2 class="mt-4 text-4xl font-bold">Built for modern ecommerce</h2>
                    </div>
                    <div class="grid gap-6 lg:grid-cols-3">
                        <div
                            class="group relative overflow-hidden rounded-3xl border border-black/10 bg-gradient-to-br from-white to-black/[0.02] p-8 transition-all hover:shadow-xl">
                            <div
                                class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-black/5 transition-transform group-hover:scale-150">
                            </div>
                            <div class="relative">
                                <div
                                    class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-black text-white">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd"
                                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Invoice module
                                </p>
                                <h3 class="mt-3 text-2xl font-bold">Send polished invoices in minutes.</h3>
                                <p class="mt-3 text-sm leading-relaxed text-black/60">
                                    Create, manage, and track invoices with client folders and real-time totals.
                                </p>
                            </div>
                        </div>
                        <div
                            class="group relative overflow-hidden rounded-3xl border border-black/10 bg-gradient-to-br from-white to-black/[0.02] p-8 transition-all hover:shadow-xl">
                            <div
                                class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-black/5 transition-transform group-hover:scale-150">
                            </div>
                            <div class="relative">
                                <div
                                    class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-black text-white">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Income &
                                    expense</p>
                                <h3 class="mt-3 text-2xl font-bold">See your ecommerce cash flow clearly.</h3>
                                <p class="mt-3 text-sm leading-relaxed text-black/60">
                                    Categorize sales, ads, and fulfillment costs to understand true profitability.
                                </p>
                            </div>
                        </div>
                        <div
                            class="group relative overflow-hidden rounded-3xl border border-black/10 bg-gradient-to-br from-white to-black/[0.02] p-8 transition-all hover:shadow-xl">
                            <div
                                class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-black/5 transition-transform group-hover:scale-150">
                            </div>
                            <div class="relative">
                                <div
                                    class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-black text-white">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Automation</p>
                                <h3 class="mt-3 text-2xl font-bold">Stay on top of outstanding payments.</h3>
                                <p class="mt-3 text-sm leading-relaxed text-black/60">
                                    Smart reminders and status tracking keep your invoices moving forward.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Detailed Features -->
                <section class="mx-auto w-full max-w-6xl px-6 py-24">
                    <div class="grid gap-12 lg:grid-cols-2">
                        <div
                            class="group relative overflow-hidden rounded-3xl border border-black/10 bg-gradient-to-br from-black to-black/90 p-10 text-white shadow-2xl">
                            <div class="absolute -right-12 -top-12 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>
                            <div class="relative">
                                <p class="text-xs font-semibold uppercase tracking-widest text-white/60">Invoice section
                                </p>
                                <h2 class="mt-4 text-4xl font-bold leading-tight">Invoice workflows that feel
                                    effortless.</h2>
                                <p class="mt-4 text-white/80">
                                    Draft invoices, save client details, and track status changes without leaving your
                                    dashboard.
                                </p>
                                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                                    <div
                                        class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm transition-all hover:bg-white/10">
                                        <p class="font-semibold">Client folders</p>
                                        <p class="mt-1 text-sm text-white/60">Organize invoices by customer.</p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm transition-all hover:bg-white/10">
                                        <p class="font-semibold">Status tracking</p>
                                        <p class="mt-1 text-sm text-white/60">Draft, sent, overdue, paid.</p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm transition-all hover:bg-white/10">
                                        <p class="font-semibold">Auto-numbering</p>
                                        <p class="mt-1 text-sm text-white/60">Sequential invoice IDs.</p>
                                    </div>
                                    <div
                                        class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm transition-all hover:bg-white/10">
                                        <p class="font-semibold">Line items</p>
                                        <p class="mt-1 text-sm text-white/60">Dynamic calculations.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-black/10 bg-white p-10 shadow-xl">
                            <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Income & expense
                            </p>
                            <h2 class="mt-4 text-4xl font-bold">Ecommerce cash flow in one place.</h2>
                            <p class="mt-4 text-black/70">
                                Compare ad spend with revenue, monitor margins, and export reports anytime.
                            </p>
                            <ul class="mt-8 space-y-4">
                                <li class="flex items-start gap-4">
                                    <div
                                        class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-black text-white">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Complete transaction log</p>
                                        <p class="text-sm text-black/60">Sales, refunds, and transaction fees tracked
                                            automatically.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-black text-white">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Channel profitability</p>
                                        <p class="text-sm text-black/60">Understand which sales channels drive real
                                            profit.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-black text-white">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Trend analytics</p>
                                        <p class="text-sm text-black/60">Monthly and weekly snapshots of financial
                                            health.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                <ComingSoonSection />

                <Footer />
            </main>
        </div>
    </GuestLayout>
</template>
