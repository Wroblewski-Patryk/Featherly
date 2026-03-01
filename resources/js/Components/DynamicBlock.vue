<script setup>
import { computed } from 'vue';

const props = defineProps({
    block: {
        type: Object,
        required: true
    }
});

const styleObj = computed(() => {
    return {
        backgroundColor: props.block.appearance?.backgroundColor !== 'transparent' ? props.block.appearance?.backgroundColor : undefined,
        color: props.block.appearance?.textColor !== 'inherit' ? props.block.appearance?.textColor : undefined,
    };
});
</script>

<template>
    <div :class="[block.appearance?.customClasses]" :style="styleObj">
        <!-- Hero Block -->
        <div v-if="block.type === 'hero'" class="hero min-h-[400px]">
            <div class="hero-content text-center">
                <div class="max-w-md">
                    <h1 class="text-5xl font-bold">{{ block.content.headline || 'Your Headline Here' }}</h1>
                    <p class="py-6">{{ block.content.subheadline || 'Provide a compelling subheadline that captures attention.' }}</p>
                    <button class="btn btn-primary">Get Started</button>
                </div>
            </div>
        </div>

        <!-- Text Block -->
        <div v-else-if="block.type === 'text'" class="prose max-w-none p-8">
            <template v-if="block.content.text">
                <div v-html="block.content.text"></div>
            </template>
            <template v-else>
                <p>Start typing your content here...</p>
            </template>
        </div>

        <!-- Image Block -->
        <div v-else-if="block.type === 'image'" class="flex justify-center p-8">
            <template v-if="block.content.url">
                <img :src="block.content.url" :alt="block.content.alt" class="max-w-full rounded-box shadow-xl" />
            </template>
            <template v-else>
                <div class="w-full max-w-lg aspect-video bg-base-300 rounded-box flex items-center justify-center text-base-content/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            </template>
        </div>
        
        <!-- Fallback Block -->
        <div v-else class="p-8 text-center text-error border border-error bg-error/10 m-4 rounded">
            Unknown block type: {{ block.type }}
        </div>
    </div>
</template>
