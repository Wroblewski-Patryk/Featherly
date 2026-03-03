<template>
    <draggable 
        :list="blocks"
        item-key="id" 
        handle=".drag-handle"
        group="blocks"
        ghost-class="opacity-50"
        @change="$emit('change', $event)"
        class="space-y-1"
    >
        <template #item="{ element }">
            <div>
                <!-- Item Row -->
                <div 
                    class="group relative text-xs py-1.5 px-2 flex items-center gap-2 cursor-pointer transition-colors border-y border-transparent hover:bg-base-content/5"
                    :class="{ 'bg-primary/10 text-primary border-primary/20': store.activeBlockId === element.id }"
                    @click="store.activeBlockId = element.id"
                >
                    <!-- Indentation Visuals (Left Border Guides) -->
                    <div v-if="depth > 0" class="flex h-full items-center pl-1" :style="{ width: (depth * 1) + 'rem' }">
                        <div class="h-6 w-px bg-base-content/10 mr-auto"></div>
                    </div>

                    <!-- Drag Handle -->
                    <i class="fas fa-grip-vertical opacity-0 group-hover:opacity-30 cursor-move drag-handle transition-opacity px-1"></i>
                    
                    <!-- Icon & Name -->
                    <i :class="element.icon || 'fas fa-cube'" class="opacity-70 text-[10px] w-4 text-center"></i>
                    <span class="font-medium flex-1 truncate">
                        {{ element.type.charAt(0).toUpperCase() + element.type.slice(1).replace('_', ' ') }}
                    </span>
                    
                    <!-- ID (Dimmed) -->
                    <span class="opacity-30 text-[9px] font-mono select-none" :class="{ 'text-primary': store.activeBlockId === element.id }">
                        {{ element.id.split('-')[0] }}
                    </span>

                    <!-- Quick Actions (Hidden until hover) -->
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <!-- Pseudo 'Eye' toggle for aesthetics (no logic yet, just UI feeling) -->
                        <button class="btn btn-ghost btn-xs btn-square h-5 w-5 min-h-0 text-base-content/50 hover:text-base-content" title="Toggle Visibility"><i class="fas fa-eye"></i></button>
                        <button @click.stop="store.duplicateBlock(element.id)" class="btn btn-ghost btn-xs btn-square h-5 w-5 min-h-0 text-primary/70 hover:text-primary" title="Duplicate Block"><i class="fas fa-copy"></i></button>
                        <button @click.stop="store.removeBlock(element.id)" class="btn btn-ghost btn-xs btn-square h-5 w-5 min-h-0 text-error/70 hover:text-error" title="Delete Block"><i class="fas fa-trash"></i></button>
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
