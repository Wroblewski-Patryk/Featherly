<template>
    <div class="space-y-3">
        <input v-if="['text_input', 'textarea', 'select', 'checkbox', 'radio', 'toggle', 'file_input'].includes(type)" 
               type="text" v-model="modelValue.label" placeholder="Label" class="input input-sm input-bordered w-full font-bold" />
        
        <input v-if="['text_input', 'textarea'].includes(type)" 
               type="text" v-model="modelValue.placeholder" placeholder="Placeholder" class="input input-sm input-bordered w-full" />
        
        <textarea v-if="type === 'select'" 
                  v-model="modelValue.options" placeholder="Options (one per line)" class="textarea textarea-sm textarea-bordered w-full"></textarea>
                  
        <input v-if="['checkbox', 'toggle'].includes(type)" 
               type="checkbox" v-model="modelValue.checked" class="toggle toggle-primary toggle-sm" />

        <input v-if="type === 'radio'" type="text" v-model="modelValue.group" placeholder="Radio Group Name" class="input input-sm input-bordered w-full" />       

        <div v-if="['range', 'rating'].includes(type)" class="space-y-2">
            <label class="label"><span class="label-text text-xs opacity-50">Current Value: {{ modelValue.val }}</span></label>
            <input type="range" v-model="modelValue.val" :min="modelValue.min || 1" :max="modelValue.max || 100" class="range range-xs" />
            <div class="grid grid-cols-2 gap-2 mt-2" v-if="type === 'range'">
                <input type="number" v-model="modelValue.min" placeholder="Min" class="input input-xs input-bordered w-full" />
                <input type="number" v-model="modelValue.max" placeholder="Max" class="input input-xs input-bordered w-full" />
            </div>
            <div class="form-control mt-2" v-if="type === 'rating'">
                <input type="number" v-model="modelValue.max" placeholder="Max Stars" class="input input-xs input-bordered w-full" max="10" />
            </div>
        </div>
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
