<template>
    <div class="flex-1 overflow-y-auto px-4 pb-4 custom-scrollbar">
        <div class="space-y-6 pt-2">
            <!-- Common Info (Module Specific) -->
            <slot name="module-info"></slot>

            <div class="divider opacity-10"></div>

            <!-- Block Stats -->
            <div class="p-4 bg-base-200/50 rounded-2xl border border-white/5 space-y-3">
                <div class="flex justify-between items-center text-xs">
                    <span class="opacity-50 font-bold uppercase tracking-widest text-[10px]">Total Blocks</span>
                    <span class="font-bold font-mono">{{ totalBlocks }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="opacity-50 font-bold uppercase tracking-widest text-[10px]">Last Saved</span>
                    <span class="font-bold font-mono">{{ lastSaved || 'Never' }}</span>
                </div>
            </div>

            <!-- Advanced / Shortcuts -->
            <div class="space-y-3">
                <label class="text-[10px] opacity-40 uppercase font-black">Keyboard Shortcuts</label>
                <div class="grid grid-cols-1 gap-2">
                    <div class="p-3 bg-base-200/50 rounded-xl border border-white/5 flex justify-between items-center">
                        <span class="text-[10px] uppercase font-bold opacity-60">Undo</span>
                        <kbd class="kbd kbd-xs bg-base-300">Ctrl+Z</kbd>
                    </div>
                    <div class="p-3 bg-base-200/50 rounded-xl border border-white/5 flex justify-between items-center">
                        <span class="text-[10px] uppercase font-bold opacity-60">Save</span>
                        <kbd class="kbd kbd-xs bg-base-300">Ctrl+S</kbd>
                    </div>
                </div>
            </div>
            
            <!-- Module Specific SEO/Advanced toggle if provided via slot -->
            <slot name="extra-info"></slot>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    totalBlocks: {
        type: Number,
        default: 0
    },
    lastSaved: {
        type: String,
        default: ''
    }
});
</script>
