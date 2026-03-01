<script setup>
import { computed, onMounted, ref } from 'vue';
import { useGsapRuntime } from '@/Composables/useGsapRuntime';

const props = defineProps({
    block: {
        type: Object,
        required: true
    }
});

const blockRef = ref(null);
const { animateBlock } = useGsapRuntime();

onMounted(() => {
    if (props.block.appearance?.animations?.enabled) {
        animateBlock(blockRef.value, props.block.appearance.animations);
    }
});

const styleObj = computed(() => {
    return {
        backgroundColor: props.block.appearance?.backgroundColor !== 'transparent' ? props.block.appearance?.backgroundColor : undefined,
        color: props.block.appearance?.textColor !== 'inherit' ? props.block.appearance?.textColor : undefined,
        paddingTop: props.block.appearance?.paddingTop,
        paddingBottom: props.block.appearance?.paddingBottom,
        marginTop: props.block.appearance?.marginTop,
        marginBottom: props.block.appearance?.marginBottom,
        fontSize: props.block.appearance?.fontSize,
        fontWeight: props.block.appearance?.fontWeight,
        textAlign: props.block.appearance?.textAlign,
        borderRadius: props.block.appearance?.borderRadius,
        borderWidth: props.block.appearance?.borderWidth,
        borderStyle: props.block.appearance?.borderWidth ? 'solid' : undefined,
        borderColor: props.block.appearance?.borderColor,
        boxShadow: props.block.appearance?.boxShadow,
    };
});
</script>

<template>
    <div ref="blockRef" :class="[block.appearance?.customClasses]" :style="styleObj">
        <!-- Hero Block -->
        <div v-if="block.type === 'hero'" class="py-20 px-10 text-center">
            <h1 class="text-5xl font-bold mb-4">{{ block.content.headline || 'Your Headline Here' }}</h1>
            <p class="text-xl opacity-90 leading-relaxed">{{ block.content.subheadline || 'Provide a compelling subheadline that captures attention.' }}</p>
            <button v-if="block.content.buttonText" class="btn btn-primary mt-6">{{ block.content.buttonText }}</button>
        </div>

        <!-- Heading Block -->
        <div v-else-if="block.type === 'heading'" class="py-4">
            <component :is="block.content.level || 'h2'" 
                       :class="['font-bold', block.content.level === 'h1' ? 'text-6xl' : 'text-4xl']">
                {{ block.content.text || 'Your Heading Here' }}
            </component>
        </div>

        <!-- Text Block -->
        <div v-else-if="block.type === 'text'" class="prose prose-lg max-w-none p-8" v-html="block.content.text || '<p>Start typing your content here...</p>'"></div>

        <!-- Columns Block -->
        <div v-else-if="block.type === 'columns'" class="grid gap-8 p-8" :class="[`grid-cols-${block.content.columns || 2}`]">
            <div v-for="(col, idx) in block.content.data" :key="idx" class="flex flex-col gap-4">
                <DynamicBlock v-for="subBlock in col.blocks" :key="subBlock.id" :block="subBlock" />
            </div>
            <!-- Empty state for columns if no data -->
            <div v-if="!block.content.data || block.content.data.length === 0" class="col-span-full border-2 border-dashed border-base-300 p-8 text-center opacity-50">
                Columns Placeholder (Add elements in sidebar)
            </div>
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
