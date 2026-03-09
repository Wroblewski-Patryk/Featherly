<template>
    <div class="space-y-6">
        <div class="form-control">
            <label class="label"><span class="label-text text-[10px] uppercase font-bold opacity-50">Content</span></label>
            <textarea v-model="modelValue.text" class="textarea textarea-bordered h-48 w-full focus:border-primary transition-all"></textarea>
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
