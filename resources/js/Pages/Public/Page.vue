<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DynamicBlock from '@/Components/DynamicBlock.vue';

const props = defineProps({
    page: Object,
    settings: Object
});
</script>

<template>
    <AppLayout :settings="settings">
        <Head>
            <title>{{ page.title[Object.keys(page.title)[0]] }}</title>
            <meta name="description" :content="page.meta_description?.[Object.keys(page.meta_description)[0]]">
        </Head>

        <div v-if="page.content" class="page-content">
            <DynamicBlock 
                v-for="block in page.content" 
                :key="block.id" 
                :block="block" 
            />
        </div>
        <div v-else class="py-20 text-center text-base-content/50">
            <p>This page has no content yet.</p>
        </div>
    </AppLayout>
</template>
