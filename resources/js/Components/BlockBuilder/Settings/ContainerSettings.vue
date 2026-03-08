<template>
    <div class="space-y-6">
        <!-- General Settings -->
        <div class="space-y-4">
            <label class="text-[10px] opacity-40 uppercase font-black">General</label>
            <div class="form-control">
                <label class="label"><span class="label-text text-xs opacity-50">HTML Tag</span></label>
                <select v-model="modelValue.htmlTag" class="select select-bordered select-sm w-full">
                    <option value="section">Section</option>
                    <option value="main">Main</option>
                    <option value="header">Header</option>
                    <option value="footer">Footer</option>
                    <option value="article">Article</option>
                    <option value="aside">Aside</option>
                    <option value="nav">Navigation</option>
                    <option value="div">Div (Generic)</option>
                </select>
            </div>
            <div class="form-control">
                <label class="label cursor-pointer justify-start gap-4 p-3 bg-base-200/50 rounded-xl border border-white/5">
                    <input type="checkbox" v-model="modelValue.isBoxed" class="checkbox checkbox-primary checkbox-sm" />
                    <span class="text-xs font-bold">Boxed / Centered (Container)</span>
                </label>
            </div>
        </div>

        <div class="divider opacity-10"></div>

        <!-- Layout Mode -->
        <div class="space-y-4">
            <label class="text-[10px] opacity-40 uppercase font-black">Layout Mode</label>
            <div class="join w-full">
                <button @click="modelValue.layoutType = 'default'" 
                        class="btn btn-xs join-item flex-1"
                        :class="modelValue.layoutType === 'default' ? 'btn-primary' : ''">Default</button>
                <button @click="modelValue.layoutType = 'flex'" 
                        class="btn btn-xs join-item flex-1"
                        :class="modelValue.layoutType === 'flex' ? 'btn-primary' : ''">Flexbox</button>
                <button @click="modelValue.layoutType = 'grid'" 
                        class="btn btn-xs join-item flex-1"
                        :class="modelValue.layoutType === 'grid' ? 'btn-primary' : ''">Grid</button>
            </div>

            <!-- Flexbox Settings -->
            <div v-if="modelValue.layoutType === 'flex'" class="p-4 bg-base-200/30 rounded-2xl border border-white/5 space-y-4 animate-in slide-in-from-top-2 duration-300">
                <div class="form-control">
                    <label class="label"><span class="label-text text-[10px] uppercase opacity-50">Direction</span></label>
                    <div class="join w-full">
                        <button @click="modelValue.flexConfig.direction = 'row'" class="btn btn-xs join-item flex-1" :class="modelValue.flexConfig.direction === 'row' ? 'btn-primary' : ''">Row</button>
                        <button @click="modelValue.flexConfig.direction = 'col'" class="btn btn-xs join-item flex-1" :class="modelValue.flexConfig.direction === 'col' ? 'btn-primary' : ''">Column</button>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-[10px] uppercase opacity-50">Align Items</span></label>
                    <select v-model="modelValue.flexConfig.align" class="select select-bordered select-xs w-full">
                        <option value="start">Start</option>
                        <option value="center">Center</option>
                        <option value="end">End</option>
                        <option value="stretch">Stretch</option>
                        <option value="baseline">Baseline</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-[10px] uppercase opacity-50">Justify Content</span></label>
                    <select v-model="modelValue.flexConfig.justify" class="select select-bordered select-xs w-full">
                        <option value="start">Start</option>
                        <option value="center">Center</option>
                        <option value="end">End</option>
                        <option value="between">Space Between</option>
                        <option value="around">Space Around</option>
                        <option value="evenly">Space Evenly</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-[10px] uppercase opacity-50">Gap (Tailwind)</span></label>
                    <select v-model="modelValue.flexConfig.gap" class="select select-bordered select-xs w-full">
                        <option v-for="g in [0,1,2,3,4,6,8,10,12,16,20]" :key="g" :value="g.toString()">Gap {{g}}</option>
                    </select>
                </div>
            </div>

            <!-- Grid Settings -->
            <div v-if="modelValue.layoutType === 'grid'" class="p-4 bg-base-200/30 rounded-2xl border border-white/5 space-y-4 animate-in slide-in-from-top-2 duration-300">
                <div class="form-control">
                    <label class="label"><span class="label-text text-[10px] uppercase opacity-50">Columns (MD+)</span></label>
                    <input type="number" v-model="modelValue.gridConfig.cols" min="1" max="12" class="input input-bordered input-sm w-full" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-[10px] uppercase opacity-50">Gap (Tailwind)</span></label>
                    <select v-model="modelValue.gridConfig.gap" class="select select-bordered select-xs w-full">
                        <option v-for="g in [0,1,2,3,4,6,8,10,12,16,20]" :key="g" :value="g.toString()">Gap {{g}}</option>
                    </select>
                </div>
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
