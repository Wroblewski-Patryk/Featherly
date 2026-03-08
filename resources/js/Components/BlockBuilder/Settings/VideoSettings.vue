<template>
    <div class="space-y-3">
        <select v-model="modelValue.source" class="select select-bordered select-sm w-full">
            <option value="youtube">YouTube</option>
            <option value="vimeo">Vimeo</option>
            <option value="self">Self-Hosted</option>
        </select>
        <input type="text" v-model="modelValue.url" placeholder="Video URL" class="input input-sm input-bordered w-full" />
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
