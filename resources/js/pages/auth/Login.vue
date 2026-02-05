<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <AuthBase title="Log in to your account" description="Enter your email and password below to log in">

        <Head title="Log in" />

        <div v-if="status"
            class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-center text-sm font-medium text-green-900">
            {{ status }}
        </div>

        <Form v-bind="AuthenticatedSessionController.store.form()" :reset-on-success="['password']"
            v-slot="{ errors, processing }" class="space-y-6">
            <div class="space-y-5">
                <div class="space-y-2">
                    <Label for="email" class="text-sm font-semibold">Email address</Label>
                    <Input id="email" type="email" name="email" required autofocus :tabindex="1" autocomplete="email"
                        placeholder="you@example.com"
                        class="h-11 rounded-xl border-black/10 transition-all focus:border-black focus:ring-2 focus:ring-black/5" />
                    <InputError :message="errors.email" />
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="text-sm font-semibold">Password</Label>
                        <TextLink v-if="canResetPassword" :href="request()"
                            class="text-xs font-medium text-black/60 hover:text-black" :tabindex="5">
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input id="password" type="password" name="password" required :tabindex="2"
                        autocomplete="current-password" placeholder="Enter your password"
                        class="h-11 rounded-xl border-black/10 transition-all focus:border-black focus:ring-2 focus:ring-black/5" />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center">
                    <Label for="remember" class="flex cursor-pointer items-center gap-2">
                        <Checkbox id="remember" name="remember" :tabindex="3" class="rounded-md" />
                        <span class="text-sm text-black/70">Remember me for 30 days</span>
                    </Label>
                </div>

                <Button type="submit"
                    class="h-12 w-full rounded-xl bg-black text-sm font-semibold transition-all hover:scale-[1.02] hover:bg-black/90"
                    :tabindex="4" :disabled="processing" data-test="login-button">
                    <LoaderCircle v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                    <span v-if="processing">Logging in...</span>
                    <span v-else>Log in</span>
                </Button>
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-black/10"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-white px-2 text-black/50">or</span>
                </div>
            </div>

            <div class="text-center">
                <span class="text-sm text-black/60">Don't have an account? </span>
                <TextLink :href="register()" :tabindex="5" class="text-sm font-semibold text-black hover:underline">
                    Sign up for free
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>
