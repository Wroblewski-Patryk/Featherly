<template>
    <div class="space-y-3">
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Image URL</span></label>
            <input type="text" v-model="modelValue.url" class="input input-bordered w-full font-mono text-xs" />
        </div>
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Alt Text</span></label>
            <input type="text" v-model="modelValue.alt" class="input input-bordered w-full" />
        </div>
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Caption</span></label>
            <input type="text" v-model="modelValue.caption" class="input input-bordered w-full" />
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
