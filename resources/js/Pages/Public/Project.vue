<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DynamicBlock from '@/Components/DynamicBlock.vue';
import { useTranslations } from '@/Composables/useTranslations';

const props = defineProps({
    project: Object,
    settings: Object
});

const { t } = useTranslations();
</script>

<template>
    <AppLayout :settings="settings">
        <Head :title="t(project.title)" />
        
        <div class="max-w-7xl mx-auto px-6 py-24">
            <div class="mb-12">
                <span class="text-sm font-bold uppercase tracking-widest text-primary mb-4 block">{{ t(project.category) }}</span>
                <h1 class="text-6xl md:text-8xl font-black italic uppercase tracking-tighter mb-8 leading-none">
                    {{ t(project.title) }}
                </h1>
                <p v-if="project.description" class="text-xl opacity-60 max-w-2xl leading-relaxed">
                    {{ t(project.description) }}
                </p>
            </div>

            <div v-if="project.content" class="project-content space-y-8">
                <DynamicBlock 
                    v-for="block in project.content" 
                    :key="block.id" 
                    :block="block" 
                />
            </div>
            
            <div v-if="!project.content && project.image" class="rounded-3xl overflow-hidden shadow-2xl">
                <img :src="project.image" class="w-full" />
            </div>
        </div>
    </AppLayout>
</template>
