<template>
    <div class="space-y-4">
        <input v-if="['mockup_browser', 'mockup_phone'].includes(type)" 
               type="text" v-model="modelValue.url" :placeholder="type === 'mockup_browser' ? 'Browser URL' : 'Image URL'" class="input input-sm input-bordered w-full font-mono text-xs" />
        
        <textarea v-if="['mockup_browser', 'mockup_window'].includes(type)" 
                  v-model="modelValue.content" placeholder="Content text" class="textarea textarea-sm textarea-bordered w-full"></textarea>

        <textarea v-if="type === 'mockup_code'" 
                  v-model="modelValue.code" placeholder="Code snippet" class="textarea textarea-sm textarea-bordered w-full font-mono text-xs bg-base-300 text-success leading-relaxed"></textarea>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: Object,
        required: true
    },
    type: {
        type: String,
        required: true
    }
});
</script>
