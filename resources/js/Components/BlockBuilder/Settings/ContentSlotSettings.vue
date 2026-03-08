<template>
    <div class="space-y-3">
        <label class="label"><span class="label-text text-xs opacity-50">Slot Label</span></label>
        <input type="text" v-model="modelValue.label" placeholder="e.g. Page Content" class="input input-sm input-bordered w-full" />
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
