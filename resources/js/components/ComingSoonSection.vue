<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { toast } from 'vue-sonner';
import InputError from '@/components/InputError.vue';

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
    <section id="waitlist" class="mx-auto w-full max-w-6xl px-6 pb-16 pt-8">
        <div class="rounded-3xl border border-black/10 bg-white p-8">
            <div class="grid gap-8 lg:grid-cols-[1fr_1fr]">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-black/50">Waiting list</p>
                    <h2 class="mt-4 text-3xl font-semibold">Be first to experience Payzora.</h2>
                    <p class="mt-3 text-sm text-black/60">
                        Share what you need most and help us shape the product for ecommerce founders.
                    </p>
                    <p v-if="form.recentlySuccessful" class="mt-4 text-sm font-semibold text-black">
                        Thanks! You're on the list.
                    </p>
                </div>
                <form class="grid gap-4" @submit.prevent="submit">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/50">Name</label>
                        <input v-model="form.name" type="text" placeholder="Jane Doe"
                            class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/50">Email</label>
                        <input v-model="form.email" type="email" placeholder="you@brand.com"
                            class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm" />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-widest text-black/50">Suggest a
                            feature</label>
                        <input v-model="form.feature_suggestion" type="text" placeholder="Automated profit reports"
                            class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm" />
                        <InputError :message="form.errors.feature_suggestion" />
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-widest text-black/50">Would you
                                pay?</label>
                            <select v-model="form.would_pay"
                                class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm">
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
                                class="mt-2 w-full rounded-xl border border-black/10 px-3 py-2 text-sm disabled:bg-black/5" />
                            <InputError :message="form.errors.price_point" />
                        </div>
                    </div>
                    <button
                        class="mt-2 rounded-full border border-black bg-black px-6 py-3 text-sm font-semibold text-white hover:bg-black/90">
                        Join waitlist
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>
