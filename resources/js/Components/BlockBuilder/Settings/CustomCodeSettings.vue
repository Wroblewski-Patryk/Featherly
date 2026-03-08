<template>
    <div class="space-y-4">
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50 font-mono">HTML</span></label>
            <textarea v-model="modelValue.html" class="textarea textarea-bordered h-48 w-full font-mono text-xs"></textarea>
        </div>
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50 font-mono">JS (Executed on mount)</span></label>
            <textarea v-model="modelValue.js" class="textarea textarea-bordered h-32 w-full font-mono text-xs"></textarea>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: Object,
        required: true
    }
});
</script>
