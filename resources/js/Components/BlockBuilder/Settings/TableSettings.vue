<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <label class="text-[10px] opacity-40 uppercase font-black">Table Layout</label>
            <div class="join">
                <button @click="modelValue.rows.forEach(r => r.push(''))" class="btn btn-xs join-item btn-ghost bg-base-200 hover:bg-base-300 px-3" title="Add Column">+ Col</button>
                <button @click="modelValue.rows.forEach(r => { if(r.length > 1) r.pop() })" class="btn btn-xs join-item btn-ghost bg-base-200 hover:bg-base-300 px-3" title="Remove Last Column">- Col</button>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <div v-for="(row, rIdx) in modelValue.rows" :key="rIdx" class="flex gap-2 items-center bg-base-200 p-2 rounded-box overflow-hidden">
                <div class="flex gap-2 flex-1 overflow-x-auto custom-scrollbar pb-1">
                    <input v-for="(cell, cIdx) in row" :key="cIdx" type="text" v-model="modelValue.rows[rIdx][cIdx]" class="input input-xs input-bordered min-w-[80px] flex-1" />
                </div>
                <button @click="modelValue.rows.splice(rIdx, 1)" class="btn btn-square btn-xs btn-ghost text-error shrink-0" :disabled="modelValue.rows.length <= 1" title="Remove Row">
                    <PhTrash weight="bold" class="w-3 h-3" />
                </button>
            </div>
        </div>
        
        <button @click="modelValue.rows.push(new Array(modelValue.rows[0].length).fill(''))" class="btn btn-xs btn-outline btn-block border-dashed border-base-content/20">
            <PhPlus weight="bold" class="w-3 h-3 mr-2" />Add Row
        </button>
    </div>
</template>

<script setup>
import { PhTrash, PhPlus } from '@phosphor-icons/vue';

const props = defineProps({
    modelValue: {
        type: Object,
        required: true
    }
});
</script>
