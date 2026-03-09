<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DynamicBlock from '@/Components/DynamicBlock.vue';
import { useTranslations } from '@/Composables/useTranslations';

const props = defineProps({
    page: Object,
    settings: Object
});

const { t } = useTranslations();
</script>

<template>
    <AppLayout :settings="settings">
        <Head v-if="page">
            <title>{{ t(page.title) }}</title>
            <meta name="description" :content="t(page.meta_description)">
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
