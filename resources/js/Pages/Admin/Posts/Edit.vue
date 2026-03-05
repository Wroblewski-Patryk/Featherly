<template>
    <AdminLayout :full-width="true">
        <BlockBuilder 
            title="Post" 
            save-label="Save Post"
            back-label="Back"
            :back-route="route('admin.posts.index')"
            :categories="store.categories"
            :saving="form.processing"
            @save="save"
        >
            <template #info>
                <div class="form-control">
                    <label class="label"><span class="label-text">Post Title</span></label>
                    <input type="text" v-model="form.title.pl" class="input input-bordered input-sm" placeholder="Title (PL)" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Slug</span></label>
                    <input type="text" v-model="form.slug.pl" class="input input-bordered input-sm" placeholder="post-slug" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Status</span></label>
                    <select v-model="form.is_published" class="select select-bordered select-sm">
                        <option :value="false">Draft</option>
                        <option :value="true">Published</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Featured Image</span></label>
                    <input type="text" v-model="form.featured_image.pl" class="input input-bordered input-sm" placeholder="Image URL" />
                </div>
            </template>

            <template #top-bar-end>
                <a :href="'/blog/' + (form.slug.pl || form.slug)" target="_blank" class="btn btn-ghost btn-xs">
                    <PhArrowSquareOut weight="bold" class="w-3 h-3 mr-1" /> Preview
                </a>
            </template>
        </BlockBuilder>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import BlockBuilder from '@/Components/BlockBuilder.vue';
import { useForm } from '@inertiajs/vue3';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';
import { PhArrowSquareOut, PhFeather } from '@phosphor-icons/vue';
import { onMounted, watch } from 'vue';

const props = defineProps({
    post: Object,
    menus: Array
});

const store = useBlockBuilderStore();

const form = useForm({
    title: props.post?.title || { pl: '', en: '' },
    slug: props.post?.slug || { pl: '', en: '' },
    excerpt: props.post?.excerpt || { pl: '', en: '' },
    content: props.post?.content || [],
    is_published: props.post?.is_published ?? false,
    featured_image: props.post?.featured_image || { pl: '', en: '' },
});

onMounted(() => {
    store.init(props.post?.content || []);
});

const generateSlug = (text) => {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
};

// Auto-slug generation
watch(() => form.title.pl, (newTitle) => {
    if (!props.post?.id || !form.slug.pl) {
        form.slug.pl = generateSlug(newTitle || '');
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
    if (props.post?.id) {
        form.put(route('admin.posts.update', props.post.id), {
            onSuccess: () => store.isDirty = false
        });
    } else {
        form.post(route('admin.posts.store'), {
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
