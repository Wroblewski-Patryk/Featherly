<template>
    <div class="space-y-6">
        <!-- Colors -->
        <AdminCollapse title="Colors" icon="PhPalette">
            <div class="space-y-4 pt-1">
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control items-center w-full col-span-2">
                        <FillControl v-model="backgroundFill" label="Background" />
                    </div>
                    <div class="divider my-0 opacity-10 col-span-2"></div>
                    <div class="form-control items-center w-full col-span-2">
                        <FillControl v-model="textFill" label="Text" />
                    </div>
                </div>
            </div>
        </AdminCollapse>

        <!-- Spacing (Margin & Padding) -->
        <AdminCollapse title="Spacing" icon="PhFrameCorners">
            <div class="space-y-6 pt-1">
                <LinkedUnitInput 
                    v-model:top="settings.style.marginTop"
                    v-model:right="settings.style.marginRight"
                    v-model:bottom="settings.style.marginBottom"
                    v-model:left="settings.style.marginLeft"
                    label="Margin" 
                />
                <div class="divider my-0 opacity-10"></div>
                <LinkedUnitInput 
                    v-model:top="settings.style.paddingTop"
                    v-model:right="settings.style.paddingRight"
                    v-model:bottom="settings.style.paddingBottom"
                    v-model:left="settings.style.paddingLeft"
                    label="Padding" 
                />
            </div>
        </AdminCollapse>

        <!-- Typography -->
        <AdminCollapse title="Typography" icon="PhTextT" :open="true" v-if="!['container', 'spacer', 'divider', 'image', 'video', 'gallery', 'carousel'].includes(blockType)">
            <div class="space-y-4 pt-1">
                <div class="form-control">
                    <label class="label"><span class="label-text text-[10px] uppercase">Font Family</span></label>
                    <select v-model="settings.style.fontFamily" class="select select-bordered select-sm w-full">
                        <option :value="undefined">Default</option>
                        <option value="sans-serif">Sans Serif</option>
                        <option value="serif">Serif</option>
                        <option value="monospace">Monospace</option>
                        <option value="'Inter', sans-serif">Inter</option>
                        <option value="'Titillium Web', sans-serif">Titillium Web</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-[10px] uppercase">Font Size</span></label>
                        <UnitInput v-model="settings.style.fontSize" placeholder="Size" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text text-[10px] uppercase">Letter Spacing</span></label>
                        <UnitInput v-model="settings.style.letterSpacing" placeholder="Spacing" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control col-span-2">
                        <label class="label"><span class="label-text text-[10px] uppercase">Alignment</span></label>
                        <div class="join w-full">
                            <button @click="settings.style.textAlign = 'left'" class="btn btn-sm join-item flex-1" :class="settings.style.textAlign === 'left' ? 'btn-primary' : 'bg-base-300'"><PhTextAlignLeft weight="bold" class="w-4 h-4" /></button>
                            <button @click="settings.style.textAlign = 'center'" class="btn btn-sm join-item flex-1" :class="settings.style.textAlign === 'center' ? 'btn-primary' : 'bg-base-300'"><PhTextAlignCenter weight="bold" class="w-4 h-4" /></button>
                            <button @click="settings.style.textAlign = 'right'" class="btn btn-sm join-item flex-1" :class="settings.style.textAlign === 'right' ? 'btn-primary' : 'bg-base-300'"><PhTextAlignRight weight="bold" class="w-4 h-4" /></button>
                            <button @click="settings.style.textAlign = 'justify'" class="btn btn-sm join-item flex-1" :class="settings.style.textAlign === 'justify' ? 'btn-primary' : 'bg-base-300'"><PhTextAlignJustify weight="bold" class="w-4 h-4" /></button>
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label"><span class="label-text text-[10px] uppercase">Weight</span></label>
                        <div class="join w-full">
                            <button @click="settings.style.fontWeight = '300'" class="btn btn-sm join-item flex-1 font-light" :class="settings.style.fontWeight === '300' ? 'btn-primary' : 'bg-base-300'">L</button>
                            <button @click="settings.style.fontWeight = 'normal'" class="btn btn-sm join-item flex-1 font-normal" :class="(!settings.style.fontWeight || settings.style.fontWeight === 'normal') ? 'btn-primary' : 'bg-base-300'">R</button>
                            <button @click="settings.style.fontWeight = '500'" class="btn btn-sm join-item flex-1 font-medium" :class="settings.style.fontWeight === '500' ? 'btn-primary' : 'bg-base-300'">M</button>
                            <button @click="settings.style.fontWeight = 'bold'" class="btn btn-sm join-item flex-1 font-bold" :class="settings.style.fontWeight === 'bold' ? 'btn-primary' : 'bg-base-300'">B</button>
                            <button @click="settings.style.fontWeight = '900'" class="btn btn-sm join-item flex-1 font-black" :class="settings.style.fontWeight === '900' ? 'btn-primary' : 'bg-base-300'">H</button>
                        </div>
                    </div>
                </div>
            </div>
        </AdminCollapse>

        <!-- Borders -->
        <AdminCollapse title="Border & Appearance" icon="PhSquareHalf">
            <div class="space-y-6 pt-1">
                <LinkedUnitInput 
                    v-model:top="settings.style.borderTopLeftRadius"
                    v-model:right="settings.style.borderTopRightRadius"
                    v-model:bottom="settings.style.borderBottomRightRadius"
                    v-model:left="settings.style.borderBottomLeftRadius"
                    label="Radius" 
                />
                <div class="divider my-0 opacity-10"></div>
                <LinkedUnitInput 
                    v-model:top="settings.style.borderTopWidth"
                    v-model:right="settings.style.borderRightWidth"
                    v-model:bottom="settings.style.borderBottomWidth"
                    v-model:left="settings.style.borderLeftWidth"
                    label="Width" 
                />
                <div class="divider my-0 opacity-10"></div>
                <div class="grid grid-cols-1">
                    <div class="form-control w-full">
                        <FillControl v-model="borderFill" label="Border" />
                    </div>
                </div>
            </div>
        </AdminCollapse>

        <!-- Dimensions -->
        <AdminCollapse title="Dimensions" icon="PhBoundingBox">
            <div class="space-y-4 pt-1">
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-[10px] uppercase">Width</span></label>
                        <UnitInput v-model="settings.style.width" placeholder="auto" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text text-[10px] uppercase">Height</span></label>
                        <UnitInput v-model="settings.style.height" placeholder="auto" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-[10px] uppercase">Max Width</span></label>
                    <UnitInput v-model="settings.style.maxWidth" placeholder="none" />
                </div>
            </div>
        </AdminCollapse>

        <!-- Effects & Visibility -->
        <AdminCollapse title="Effects & Visibility" icon="PhSelectionBackground">
            <div class="space-y-4 pt-1">
                <div class="form-control">
                    <label class="label flex justify-between">
                        <span class="label-text text-[10px] uppercase">Opacity</span>
                        <span class="text-[10px] font-mono">{{ Math.round((settings.style.opacity || 1) * 100) }}%</span>
                    </label>
                    <input type="range" v-model.number="settings.style.opacity" min="0" max="1" step="0.01" class="range range-primary range-xs" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-[10px] uppercase">Display</span></label>
                        <select v-model="settings.style.display" class="select select-bordered select-sm w-full">
                            <option :value="undefined">Default</option>
                            <option value="block">Block</option>
                            <option value="flex">Flex</option>
                            <option value="grid">Grid</option>
                            <option value="inline-block">Inline Block</option>
                            <option value="none">Hidden (None)</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text text-[10px] uppercase">Overflow</span></label>
                        <select v-model="settings.style.overflow" class="select select-bordered select-sm w-full">
                            <option :value="undefined">Default</option>
                            <option value="visible">Visible</option>
                            <option value="hidden">Hidden</option>
                            <option value="auto">Auto</option>
                            <option value="scroll">Scroll</option>
                        </select>
                    </div>
                </div>
            </div>
        </AdminCollapse>

        <!-- Layout & Position -->
        <AdminCollapse title="Layout & Position" icon="PhLayout">
            <div class="space-y-4 pt-1">
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-[10px] uppercase">Z-Index</span></label>
                        <input type="number" v-model="settings.style.zIndex" class="input input-sm input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text text-[10px] uppercase">Position</span></label>
                        <select v-model="settings.style.position" class="select select-bordered select-sm w-full">
                            <option :value="undefined">Static</option>
                            <option value="relative">Relative</option>
                            <option value="absolute">Absolute</option>
                            <option value="fixed">Fixed</option>
                            <option value="sticky">Sticky</option>
                        </select>
                    </div>
                </div>
                <!-- Offsets -->
                <div v-if="['absolute', 'fixed', 'sticky', 'relative'].includes(settings.style.position)" class="bg-base-300/50 p-4 rounded-xl mt-4 space-y-4">
                    <div class="text-[10px] uppercase font-bold opacity-50 mb-2 border-b border-white/10 pb-1">Offsets</div>
                    <div class="flex items-center gap-4">
                        <div class="join border border-white/10 overflow-hidden shadow-lg flex-shrink-0">
                            <button @click="toggleOffset('top')" class="btn btn-xs join-item" :class="settings.style.top !== undefined ? 'btn-primary' : 'bg-base-200 opacity-50'"><PhArrowUp weight="bold" class="w-3 h-3" /></button>
                            <button @click="toggleOffset('bottom')" class="btn btn-xs join-item" :class="settings.style.bottom !== undefined ? 'btn-primary' : 'bg-base-200 opacity-50'"><PhArrowDown weight="bold" class="w-3 h-3" /></button>
                            <button @click="toggleOffset('left')" class="btn btn-xs join-item" :class="settings.style.left !== undefined ? 'btn-primary' : 'bg-base-200 opacity-50'"><PhArrowLeft weight="bold" class="w-3 h-3" /></button>
                            <button @click="toggleOffset('right')" class="btn btn-xs join-item" :class="settings.style.right !== undefined ? 'btn-primary' : 'bg-base-200 opacity-50'"><PhArrowRight weight="bold" class="w-3 h-3" /></button>
                        </div>
                        <div class="flex-1">
                            <div v-if="settings.style.top !== undefined" class="flex items-center justify-between">
                                <span class="text-[9px] uppercase font-bold opacity-40">Top</span>
                                <UnitInput v-model="settings.style.top" class="!w-20" />
                            </div>
                            <div v-if="settings.style.bottom !== undefined" class="flex items-center justify-between">
                                <span class="text-[9px] uppercase font-bold opacity-40">Bottom</span>
                                <UnitInput v-model="settings.style.bottom" class="!w-20" />
                            </div>
                            <div v-if="settings.style.left !== undefined" class="flex items-center justify-between">
                                <span class="text-[9px] uppercase font-bold opacity-40">Left</span>
                                <UnitInput v-model="settings.style.left" class="!w-20" />
                            </div>
                            <div v-if="settings.style.right !== undefined" class="flex items-center justify-between">
                                <span class="text-[9px] uppercase font-bold opacity-40">Right</span>
                                <UnitInput v-model="settings.style.right" class="!w-20" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AdminCollapse>

        <div class="form-control mt-6">
            <button @click="settings.style = {}" class="btn btn-outline btn-error btn-sm w-full">Reset Styles</button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import AdminCollapse from '@/Components/AdminCollapse.vue';
