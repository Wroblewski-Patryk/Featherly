<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';
import DynamicBlock from '@/Components/DynamicBlock.vue';
import BlockEditorSidebar from '@/Components/BlockEditorSidebar.vue';
import draggable from 'vuedraggable';

const props = defineProps({
    project: Object,
    menus: Array
});

const store = useBlockBuilderStore();
const viewport = ref('desktop');
const leftTab = ref('blocks');

const blocks = computed({
    get: () => store.blocks,
    set: (value) => {
        store.blocks = value;
        store.isDirty = true;
    }
});

const form = useForm({
    title: props.project?.title || { pl: '', en: '' },
    slug: props.project?.slug || '',
    description: props.project?.description || { pl: '', en: '' }, // Legacy, might still use for simple queries
    content: props.project?.content || [],
    desktop_image: props.project?.desktop_image || '',
    mobile_image: props.project?.mobile_image || '',
    url: props.project?.url || '',
    category: props.project?.category || '',
    order: props.project?.order || 0
});

onMounted(() => {
    store.init(props.project?.content || []);
});

function submit() {
    form.content = store.blocks;
    if (props.project) {
        form.put(route('admin.projects.update', props.project.id), {
            onSuccess: () => store.isDirty = false
        });
    } else {
        form.post(route('admin.projects.store'), {
            onSuccess: () => store.isDirty = false
        });
    }
}

const categories = ref([
    {
        id: 'content',
        name: 'Content',
        icon: 'fas fa-align-left',
        blocks: [
            { type: 'paragraph', label: 'Paragraph', icon: 'fas fa-paragraph' },
            { type: 'heading', label: 'Heading', icon: 'fas fa-heading' },
            { type: 'list', label: 'List', icon: 'fas fa-list' },
            { type: 'quote', label: 'Quote', icon: 'fas fa-quote-right' },
            { type: 'button', label: 'Buttons', icon: 'fas fa-mouse-pointer' },
            { type: 'divider', label: 'Divider', icon: 'fas fa-minus' },
            { type: 'spacer', label: 'Spacer', icon: 'fas fa-arrows-alt-v' },
            { type: 'custom_code', label: 'Custom HTML', icon: 'fas fa-code' },
        ]
    },
    {
        id: 'media',
        name: 'Media',
        icon: 'fas fa-photo-video',
        blocks: [
            { type: 'image', label: 'Image', icon: 'fas fa-image' },
            { type: 'gallery', label: 'Gallery', icon: 'fas fa-images' },
            { type: 'video', label: 'Video', icon: 'fas fa-play-circle' },
            { type: 'media_text', label: 'Media & Text', icon: 'fas fa-file-alt' },
        ]
    },
    {
        id: 'layout',
        name: 'Layout',
        icon: 'fas fa-th-large',
        blocks: [
            { type: 'section', label: 'Section', icon: 'fas fa-square' },
            { type: 'columns', label: 'Columns', icon: 'fas fa-columns' },
            { type: 'group', label: 'Group', icon: 'fas fa-object-group' },
        ]
    }
]);

const cloneBlock = (block) => {
    return store.createBlockObject(block.type);
};
</script>

<template>
    <Head title="Edit Project" />
    <AdminLayout>
        <BlockBuilder 
            title="Project" 
            save-label="Save Project"
            back-label="Back"
            :back-route="route('admin.projects.index')"
            :categories="store.categories"
            :saving="form.processing"
            @save="save"
        >
            <template #info>
                <div class="form-control">
                    <label class="label"><span class="label-text">Project Name</span></label>
                    <input type="text" v-model="form.name" class="input input-bordered input-sm" placeholder="e.g. Modern Villa" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Client</span></label>
                    <input type="text" v-model="form.client" class="input input-bordered input-sm" placeholder="Client Name" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Status</span></label>
                    <select v-model="form.status" class="select select-bordered select-sm">
                        <option value="completed">Completed</option>
                        <option value="in_progress">In Progress</option>
                        <option value="planned">Planned</option>
                    </select>
                </div>
            </template>

            <template #canvas-header>
                <div class="h-80 bg-base-200/20 flex flex-col items-center justify-center border-b border-black/5">
                    <div class="text-center group cursor-pointer">
                        <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-camera text-2xl opacity-20"></i>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-30">Upload Showcase Visual</p>
                    </div>
                </div>
            </template>
        </BlockBuilder>
    </AdminLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.1);
}

.ghost-block {
    opacity: 0.5;
    background: #c8ebfb;
    border: 2px dashed #000;
}
</style>
