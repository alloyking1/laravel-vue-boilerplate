<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { toast } from 'vue-sonner';
import InputError from '@/components/InputError.vue';

const page = usePage();
const appName = page.props.name as string;

const form = useForm({
    name: '',
    email: '',
    feature_suggestion: '',
    would_pay: '',
    price_point: '',
});

const showPricePoint = computed(() => form.would_pay === 'yes');

const submit = () => {
    form.post('/coming-soon', {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("You're on the waitlist");
            form.reset();
        },
        onError: () => {
            toast.error('Unable to join the waitlist');
        },
    });
};
</script>

<template>
    <section id="waitlist" class="mx-auto w-full max-w-6xl px-6 py-24">
        <div
            class="relative overflow-hidden rounded-3xl border border-black/10 bg-gradient-to-br from-white via-black/[0.02] to-white p-10 shadow-2xl lg:p-12">
            <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full bg-black/5 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-black/5 blur-3xl"></div>
            <div class="relative grid gap-10 lg:grid-cols-[1fr_1fr]">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-black/10 bg-black px-4 py-2">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-white"></span>
                        <p class="text-xs font-semibold uppercase tracking-widest text-white">Waiting list</p>
                    </div>
                    <h2 class="mt-6 text-4xl font-bold leading-tight lg:text-5xl">Be first to experience {{ appName }}.
                    </h2>
                    <p class="mt-4 text-lg leading-relaxed text-black/70">
                        Share what you need most and help us shape the product for ecommerce founders.
                    </p>
                    <div v-if="form.recentlySuccessful"
                        class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-4">
                        <p class="font-semibold text-green-900">✓ Thanks! You're on the list.</p>
                        <p class="mt-1 text-sm text-green-700">We'll reach out with early access soon.</p>
                    </div>
                    <div class="mt-8 space-y-4 text-sm text-black/60">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-black" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Early access to new features</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-black" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Shape product direction</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-black" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Special launch pricing</span>
                        </div>
                    </div>
                </div>
                <form class="grid gap-5" @submit.prevent="submit">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/50">Name</label>
                        <input v-model="form.name" type="text" placeholder="Jane Doe" required
                            class="mt-2 w-full rounded-xl border border-black/10 bg-white px-4 py-3 text-sm transition-all focus:border-black focus:outline-none focus:ring-2 focus:ring-black/5" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/50">Email</label>
                        <input v-model="form.email" type="email" placeholder="you@brand.com" required
                            class="mt-2 w-full rounded-xl border border-black/10 bg-white px-4 py-3 text-sm transition-all focus:border-black focus:outline-none focus:ring-2 focus:ring-black/5" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/50">Suggest a
                            feature</label>
                        <input v-model="form.feature_suggestion" type="text" placeholder="Automated profit reports"
                            class="mt-2 w-full rounded-xl border border-black/10 bg-white px-4 py-3 text-sm transition-all focus:border-black focus:outline-none focus:ring-2 focus:ring-black/5" />
                        <InputError :message="form.errors.feature_suggestion" />
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-widest text-black/50">Would you
                                pay?</label>
                            <select v-model="form.would_pay"
                                class="mt-2 w-full rounded-xl border border-black/10 bg-white px-4 py-3 text-sm transition-all focus:border-black focus:outline-none focus:ring-2 focus:ring-black/5">
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <InputError :message="form.errors.would_pay" />
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-widest text-black/50">If yes, how
                                much?</label>
                            <input v-model="form.price_point" type="text" placeholder="$7 / month"
                                :disabled="!showPricePoint"
                                class="mt-2 w-full rounded-xl border border-black/10 bg-white px-4 py-3 text-sm transition-all focus:border-black focus:outline-none focus:ring-2 focus:ring-black/5 disabled:bg-black/5 disabled:text-black/40" />
                            <InputError :message="form.errors.price_point" />
                        </div>
                    </div>
                    <button :disabled="form.processing"
                        class="mt-3 rounded-full border-2 border-black bg-black px-8 py-4 text-sm font-semibold text-white transition-all hover:scale-105 hover:shadow-lg disabled:cursor-not-allowed disabled:opacity-50">
                        <span v-if="form.processing">Joining...</span>
                        <span v-else>Join waitlist</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>
