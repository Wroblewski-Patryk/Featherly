<template>
    <div class="space-y-4">
        <div v-if="type === 'spacer'" class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Height</span></label>
            <select v-model="modelValue.height" class="select select-bordered select-sm w-full">
                <option value="py-5">X-Small</option>
                <option value="py-10">Small</option>
                <option value="py-20">Medium</option>
                <option value="py-40">Large</option>
                <option value="py-60">X-Large</option>
            </select>
        </div>
        <div v-if="type === 'divider'" class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Style</span></label>
            <select v-model="modelValue.style" class="select select-bordered select-sm w-full">
                <option value="solid">Solid</option>
                <option value="dashed">Dashed</option>
                <option value="dotted">Dotted</option>
            </select>
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
