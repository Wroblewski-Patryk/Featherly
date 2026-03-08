<template>
    <div class="space-y-4">
        <div class="form-control">
            <label class="label"><span class="label-text text-xs opacity-50">Items</span></label>
            <div v-for="(item, i) in modelValue.items" :key="i" class="flex gap-2 mb-2">
                <input type="text" v-model="modelValue.items[i]" class="input input-sm input-bordered flex-1" />
                <button @click="modelValue.items.splice(i, 1)" class="btn btn-square btn-xs btn-ghost text-error">
                    <PhX weight="bold" class="w-3 h-3" />
                </button>
            </div>
            <button @click="modelValue.items.push('New item')" class="btn btn-sm btn-outline btn-block mt-2">Add Item</button>
        </div>
    </div>
</template>

<script setup>
import { PhX } from '@phosphor-icons/vue';

const props = defineProps({
    modelValue: {
        type: Object,
        required: true
    }
});
</script>
