<template>
    <div class="space-y-4">
        <div v-if="type === 'card'" class="space-y-3">
            <input type="text" v-model="modelValue.title" placeholder="Card Title" class="input input-sm input-bordered w-full font-bold" />
            <textarea v-model="modelValue.description" placeholder="Description" class="textarea textarea-sm textarea-bordered w-full"></textarea>
            <input type="text" v-model="modelValue.image" placeholder="Image URL" class="input input-sm input-bordered w-full text-xs" />
            <input type="text" v-model="modelValue.buttonText" placeholder="Button Text" class="input input-sm input-bordered w-full" />
        </div>
        
        <div v-if="type === 'stat'" class="space-y-3">
            <input type="text" v-model="modelValue.title" placeholder="Title" class="input input-sm input-bordered w-full" />
            <input type="text" v-model="modelValue.value" placeholder="Value (e.g., 34K)" class="input input-sm input-bordered w-full font-bold" />
            <input type="text" v-model="modelValue.desc" placeholder="Description" class="input input-sm input-bordered w-full text-xs" />
            <input type="text" v-model="modelValue.icon" placeholder="Icon class (e.g. fas fa-bolt)" class="input input-sm input-bordered w-full font-mono text-xs" />
        </div>

        <div v-if="type === 'accordion'" class="space-y-3">
            <div v-for="(item, idx) in modelValue.items" :key="idx" class="p-2 bg-base-200 rounded-lg">
                <input type="text" v-model="item.title" placeholder="Title" class="input input-xs input-bordered w-full mb-1 font-bold" />
                <textarea v-model="item.content" placeholder="Content" class="textarea textarea-xs textarea-bordered w-full"></textarea>
            </div>
            <button @click="modelValue.items.push({title:'New Item', content:'Content here'})" class="btn btn-xs btn-outline btn-block">Add Item</button>
        </div>

        <div v-if="type === 'timeline'" class="space-y-3">
            <div v-for="(item, idx) in modelValue.items" :key="idx" class="p-2 bg-base-200 rounded-lg">
                <input type="text" v-model="item.year" placeholder="Year / Time" class="input input-xs input-bordered w-full mb-1 font-bold" />
                <input type="text" v-model="item.title" placeholder="Title" class="input input-xs input-bordered w-full mb-1 font-bold text-primary" />
                <textarea v-model="item.content" placeholder="Details" class="textarea textarea-xs textarea-bordered w-full"></textarea>
            </div>
            <button @click="modelValue.items.push({year:'2026', title:'New Milestone', content:''})" class="btn btn-xs btn-outline btn-block">Add Milestone</button>
        </div>

        <div v-if="type === 'chat'" class="space-y-3">
            <label class="text-[10px] opacity-40 uppercase font-black">Messages</label>
            <div v-for="(msg, idx) in modelValue.messages" :key="idx" class="p-2 bg-base-200 rounded-lg flex flex-col gap-2">
                <select v-model="msg.side" class="select select-xs select-bordered w-full">
                    <option value="start">Left (Start)</option>
                    <option value="end">Right (End)</option>
                </select>
                <input type="text" v-model="msg.text" placeholder="Message text" class="input input-xs input-bordered w-full" />
                <button @click="modelValue.messages.splice(idx, 1)" class="btn btn-xs btn-error btn-outline btn-block mt-1">Remove</button>
            </div>
            <button @click="modelValue.messages.push({side:'start', text:''})" class="btn btn-xs btn-outline btn-block">Add Message</button>
        </div>

        <div v-if="type === 'countdown'" class="space-y-3">
            <input type="number" v-model="modelValue.value" placeholder="Value (e.g. 15)" class="input input-sm input-bordered w-full" />
            <input type="text" v-model="modelValue.unit" placeholder="Unit (e.g. days, hours)" class="input input-sm input-bordered w-full" />
        </div>

        <div v-if="type === 'diff'" class="space-y-3">
            <input type="text" v-model="modelValue.img1" placeholder="Image 1 URL" class="input input-sm input-bordered w-full font-mono text-xs" />
            <input type="text" v-model="modelValue.img2" placeholder="Image 2 URL" class="input input-sm input-bordered w-full font-mono text-xs" />
        </div>

        <div v-if="type === 'alert'" class="space-y-3">
            <textarea v-model="modelValue.text" placeholder="Alert text" class="textarea textarea-sm textarea-bordered w-full"></textarea>
            <select v-model="modelValue.type" class="select select-bordered select-sm w-full">
                <option value="alert-info">Info</option>
                <option value="alert-success">Success</option>
                <option value="alert-warning">Warning</option>
                <option value="alert-error">Error</option>
            </select>
        </div>
        
        <div v-if="['progress', 'radial_progress'].includes(type)" class="space-y-3">
            <input type="number" v-model="modelValue.value" placeholder="Current Value" class="input input-sm input-bordered w-full" />
            <input v-if="type === 'progress'" type="number" v-model="modelValue.max" placeholder="Max Value" class="input input-sm input-bordered w-full" />
            <select v-if="type === 'progress'" v-model="modelValue.color" class="select select-bordered select-sm w-full">
                <option value="progress-primary">Primary</option>
                <option value="progress-secondary">Secondary</option>
                <option value="progress-accent">Accent</option>
                <option value="progress-success">Success</option>
                <option value="progress-warning">Warning</option>
                <option value="progress-error">Error</option>
            </select>
        </div>
    </div>
</template>

<script setup>
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
