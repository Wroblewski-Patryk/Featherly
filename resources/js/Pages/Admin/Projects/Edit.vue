<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { PhCamera, PhCards } from '@phosphor-icons/vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import BlockBuilder from '@/Components/BlockBuilder.vue';
import DatePicker from '@/Components/DatePicker.vue';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';

const props = defineProps({
    project: Object,
    templates: Array
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
    client: props.project?.client || '',
    order: props.project?.order || 0,
    status: props.project?.status || 'draft',
    published_at: props.project?.published_at ? props.project.published_at.substring(0, 19).replace('T', ' ') : '',
});

const previewUrl = computed(() => form.slug ? `/projects/${form.slug}` : null);

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
    <AdminLayout :full-width="true">
        <BlockBuilder 
            v-model:title="form.title.pl"
            :categories="store.categories"
            :saving="form.processing"
            :templates="templates"
            :preview-url="previewUrl"
            @save="submit"
        >
            <template #info>
                <div class="flex flex-col gap-6">
                    <div class="form-control">
                        <label class="label pt-0"><span class="label-text text-xs font-bold opacity-60">URL Slug</span></label>
                        <input type="text" v-model="form.slug" class="input input-bordered input-sm focus:border-primary/50 transition-all" placeholder="project-slug" />
                    </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text text-xs opacity-60">Client</span></label>
                            <input type="text" v-model="form.client" class="input input-bordered input-sm focus:border-primary/50" placeholder="Client Name" />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text text-xs opacity-60">Category</span></label>
                            <input type="text" v-model="form.category" class="input input-bordered input-sm focus:border-primary/50" placeholder="e.g. Residential" />
                        </div>
                        <div class="form-control">
                            <label class="label pt-0"><span class="label-text text-xs font-bold opacity-60">Status</span></label>
                            <select v-model="form.status" class="select select-bordered select-sm text-xs bg-base-100/50 hover:bg-base-200/50 transition-all border-white/10 focus:border-primary/50">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="planned">Planned</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                        <DatePicker 
                            v-if="form.status === 'planned' || form.status === 'published'"
                            v-model="form.published_at" 
                            label="Publish Date & Time"
                        />
                    </div>
        </template>

            <template #canvas-header>
                <div class="h-80 bg-base-200/20 flex flex-col items-center justify-center border-b border-black/5">
                    <div class="text-center group cursor-pointer">
                        <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <PhCamera weight="regular" class="w-8 h-8 opacity-20" />
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

</style>
