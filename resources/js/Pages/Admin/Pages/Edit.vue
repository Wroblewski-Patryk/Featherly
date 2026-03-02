<template>
    <AdminLayout :full-width="true">
        <BlockBuilder 
            title="Page" 
            save-label="Save Page"
            back-label="Back"
            :back-route="route('admin.pages.index')"
            :categories="store.categories"
            :saving="form.processing"
            :menus="menus"
            @save="save"
        >
            <!-- Info Tab -->
            <template #info>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Page Title</span></label>
                    <input type="text" v-model="form.title.pl" class="input input-bordered input-sm" placeholder="Title (PL)" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Slug</span></label>
                    <input type="text" v-model="form.slug.pl" class="input input-bordered input-sm" placeholder="slug-pl" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Status</span></label>
                    <select v-model="form.is_published" class="select select-bordered select-sm">
                        <option :value="false">Draft</option>
                        <option :value="true">Published</option>
                    </select>
                </div>
                <div class="divider text-[10px] opacity-30 uppercase tracking-widest">Templates</div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Header Override</span></label>
                    <select v-model="form.header_override_id" class="select select-bordered select-sm text-xs">
                        <option :value="null">Global Default</option>
                        <option v-for="t in templates.header || []" :key="t.id" :value="t.id">{{ t.name }}</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs opacity-60">Footer Override</span></label>
                    <select v-model="form.footer_override_id" class="select select-bordered select-sm text-xs">
                        <option :value="null">Global Default</option>
                        <option v-for="t in templates.footer || []" :key="t.id" :value="t.id">{{ t.name }}</option>
                    </select>
                </div>
            </template>

            <!-- History Tab -->
            <template #history>
                <div v-if="!page.revisions || page.revisions.length === 0" class="text-center py-10 opacity-30 text-xs italic">
                    No history yet. Revisions are created when you save changes.
                </div>
                <div v-for="rev in page.revisions" :key="rev.id" class="p-3 bg-base-200/50 rounded-xl border border-white/5 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold">{{ new Date(rev.created_at).toLocaleString() }}</span>
                        <button @click="restoreRevision(rev)" class="btn btn-xs btn-outline btn-primary">Restore</button>
                    </div>
                    <span class="text-[10px] opacity-50">{{ rev.content?.length || 0 }} blocks total</span>
                </div>
            </template>

            <!-- Canvas Decorators -->
            <template #canvas-header>
                <div class="h-16 bg-base-200/10 border-b border-black/5 flex items-center px-8 opacity-40 italic text-xs">
                    Header Area (Dynamic)
                </div>
            </template>

            <template #canvas-footer>
                <div class="h-16 bg-base-200/10 border-t border-black/5 flex items-center px-8 opacity-40 italic text-xs mt-auto">
                    Footer Area (Dynamic)
                </div>
            </template>
        </BlockBuilder>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import BlockBuilder from '@/Components/BlockBuilder.vue';
import { useForm } from '@inertiajs/vue3';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';
import { onMounted, watch } from 'vue';

const props = defineProps({
    page: Object,
    templates: Object,
    menus: Array
});

const store = useBlockBuilderStore();

const form = useForm({
    title: props.page?.title || { pl: '', en: '' },
    slug: props.page?.slug || { pl: '', en: '' },
    content: props.page?.content || [],
    is_published: props.page?.is_published ?? false,
    header_override_id: props.page?.header_override_id || null,
    footer_override_id: props.page?.footer_override_id || null,
});

onMounted(() => {
    store.init(props.page?.content || []);
});

// Auto-slug generation
watch(() => form.title.pl, (newTitle) => {
    if (!props.page?.id || !form.slug.pl) {
        form.slug.pl = newTitle ? newTitle.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '') : '';
    }
});

const restoreRevision = (rev) => {
    if (confirm('Are you sure you want to restore this version? Current unsaved changes will be lost.')) {
        store.init(rev.content);
        store.isDirty = true;
    }
};

const save = () => {
    form.content = store.blocks;
    if (props.page?.id) {
        form.put(route('admin.pages.update', props.page.id), {
            onSuccess: () => store.isDirty = false
        });
    } else {
        form.post(route('admin.pages.store'), {
            onSuccess: () => store.isDirty = false
        });
    }
};
</script>

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
