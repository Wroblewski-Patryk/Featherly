<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import BlockBuilder from '@/Components/BlockBuilder.vue';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';

const props = defineProps({
    project: Object,
    menus: Array
});

const store = useBlockBuilderStore();

const form = useForm({
    title: props.project?.title || { pl: '', en: '' },
    slug: props.project?.slug || '',
    description: props.project?.description || { pl: '', en: '' },
    content: props.project?.content || [],
    desktop_image: props.project?.desktop_image || '',
    mobile_image: props.project?.mobile_image || '',
    url: props.project?.url || '',
    category: props.project?.category || '',
    order: props.project?.order || 0,
    // Added missing fields from template
    client: props.project?.client || '',
    status: props.project?.status || 'completed'
});

onMounted(() => {
    store.init(props.project?.content || []);
});

// Auto-slug generation
watch(() => form.title.pl, (newTitle) => {
    if (!props.project?.id || !form.slug) {
        form.slug = newTitle ? newTitle.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '') : '';
    }
});

function submit() {
    form.content = store.blocks;
    if (props.project?.id) {
        form.put(route('admin.projects.update', props.project.id), {
            onSuccess: () => store.isDirty = false
        });
    } else {
        form.post(route('admin.projects.store'), {
            onSuccess: () => store.isDirty = false
        });
    }
}
</script>

<template>
    <Head :title="project ? 'Edit Project' : 'Add Project'" />
    <AdminLayout>
        <BlockBuilder 
            title="Project" 
            save-label="Save Project"
            back-label="Back"
            :back-route="route('admin.projects.index')"
            :categories="store.categories"
            :saving="form.processing"
            :menus="menus"
            @save="submit"
        >
            <template #info>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Project Title (PL)</span></label>
                    <input type="text" v-model="form.title.pl" class="input input-bordered input-sm" placeholder="e.g. Modern Villa" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Slug</span></label>
                    <input type="text" v-model="form.slug" class="input input-bordered input-sm" placeholder="project-slug" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Client</span></label>
                    <input type="text" v-model="form.client" class="input input-bordered input-sm" placeholder="Client Name" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Category</span></label>
                    <input type="text" v-model="form.category" class="input input-bordered input-sm" placeholder="e.g. Residential" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Status</span></label>
                    <select v-model="form.status" class="select select-bordered select-sm text-xs">
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
