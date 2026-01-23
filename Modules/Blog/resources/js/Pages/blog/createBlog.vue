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
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '../../../../../../resources/js/components/ui/select'
import PostController from '../../../../../../resources/js/actions/Modules/Blog/Http/Controllers/PostController';
import InputError from '../../../../../../resources/js/components/InputError.vue';
import Editor from '../../../../../../resources/js/components/TinyMceEditor.vue';
import { Edit } from 'lucide-vue-next';
import { toast } from 'vue-sonner'

const page = usePage();
const props = defineProps({
    categories: { type: String },
    tags: { type: String },
    postGradeEnum: { type: String },
});

const blogPost = useForm({
    title: '',
    slug: '',
    excerpt: '',
    min_to_read: '',
    category: '',
    tag: [] as number[],
    is_published: false,
    meta_description: '',
    meta_keyword: '',
    meta_robot: '',
    grade: '',
    body: '',
})

const setPostSlug = () => {
    blogPost.slug = blogPost.title.toLowerCase().replaceAll(' ', '-');
}

const submit = () => {
    console.log(blogPost);
    blogPost.post(PostController.store(), {
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
                blogPost.reset();
            }
        }
    });
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
                                <Input @keyup="setPostSlug" id="title" type="text" v-model="blogPost.title"
                                    placeholder="Blog post title" />
                                <InputError :message="blogPost.errors.title" />
                            </div>

                            <div class="">
                                <Input id="slug" type="text" v-model="blogPost.slug" placeholder="Blog post slug"
                                    disabled />
                                <InputError :message="blogPost.errors.slug" />
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-4 mt-2">
                            <div>
                                <Input id="min_to_read" type="number" v-model="blogPost.min_to_read"
                                    placeholder="Minutes to read" />
                                <InputError :message="blogPost.errors.min_to_read" />
                            </div>
                            <div>

                                <select id="team_size" v-model="blogPost.category" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm
                        focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]
                        dark:aria-invalid:ring-destructive/20 aria-invalid:border-destructive">
                                    <option value="" class="tex-xs text-muted-foreground" selected disabled>
                                        Category
                                    </option>
                                    <option v-for="category in props.categories" :value="category.id">
                                        {{ category.title }}
                                    </option>
                                </select>
                                <InputError :message="blogPost.errors.category" />
                            </div>

                            <div>
                                <Select multiple class="" v-model="blogPost.tag">
                                    <SelectTrigger class="">
                                        <SelectValue placeholder="Tags (Multiple select)" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Tags</SelectLabel>
                                            <SelectItem v-for="tag in props.tags" :value="tag.id">
                                                {{ tag.title }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="blogPost.errors.tag" />
                            </div>


                            <div>
                                <select id="grade" v-model="blogPost.grade" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm
                        focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]
                        dark:aria-invalid:ring-destructive/20 aria-invalid:border-destructive">
                                    <option value="" class="tex-xs text-muted-foreground" selected disabled>
                                        Grade
                                    </option>
                                    <option v-for="grade in props.postGradeEnum" :key="grade" :value="grade">
                                        {{ grade }}
                                    </option>
                                </select>
                                <InputError :message="blogPost.errors.grade" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1">
                            <div class="mt-2">
                                <Textarea v-model="blogPost.excerpt" placeholder="Blog excerpt..." />
                                <InputError :message="blogPost.errors.excerpt" />
                            </div>
                        </div>


                        <div class="grid grid-cols-1 mt-2">
                            <Editor v-model:body="blogPost.body" />
                            <InputError :message="blogPost.errors.body" />
                        </div>

                        <div class="grid grid-cols-3 gap-4 mt-2">
                            <div>
                                <Input id="meta_description" type="text" v-model="blogPost.meta_description"
                                    placeholder="Meta description" />
                                <InputError :message="blogPost.errors.meta_description" />
                            </div>
                            <div>
                                <Input id="meta_keywords" type="text" v-model="blogPost.meta_keyword"
                                    placeholder="Meta keywords" />
                                <InputError :message="blogPost.errors.meta_keyword" />
                            </div>
                            <div>
                                <Input id="meta_robots" type="text" v-model="blogPost.meta_robot"
                                    placeholder="Meta Robots" />
                                <InputError :message="blogPost.errors.meta_robot" />
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
                                    <Button @click="submit" :disabled="blogPost.processing" size="sm" variant="outline"
                                        type="button">
                                        <Spinner v-if="blogPost.processing" class="animate-spin mr-2" />
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