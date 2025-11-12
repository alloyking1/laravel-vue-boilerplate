<script setup>
import BlogLayout from '../layout/BlogLayout.vue';

const posts = [
    {
        title: 'Blog Post 1',
        description: 'This is the first blog post sdlfksjdfklsjdfksdfd fjsld sdkjfsd lfkjdf lskdj fsdjk sjdkf ',
    },
    {
        title: 'Blog Post 2',
        description: 'This is the second blog post',
    },
    {
        title: 'Blog Post 2',
        description: 'This is the second blog post',
    },
]
</script>

<template>
    <div>
        <BlogLayout>
            <div class="max-w-7xl mx-auto">
                <div class="">
                    <div class="text-2xl font-bold p-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <!-- <h3 class="text-lg font-bold">Blog</h3> -->
                                <p class="text-gray-500">Stories, insights, and advice that will transform how you design and build for the web.</p>
                            </div>
                            <!-- <div class="col-span-1">
                                <button class="btn btn-primary">View All</button>
                            </div> -->
                        </div>
                    </div>
                    <hr>
                    <!-- <div  class="grid grid-cols-3 border"> -->
                    <div class="grid grid-cols-3 gap-6 py-2 pt-4">
                        <div v-for="post in posts" :key="post.id" class="card border border-gray-200 rounded">
                            <h3 class="text-lg font-bold">{{ post.title }}</h3>
                            <p class="text-gray-500">{{ post.description }}</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </BlogLayout>
    </div>
</template>