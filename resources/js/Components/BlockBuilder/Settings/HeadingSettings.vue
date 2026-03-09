<template>
    <div class="space-y-6">
        <div class="form-control">
            <label class="label"><span class="label-text text-[10px] uppercase font-bold opacity-50">Heading Text</span></label>
            <textarea v-model="modelValue.text" class="textarea textarea-bordered h-20 w-full font-bold focus:border-primary transition-all"></textarea>
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text text-[10px] uppercase font-bold opacity-50">Level</span></label>
            <div class="join w-full bg-base-300/50 p-1 rounded-lg">
                <button v-for="h in [1,2,3,4,5,6]" :key="h" 
                        @click="modelValue.level = h"
                        class="btn btn-xs join-item flex-1 border-none transition-all"
                        :class="modelValue.level === h ? 'btn-primary shadow-lg' : 'btn-ghost opacity-50 hover:opacity-100'">H{{h}}</button>
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
