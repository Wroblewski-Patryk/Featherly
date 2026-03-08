<template>
    <div class="space-y-4">
        <div v-if="['posts_list', 'projects_list'].includes(type)" class="space-y-3">
            <label class="label"><span class="label-text text-xs opacity-50">Items count to display</span></label>
            <input type="number" v-model="modelValue.count" class="input input-sm input-bordered w-full" />
            <label class="label mt-2"><span class="label-text text-xs opacity-50">Display Layout</span></label>
            <select v-model="modelValue.layout" class="select select-bordered select-sm w-full">
                <option value="grid">Grid Layout</option>
                <option value="list">List Layout (Stacked)</option>
            </select>
        </div>
        
        <div v-if="type === 'text_rotate'" class="space-y-3">
            <input type="text" v-model="modelValue.prefix" placeholder="Prefix" class="input input-sm input-bordered w-full" />
            <textarea v-model="modelValue.words" placeholder="Words (one per line)" class="textarea textarea-sm textarea-bordered w-full"></textarea>
            <input type="text" v-model="modelValue.suffix" placeholder="Suffix" class="input input-sm input-bordered w-full" />
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
