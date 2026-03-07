<template>
    <draggable 
        :list="blocks"
        item-key="id" 
        handle=".drag-handle"
        group="blocks"
        ghost-class="opacity-50"
        @change="$emit('change', $event)"
        class="space-y-0.5"
    >
        <template #item="{ element }">
            <div>
                <!-- Item Row -->
                <div 
                    class="group relative text-[11px] py-1 px-2 flex items-center gap-2 cursor-pointer transition-all border-y border-transparent hover:bg-base-content/5 rounded-md mx-1"
                    :class="{ 'bg-primary/10 text-primary border-primary/10 shadow-sm': store.activeBlockId === element.id }"
                    @click="store.activeBlockId = element.id"
                >
                    <!-- Indentation Visuals -->
                    <div v-if="depth > 0" class="flex h-full items-center" :style="{ width: (depth * 0.75) + 'rem' }">
                        <div class="h-4 w-px bg-base-content/10 mr-auto"></div>
                    </div>

                    <!-- Drag Handle -->
                    <PhDotsSixVertical weight="bold" class="w-3 h-3 opacity-0 group-hover:opacity-30 cursor-move drag-handle transition-opacity" />
                    
                    <!-- Icon & Name -->
                    <component :is="iconMap[element.icon] || PhCube" weight="duotone" class="w-3.5 h-3.5 opacity-70" />
                    <span class="font-bold flex-1 truncate tracking-tight uppercase text-[9px] opacity-80">
                        {{ element.type.replace('_', ' ') }}
                    </span>

                    <!-- Quick Actions (Visible when hovered or active) -->
                    <div class="flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity" :class="{ 'opacity-100': store.activeBlockId === element.id }">
                        <button @click.stop="store.isEditingBlock = true; store.showRightSidebar = true; store.activeBlockId = element.id" 
                                class="btn btn-ghost btn-xs btn-square h-6 w-6 min-h-0 text-base-content/40 hover:text-primary hover:bg-primary/10 transition-colors" 
                                title="Settings">
                            <PhSlidersHorizontal weight="bold" class="w-3 h-3" />
                        </button>
                        <button @click.stop="store.duplicateBlock(element.id)" 
                                class="btn btn-ghost btn-xs btn-square h-6 w-6 min-h-0 text-base-content/40 hover:text-primary hover:bg-primary/10 transition-colors" 
                                title="Duplicate">
                            <PhCopy weight="bold" class="w-3 h-3" />
                        </button>
                        <button @click.stop="store.removeBlock(element.id)" 
                                class="btn btn-ghost btn-xs btn-square h-6 w-6 min-h-0 text-base-content/40 hover:text-error hover:bg-error/10 transition-colors" 
                                title="Delete">
                            <PhTrash weight="bold" class="w-3 h-3" />
                        </button>
                    </div>
                </div>
                
                <!-- Recursive Children Rendering -->
                <div v-if="element.children && element.children.length > 0" class="mt-1">
                    <LayerTreeItem 
                        :blocks="element.children" 
                        :depth="depth + 1" 
                        @change="$emit('change', $event)"
                    />
                </div>
            </div>
        </template>
    </draggable>
</template>

<script setup>
import draggable from 'vuedraggable';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';
import { 
    PhDotsSixVertical, PhSlidersHorizontal, PhCopy, PhTrash, PhCube, PhTextT, 
    PhTextAa, PhTextHOne, PhListBullets, PhQuotes, PhCode, PhCursorClick, 
    PhHandPointing, PhCaretDown, PhBrowsers, PhArrowsLeftRight, PhDesktop, 
    PhListDashes, PhUserCircle, PhCertificate, PhIdentificationCard, PhChats, 
    PhTimer, PhCircleHalf, PhChartLineUp, PhTable, PhWarningCircle, PhWarning, 
    PhListChecks, PhCircleNotch, PhPencilSimple, PhCheckSquare, PhRadioButton, 
    PhToggleRight, PhStarHalf, PhUploadSimple, PhStack, PhBoundingBox, PhColumns, 
    PhList, PhMinus, PhStar, PhImage, PhVideoCamera, PhNavigationArrow, PhDotsThree, 
    PhBrowser, PhFootprints, PhFolder, PhTerminal, PhDeviceMobile, PhAppWindow, 
    PhPlusCircle, PhArticle, PhBriefcase, PhArrowsClockwise, PhListNumbers, 
    PhDeviceTablet, PhArrowsOut, PhArrowUUpLeft, PhPlus, PhX
} from '@phosphor-icons/vue';

const iconMap = {
    PhCube, PhTextT, PhTextAa, PhTextHOne, PhListBullets, PhQuotes, PhCode, 
    PhCursorClick, PhHandPointing, PhCaretDown, PhBrowsers, PhArrowsLeftRight, 
    PhDesktop, PhListDashes, PhUserCircle, PhCertificate, PhIdentificationCard, 
    PhSlidersHorizontal, PhChats, PhTimer, PhCircleHalf, PhChartLineUp, PhTable, 
    PhWarningCircle, PhWarning, PhListChecks, PhCircleNotch, PhPencilSimple, 
    PhCheckSquare, PhRadioButton, PhToggleRight, PhStarHalf, PhUploadSimple, 
    PhStack, PhBoundingBox, PhColumns, PhList, PhMinus, PhStar, PhImage, 
    PhVideoCamera, PhNavigationArrow, PhDotsThree, PhBrowser, PhFootprints, 
    PhFolder, PhTerminal, PhDeviceMobile, PhAppWindow, PhPlusCircle, PhArticle, 
    PhBriefcase, PhArrowsClockwise, PhListNumbers
};

const props = defineProps({
    blocks: {
        type: Array,
        required: true
    },
    depth: {
        type: Number,
        default: 0
    }
});

defineEmits(['change']);

const store = useBlockBuilderStore();
</script>
