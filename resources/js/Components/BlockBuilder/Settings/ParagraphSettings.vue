<template>
    <div class="space-y-4">
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Content</span></label>
            <textarea v-model="modelValue.text" class="textarea textarea-bordered h-32 w-full"></textarea>
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
