<template>
    <div class="space-y-3">
        <label class="label"><span class="label-text text-xs opacity-50">Select Template Part</span></label>
        <select v-model="modelValue.template_id" class="select select-bordered select-sm w-full">
            <option :value="null">None</option>
            <option v-for="t in templates" :key="t.id" :value="t.id">
                {{ t.name }} ({{ t.type }})
            </option>
        </select>
        <p class="text-[10px] opacity-40 italic">Note: Only headers, footers, and sidebars should be referenced here.</p>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: Object,
        required: true
    },
    templates: {
        type: Array,
        default: () => []
    }
});
</script>
