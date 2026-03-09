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
