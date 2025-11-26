<script setup lang="ts">
import { Empty, EmptyContent, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle, } from '@/components/ui/empty'
import { Button } from "@/components/ui/button"
import { Drawer, DrawerClose, DrawerContent, DrawerDescription, DrawerFooter, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer';
import { Input } from "@/components/ui/input"
import { Building2 } from 'lucide-vue-next';

import { useForm, usePage } from '@inertiajs/vue3'
import BusinessController from '@/actions/App/Http/Controllers/BusinessController';
import { email } from '@/routes/password';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner'
import { ref } from 'vue';

const isDrawerOpen = ref(false);
const page = usePage();
const newBusiness = useForm({
    name: '',
    email: '',
    team_size: '',
    description: '',
})

const createBusiness = () => {

    newBusiness.submit(BusinessController.store(), {
        onSuccess: () => {
            console.log(newBusiness);
        },
        // onFinish: () => newBusiness.reset(),
        onFinish: () => {
            const success = page.props.flash?.success
            if (success) {
                toast('Business Created', {
                    description: success,
                    action: {
                        label: 'Continue',
                        onClick: () => console.log('business created'),
                    }
                })
            }
            // isDrawerOpen.value = false
        }
    })
}
</script>

<template>
    <div class="">
        <div class="h-screen flex items-center justify-center">
            <Empty>
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <Building2 class="h-12 w-12" />
                    </EmptyMedia>
                    <EmptyTitle>
                        <h1 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
                            No Business
                        </h1>
                    </EmptyTitle>
                    <EmptyDescription>
                        <h4 class="scroll-m-20 text-xl font-semibold tracking-tight">
                            You do not Have a Business. Use the button below to create one.
                        </h4>
                    </EmptyDescription>
                </EmptyHeader>
                <EmptyContent>

                    <Drawer v-model:open="isDrawerOpen">
                        <DrawerTrigger class="hover:cursor-pointer">
                            <Button>
                                Create a team
                            </Button>
                        </DrawerTrigger>

                        <DrawerContent>
                            <div class="mx-auto w-full max-w-xl p-4">
                                <DrawerHeader class="p-0 pb-4 py-2">
                                    <DrawerTitle>Move Goal</DrawerTitle>
                                    <DrawerDescription>Set your daily activity goal.</DrawerDescription>
                                </DrawerHeader>

                                <div class="">
                                    <form @submit.prevent="createBusiness()" class="grid items-start gap-2">
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <Input id="name" v-model="newBusiness.name" type="text"
                                                    placeholder="Business name" />
                                                <InputError :message="newBusiness.errors.name" />
                                            </div>
                                            <div class="">
                                                <Input v-model="newBusiness.email" id="phone" type="email"
                                                    placeholder="Business email" />
                                                <InputError :message="newBusiness.errors.email" />

                                            </div>
                                        </div>
                                        <div class="grid gap-2">
                                            <select id="team_size" v-model="newBusiness.team_size" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm
                        focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]
                        dark:aria-invalid:ring-destructive/20 aria-invalid:border-destructive">
                                                <option value="" class="tex-xs text-muted-foreground" selected disabled>
                                                    Team Size</option>
                                                <option value="0-10">0-10</option>
                                                <option value="10-50">10-50</option>
                                                <option value="50-100">50-100</option>
                                            </select>
                                            <InputError :message="newBusiness.errors.team_size" />
                                            <div>

                                                <textarea v-model="newBusiness.description"
                                                    data-slot="input-group-control"
                                                    class="flex field-sizing-content min-h-16 w-full resize-none rounded-md bg-transparent px-3 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 border py-2.5 text-base transition-[color,box-shadow] outline-none md:text-sm"
                                                    placeholder="Business description..." />
                                                <InputError :message="newBusiness.errors.description" />
                                            </div>
                                        </div>

                                        <Button type="submit" class="">
                                            Create Business
                                        </Button>
                                    </form>
                                </div>

                                <DrawerFooter class="pt-2">
                                    <DrawerClose class="w-full">
                                        <Button variant="outline" class="w-full">
                                            Cancel
                                        </Button>
                                    </DrawerClose>
                                </DrawerFooter>
                            </div>
                        </DrawerContent>
                    </Drawer>
                </EmptyContent>
            </Empty>

        </div>
    </div>
</template>