import FillControl from '@/Components/FillControl.vue';
import LinkedUnitInput from '@/Components/LinkedUnitInput.vue';
import UnitInput from '@/Components/UnitInput.vue';
import { 
    PhTextAlignLeft, PhTextAlignCenter, PhTextAlignRight, PhTextAlignJustify, 
    PhPalette, PhFrameCorners, PhTextT, PhSquareHalf, PhLayout, 
    PhArrowUp, PhArrowDown, PhArrowLeft, PhArrowRight,
    PhBoundingBox, PhSelectionBackground, PhEye
} from '@phosphor-icons/vue';

const props = defineProps({
    settings: {
        type: Object,
        required: true
    },
    blockType: String
});

const createFillProxy = (newProp, legacyProp) => computed({
    get: () => {
        if (!props.settings || !props.settings.style) return undefined;
        if (props.settings.style[newProp] !== undefined) return props.settings.style[newProp];
        return props.settings.style[legacyProp];
    },
    set: (val) => {
        if (props.settings && props.settings.style) {
            props.settings.style[legacyProp] = undefined;
            props.settings.style[newProp] = val;
        }
    }
});

const backgroundFill = createFillProxy('backgroundFill', 'backgroundColor');
const textFill = createFillProxy('textFill', 'textColor');
const borderFill = createFillProxy('borderFill', 'borderColor');

const toggleOffset = (direction) => {
    if (!props.settings || !props.settings.style) return;
    const style = props.settings.style;
    
    if (direction === 'top') {
        const val = style.bottom ?? style.top ?? '0px';
        style.bottom = undefined;
        style.top = val;
    } else if (direction === 'bottom') {
        const val = style.top ?? style.bottom ?? '0px';
        style.top = undefined;
        style.bottom = val;
    } else if (direction === 'left') {
        const val = style.right ?? style.left ?? '0px';
        style.right = undefined;
        style.left = val;
    } else if (direction === 'right') {
        const val = style.left ?? style.right ?? '0px';
        style.left = undefined;
        style.right = val;
    }
};
</script>
