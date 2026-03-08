<template>
    <div class="space-y-6">
        <div class="form-control">
            <label class="label"><span class="label-text text-[10px] uppercase opacity-50">Entrance Animation</span></label>
            <select v-model="settings.animation.type" class="select select-bordered select-sm w-full">
                <option :value="undefined">None</option>
                <option value="fade">Fade In</option>
                <option value="slide-up">Slide Up</option>
                <option value="slide-down">Slide Down</option>
                <option value="slide-left">Slide Left</option>
                <option value="slide-right">Slide Right</option>
                <option value="zoom-in">Zoom In</option>
                <option value="zoom-out">Zoom Out</option>
                <option value="flip-up">Flip Up</option>
            </select>
        </div>

        <div v-if="settings.animation.type" class="p-4 bg-base-300/30 border border-white/5 rounded-2xl space-y-4 animate-in slide-in-from-top-2 duration-300">
            <div class="form-control">
                <label class="label flex justify-between">
                    <span class="label-text text-[10px] uppercase opacity-50">Duration (ms)</span>
                    <span class="text-[10px] font-mono opacity-50">{{ settings.animation.duration }}ms</span>
                </label>
                <input type="range" v-model="settings.animation.duration" min="100" max="3000" step="50" class="range range-xs range-primary" />
            </div>

            <div class="form-control">
                <label class="label flex justify-between">
                    <span class="label-text text-[10px] uppercase opacity-50">Delay (ms)</span>
                    <span class="text-[10px] font-mono opacity-50">{{ settings.animation.delay || 0 }}ms</span>
                </label>
                <input type="range" v-model="settings.animation.delay" min="0" max="2000" step="50" class="range range-xs" />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text text-[10px] uppercase opacity-50">Easing</span></label>
                <select v-model="settings.animation.ease" class="select select-bordered select-xs w-full">
                    <option value="power1.out">Ease Out</option>
                    <option value="power2.out">Strong Out</option>
                    <option value="back.out(1.7)">Elastic</option>
                    <option value="none">Linear</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label cursor-pointer justify-start gap-4">
                    <input type="checkbox" v-model="settings.animation.once" class="checkbox checkbox-primary checkbox-xs" />
                    <span class="text-[10px] uppercase font-bold opacity-50">Play once only</span>
                </label>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    settings: {
        type: Object,
        required: true
    }
});
</script>
