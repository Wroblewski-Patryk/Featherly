<template>
    <div class="space-y-4">
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Text</span></label>
            <input type="text" v-model="modelValue.text" class="input input-bordered w-full" />
        </div>
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Level</span></label>
            <div class="join w-full">
                <button v-for="h in [1,2,3,4,5,6]" :key="h" 
                        @click="modelValue.level = h"
                        class="btn btn-xs join-item flex-1"
                        :class="modelValue.level === h ? 'btn-primary' : ''">H{{h}}</button>
            </div>
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
