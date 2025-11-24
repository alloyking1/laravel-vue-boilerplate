<script setup lang="ts">
import BlogLayout from '../layout/BlogLayout.vue';
import {Input}  from '../../../../../../resources/js/components/ui/input';
import { Label } from '../../../../../../resources/js/components/ui/label';
import { useForm, usePage } from '@inertiajs/vue3'

const blogPost = useForm({
    title: '',
    slog: '',
    excerpt: '',
    min_to_read: '',
    category: '',
    tag: '',
    is_published: '',
    meta_description: '',
    meta_keywords: '',
    meta_robots: '',
    grade: '',
})

const setPostSlog = () => {
    blogPost.slog = blogPost.title.replaceAll(' ', '-');
    console.log(slog);
}

</script>

<template>
     <div class="">
        <BlogLayout>
            <div class="max-w-7xl mx-auto">
                <div class="p-8">
                    <h1 class="text-2xl font-bold">Create Blog</h1>
                </div>
                <div>
                    <form action="">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="">
                                <Input @keyup="setPostSlog" id="title" type="text" v-model="blogPost.title" placeholder="Blog post title" />
                                <InputError :message="blogPost.title" />
                            </div>

                            <div class="">
                                <Input id="slog" type="text" v-model="blogPost.slog" placeholder="Blog post slog" disabled />
                                <InputError :message="blogPost.slog" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <Input @keyup="setPostSlog" id="min_to_read" type="text" v-model="blogPost.min_to_read" placeholder="min_to_read" />
                                <InputError :message="blogPost.min_to_read" />
                            </div>
                            <div>
                                <select name="" id="" class="border">
                                    <option value="">sdfsdfsdfs</option>
                                </select>
                                <!-- <Input @keyup="setPostSlog" id="category" type="text" v-model="blogPost.category" placeholder="category" />
                                <InputError :message="blogPost.category" /> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </BlogLayout>
    </div>
</template>