<template>
    <AdminLayout :full-width="true">
        <BlockBuilder 
            v-model:title="form.name"
            :categories="store.categories"
            :saving="form.processing"
            :templates="templates"
            @save="save"
        >
            <template #info>
                <div class="flex flex-col gap-6">
                    <div class="form-control">
                        <label class="label pt-0"><span class="label-text text-xs font-bold opacity-60">Template Type</span></label>
                        <select v-model="form.type" class="select select-bordered select-sm focus:select-primary w-full">
                            <option value="header">Header</option>
                            <option value="footer">Footer</option>
                            <option value="sidebar">Sidebar</option>
                            <option value="page">Page Template</option>
                        </select>
                    </div>
                    <div class="form-control flex-row items-center gap-3 p-4 bg-base-200 rounded-2xl border border-white/5">
                        <input type="checkbox" v-model="form.is_default" class="checkbox checkbox-primary" id="is_default" />
                        <label for="is_default" class="cursor-pointer">
                            <span class="text-sm font-bold">Set as Default</span>
                            <p class="text-[10px] opacity-50">Applies to all pages without override</p>
                        </label>
                    </div>
                </div>
            </template>

            <template #canvas-footer v-if="form.type === 'header'">
                <div class="h-[400px] bg-base-200/5 flex items-center justify-center opacity-10 select-none border-y border-black/5">
                    <div class="text-center">
                        <PhFileText weight="regular" class="w-16 h-16 mb-4 mx-auto block" />
                        <p class="text-xl font-bold uppercase tracking-widest">Page Content Area</p>
                    </div>
                </div>
            </template>

            <template #canvas-header v-if="form.type === 'footer'">
                 <div class="h-[400px] bg-base-200/5 flex items-center justify-center opacity-10 select-none border-y border-black/5">
                    <div class="text-center">
                        <PhFileText weight="regular" class="w-16 h-16 mb-4 mx-auto block" />
                        <p class="text-xl font-bold uppercase tracking-widest">Page Content Area</p>
                    </div>
                </div>
            </template>

            <!-- History Tab -->
            <template #history>
                <div v-if="!template.revisions || template.revisions.length === 0" class="text-center py-10 opacity-30 text-xs italic">
                    <PhClockCounterClockwise weight="thin" class="w-10 h-10 mx-auto mb-3 opacity-20" />
                    No history yet. Revisions are created when you save changes.
                </div>
                <div v-else class="space-y-3">
                    <div v-for="rev in template.revisions" :key="rev.id" class="p-3 bg-base-200/50 rounded-xl border border-base-content/5 flex flex-col gap-2 hover:border-primary/30 transition-all group">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold opacity-70">{{ new Date(rev.created_at).toLocaleString() }}</span>
                            <button @click="restoreRevision(rev)" class="btn btn-xs btn-outline btn-primary opacity-0 group-hover:opacity-100 scale-90 transition-all">Restore</button>
                        </div>
                        <span class="text-[10px] opacity-40">{{ rev.content?.length || 0 }} blocks total</span>
                    </div>
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
import { PhFileText, PhLayout, PhClockCounterClockwise } from '@phosphor-icons/vue';
import { onMounted } from 'vue';

const props = defineProps({
    template: Object,
    templates: [Array, Object],
});

const store = useBlockBuilderStore();

const form = useForm({
    name: props.template?.name || '',
    type: props.template?.type || 'header',
    content: props.template?.content || [],
    is_default: props.template?.is_default ?? false,
});

onMounted(() => {
    store.init(props.template?.content || []);
});

const restoreRevision = (rev) => {
    if (confirm('Are you sure you want to restore this version? Current unsaved changes will be lost.')) {
        store.init(rev.content);
        store.isDirty = true;
    }
};

const save = () => {
    form.content = store.blocks;
    if (props.template?.id) {
        form.put(route('admin.templates.update', props.template.id), {
            onSuccess: () => store.isDirty = false
        });
    } else {
        form.post(route('admin.templates.store'), {
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

</style>
