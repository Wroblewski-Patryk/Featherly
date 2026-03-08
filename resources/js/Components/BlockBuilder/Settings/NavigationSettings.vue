<template>
    <div class="space-y-4">
        <div v-if="type === 'tabs'" class="space-y-3">
            <div v-for="(t, idx) in modelValue.tabs" :key="idx" class="p-2 bg-base-200 rounded-lg">
                <input type="text" v-model="t.title" placeholder="Tab Title" class="input input-xs input-bordered w-full mb-1 font-bold" />
                <textarea v-model="t.content" placeholder="Tab Content" class="textarea textarea-xs textarea-bordered w-full"></textarea>
            </div>
            <button @click="modelValue.tabs.push({title:'New Tab', content:''})" class="btn btn-xs btn-outline btn-block">Add Tab</button>
        </div>
        
        <div v-if="['breadcrumbs', 'menu', 'steps'].includes(type)" class="space-y-3">
            <label class="text-[10px] opacity-40 uppercase font-black">List Items</label>
            <div v-for="(item, idx) in modelValue.items" :key="idx" class="flex gap-2">
                 <input type="text" v-model="modelValue.items[idx]" class="input input-xs input-bordered flex-1" />
                 <button @click="modelValue.items.splice(idx, 1)" class="btn btn-xs btn-error btn-ghost"><PhX weight="bold" class="w-3 h-3" /></button>
            </div>
            <button @click="modelValue.items.push('New Item')" class="btn btn-xs btn-outline btn-block">Add Item</button>
        </div>

        <div v-if="type === 'navbar'" class="space-y-3">
            <input type="text" v-model="modelValue.title" placeholder="Brand Title" class="input input-sm input-bordered w-full font-bold" />
            <input type="text" v-model="modelValue.actionButton" placeholder="Action Button Text" class="input input-sm input-bordered w-full" />
            <label class="text-[10px] opacity-40 uppercase font-black mt-2 block">Links</label>
            <div v-for="(link, idx) in modelValue.links" :key="idx" class="flex gap-2">
                 <input type="text" v-model="modelValue.links[idx]" class="input input-xs input-bordered flex-1" />
                 <button @click="modelValue.links.splice(idx, 1)" class="btn btn-xs btn-error btn-ghost"><PhX weight="bold" class="w-3 h-3" /></button>
            </div>
            <button @click="modelValue.links.push('New Link')" class="btn btn-xs btn-outline btn-block">Add Link</button>
        </div>
    </div>
</template>

<script setup>
import { PhX } from '@phosphor-icons/vue';

const props = defineProps({
    modelValue: {
        type: Object,
        required: true
    },
    type: {
        type: String,
        required: true
    }
});
</script>
