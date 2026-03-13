<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DynamicBlock from '@/Components/DynamicBlock.vue';
import SeoHead from '@/Components/SeoHead.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

const props = defineProps({
    page: Object,
    settings: Object,
    seo: Object,
    header: Object,
    footer: Object,
    sidebar: Object,
    page_template: Object,
});
</script>

<template>
    <SeoHead v-if="seo" v-bind="seo" />
    <AppLayout 
        :settings="props.settings" 
        :page="props.page" 
        :header="props.header" 
        :footer="props.footer" 
        :sidebar="props.sidebar" 
        :page_template="props.page_template"
    >

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
