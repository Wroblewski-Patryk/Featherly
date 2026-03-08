<template>
    <div class="space-y-4">
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Quote Text</span></label>
            <textarea v-model="modelValue.text" class="textarea textarea-bordered h-24 w-full"></textarea>
        </div>
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Author</span></label>
            <input type="text" v-model="modelValue.author" class="input input-bordered w-full" />
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
