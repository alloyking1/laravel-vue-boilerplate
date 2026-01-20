<script setup lang="ts">

import Editor from '@tinymce/tinymce-vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage();
const apiKey = page.props.tiny_api_key;

</script>

<template>
    <div>
        <main id="sample">
            <Editor id="<uid>" :apiKey="apiKey" :init="{
                plugins: 'advlist anchor autolink charmap code fullscreen help image insertdatetime link lists media preview searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                height: 500,
            }" />
        </main>
    </div>
</template>