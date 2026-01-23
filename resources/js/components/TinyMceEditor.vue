<script setup lang="ts">

import Editor from '@tinymce/tinymce-vue'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    body: String
})

const page = usePage();
const apiKey = page.props.tiny_api_key;
const id = 'tinymce-' + Math.random().toString(36).substring(2, 15);

const emit = defineEmits(['update:body']);

const content = computed({
    get: () => props.body,
    set: (val) => emit('update:body', val)
})

</script>

<template>
    <div>
        <main id="sample">
            <Editor :id="id" :apiKey="apiKey" v-model="content" :init="{
                plugins: 'advlist anchor autolink charmap code fullscreen help image insertdatetime link lists media preview searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                height: 500,
            }" />
        </main>
    </div>
</template>