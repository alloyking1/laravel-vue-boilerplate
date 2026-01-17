<script setup lang="ts">
import BlogLayout from '../layout/BlogLayout.vue';
import { Input } from '../../../../../../resources/js/components/ui/input';
import { Label } from '../../../../../../resources/js/components/ui/label';
import { useForm, usePage, router } from '@inertiajs/vue3'
import { Button } from '../../../../../../resources/js/components/ui/button';
import { Spinner } from '../../../../../../resources/js/components/ui/spinner';
import InputError from '../../../../../../resources/js/components/InputError.vue';
import { toast } from 'vue-sonner'
import PostTagController from '../../../../../../resources/js/actions/Modules/Blog/Http/Controllers/PostTagController';
import { Table, TableBody, TableCaption, TableCell, TableFooter, TableHead, TableHeader, TableRow, } from '../../../../../../resources/js/components/ui/table';
import { onMounted } from 'vue';
import { Pencil, Trash } from 'lucide-vue-next';
import { Drawer, DrawerClose, DrawerContent, DrawerDescription, DrawerFooter, DrawerHeader, DrawerTitle, DrawerTrigger } from '../../../../../../resources/js/components/ui/drawer';
import { ref } from 'vue';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '../../../../../../resources/js/components/ui/alert-dialog';

const isDrawerOpen = ref(false);
const props = defineProps({
    tags: {
        type: String,
    },
});

const tag = useForm({
    title: '',
    id: '',
});
const page = usePage();

const submit = () => {
    tag.post(PostTagController.store(), {
        onSuccess: () => {
            const success = page.props.flash?.success
            if (success) {
                toast('Success', {
                    description: success,
                    action: {
                        label: 'Continue',
                        onClick: () => { },
                    }
                });
                tag.reset();
                isDrawerOpen.value = false
            }
        }
    });
}

const deleteTag = (id) => {
    router.post(PostTagController.delete(id), {
        onSuccess: () => {
            const success = page.props.flash?.success
            if (success) {
                toast('Success', {
                    description: success,
                    action: {
                        label: 'Continue',
                        onClick: () => { },
                    }
                });
            }
        }
    });
}

const editTag = (id, title) => {
    isDrawerOpen.value = !isDrawerOpen.value;
    tag.title = title
    tag.id = id
}
</script>

<template>
    <div>
        <BlogLayout>
            <div class="flex justify-end">
                <Drawer v-model:open="isDrawerOpen">
                    <DrawerTrigger class="hover:cursor-pointer">
                        <div class="pt-12">
                            <Button>
                                Create a tag
                            </Button>
                        </div>
                    </DrawerTrigger>

                    <DrawerContent>
                        <div class="mx-auto w-full max-w-xl p-4">
                            <DrawerHeader class="p-0 pb-4 py-2">
                                <DrawerTitle>Create a new Tag</DrawerTitle>
                                <DrawerDescription>Use the form below to create a new tag for blog posts.
                                </DrawerDescription>
                            </DrawerHeader>

                            <div class="">
                                <form action="" @submit.prevent="submit">
                                    <div class="flex gap-2">
                                        <div class="w-full">
                                            <Input id="title" type="text" v-model="tag.title" placeholder="Tag title" />
                                            <InputError :message="tag.errors.title" />
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <DrawerFooter class="pt-2">
                                <div>
                                    <Button @click="submit" size="sm" variant="outline"
                                        class="hover:cursor-pointer w-full">
                                        <Spinner class="animate-spin" />
                                        Submit
                                    </Button>
                                </div>
                                <DrawerClose class="w-full">
                                    <Button variant="outline" class="w-full">
                                        Cancel
                                    </Button>
                                </DrawerClose>
                            </DrawerFooter>
                        </div>
                    </DrawerContent>
                </Drawer>
            </div>

            <div class="mt-12">
                <div>
                    <div class="py-8">
                        <h1 class="text-2xl font-bold">Tags List</h1>
                        <p>
                            A list of tags already created
                        </p>
                    </div>
                </div>

                <Table>
                    <TableCaption>A list of tags</TableCaption>
                    <TableHeader>
                        <!-- <TableRow>
                            <TableHead class="">
                                Tag Name
                            </TableHead>
                            <TableHead class="">Modify</TableHead>
                        </TableRow> -->
                    </TableHeader>
                    <TableBody class="">
                        <TableRow v-for="tag in props.tags" :key="tag.id" class="">
                            <div class="flex justify-between">
                                <TableCell class=" font-medium">
                                    {{ tag.title }}
                                </TableCell>

                                <TableCell class="text-right">
                                    <div class="flex">
                                        <Button size="sm" variant="outline" @click="editTag(tag.id, tag.title)"
                                            class="hover:cursor-pointer rounded-full shadow">
                                            <Pencil class="" />
                                        </Button>
                                        <div>
                                            <AlertDialog>
                                                <AlertDialogTrigger>
                                                    <Button size="sm" variant="outline"
                                                        class="hover:cursor-pointer rounded-full shadow">
                                                        <Trash />
                                                    </Button>
                                                </AlertDialogTrigger>
                                                <AlertDialogContent>
                                                    <AlertDialogHeader>
                                                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                                                        <AlertDialogDescription>
                                                            This action cannot be undone. This will permanently delete
                                                            this
                                                            tag
                                                            and remove any record of it from your blog.
                                                        </AlertDialogDescription>
                                                    </AlertDialogHeader>
                                                    <AlertDialogFooter>
                                                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                                                        <AlertDialogAction @click="deleteTag(tag.id)">Continue
                                                        </AlertDialogAction>
                                                    </AlertDialogFooter>
                                                </AlertDialogContent>
                                            </AlertDialog>
                                        </div>
                                    </div>
                                </TableCell>
                            </div>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </BlogLayout>
    </div>
</template>