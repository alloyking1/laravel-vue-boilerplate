<script setup lang="ts">
import BlogLayout from '../layout/BlogLayout.vue';
import { Input } from '../../../../../../resources/js/components/ui/input';
import { Label } from '../../../../../../resources/js/components/ui/label';
import { Textarea } from '../../../../../../resources/js/components/ui/textarea';
import { Checkbox } from '../../../../../../resources/js/components/ui/checkbox';
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue';
import { Button } from '../../../../../../resources/js/components/ui/button';
import { Spinner } from '../../../../../../resources/js/components/ui/spinner';

// const page = usePage();
// const apiKey = computed(() => page.props.tiny_api_key);

const props = defineProps({
    categories: {
        type: String,
    },
    tags: { type: String }
});

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
    body: '',
})

const setPostSlog = () => {
    blogPost.slog = blogPost.title.replaceAll(' ', '-');
}


</script>

<template>
    <div class="">
        <BlogLayout>
            <div class="max-w-7xl mx-auto">
                <div class="py-8">
                    <h1 class="text-2xl font-bold">Create Blog</h1>
                </div>
                <div class="">
                    <form action="">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="">
                                <Input @keyup="setPostSlog" id="title" type="text" v-model="blogPost.title"
                                    placeholder="Blog post title" />
                                <InputError :message="blogPost.title" />
                            </div>

                            <div class="">
                                <Input id="slog" type="text" v-model="blogPost.slog" placeholder="Blog post slog"
                                    disabled />
                                <InputError :message="blogPost.slog" />
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-4 mt-2">
                            <div>
                                <Input @keyup="setPostSlog" id="min_to_read" type="text" v-model="blogPost.min_to_read"
                                    placeholder="Minutes to read" />
                                <InputError :message="blogPost.min_to_read" />
                            </div>
                            <div>

                                <select id="team_size" v-model="blogPost.category" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm
                        focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]
                        dark:aria-invalid:ring-destructive/20 aria-invalid:border-destructive">
                                    <option value="" class="tex-xs text-muted-foreground" selected disabled>
                                        category
                                    </option>
                                    <option v-for="category in props.categories" :value="category.id">
                                        {{ category.title }}
                                    </option>
                                </select>
                                <InputError :message="blogPost.errors.category" />
                            </div>
                            <div>
                                <select id="team_size" v-model="blogPost.tag" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm
                        focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]
                        dark:aria-invalid:ring-destructive/20 aria-invalid:border-destructive">
                                    <option value="" class="tex-xs text-muted-foreground" selected disabled>
                                        Tag
                                    </option>
                                    <option v-for="tag in props.tags" value="tag.id">{{ tag.title }}</option>
                                </select>
                                <InputError :message="blogPost.errors.tag" />
                            </div>
                            <div>
                                <select id="team_size" v-model="blogPost.tag" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm
                        focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]
                        dark:aria-invalid:ring-destructive/20 aria-invalid:border-destructive">
                                    <option value="" class="tex-xs text-muted-foreground" selected disabled>
                                        Grade
                                    </option>
                                    <option value="0-10">0-10</option>
                                    <option value="10-50">10-50</option>
                                    <option value="50-100">50-100</option>
                                </select>
                                <InputError :message="blogPost.errors.tag" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1">
                            <div class="mt-2">
                                <Textarea placeholder="Blog excerpt..." />
                                <InputError :message="blogPost.excerpt" />
                            </div>
                        </div>


                        <div class="grid grid-cols-1 mt-2">
                            <Textarea placeholder="Blog excerpt..." />
                            <InputError :message="blogPost.excerpt" />
                        </div>

                        <div class="grid grid-cols-3 gap-4 mt-2">
                            <div>
                                <Input id="meta_description" type="text" v-model="blogPost.meta_description"
                                    placeholder="Meta description" />
                                <InputError :message="blogPost.meta_description" />
                            </div>
                            <div>
                                <Input id="meta_keywords" type="text" v-model="blogPost.meta_keywords"
                                    placeholder="Meta keywords" />
                                <InputError :message="blogPost.meta_keywords" />
                            </div>
                            <div>
                                <Input id="meta_robots" type="text" v-model="blogPost.meta_robots"
                                    placeholder="Meta Robots" />
                                <InputError :message="blogPost.meta_robots" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="flex justify-between">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <Checkbox id="publish" v-model="blogPost.is_published" />
                                        <Label for="publish">Publish post now?</Label>
                                    </div>
                                </div>
                                <div>
                                    <Button size="sm" variant="outline" disabled>
                                        <Spinner class="animate-spin" />
                                        Submit
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </BlogLayout>
    </div>
</template>