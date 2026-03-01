<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import draggable from 'vuedraggable';

const props = defineProps(['menu', 'pages']);

const form = useForm({
    name: props.menu?.name || '',
    items: props.menu?.items || [],
});

function addItem() {
    form.items.push({
        id: 'item_' + Date.now(),
        label: 'New Link',
        url: '/',
        target: '_self',
        type: 'custom',
        page_id: null
    });
}

function removeItem(index) {
    form.items.splice(index, 1);
}

function saveMenu() {
    if (props.menu?.id) {
        form.put(`/admin/menus/${props.menu.id}`);
    } else {
        form.post(`/admin/menus`);
    }
}

function setPageUrl(item, pageId) {
    const page = props.pages.find(p => p.id === pageId);
    if (page) {
        item.label = page.title;
        item.page_id = pageId;
        item.type = 'page';
        // We'll keep url as well for fallback or manual override if needed
        item.url = page.slug === 'home' ? '/' : `/${page.slug}`;
    }
}
</script>

<template>
    <Head :title="menu?.id ? 'Edit Menu' : 'Create Menu'" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <Link href="/admin/menus" class="btn btn-ghost btn-circle btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </Link>
                    <h2 class="text-xl font-semibold leading-tight">{{ menu?.id ? 'Edit' : 'Create' }} Menu</h2>
                </div>
                <button @click="saveMenu" class="btn btn-primary btn-sm px-6 rounded-full shadow-lg shadow-primary/20" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-spinner loading-xs"></span>
                    Save Changes
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Menu Sidebar: Settings -->
                    <div class="space-y-6">
                        <div class="bg-base-100 p-6 rounded-[2rem] border border-base-200 shadow-sm">
                            <h3 class="text-[10px] font-black uppercase tracking-widest opacity-30 mb-4">Menu Basics</h3>
                            
                            <div class="form-control mb-4">
                                <label class="label"><span class="label-text font-semibold opacity-70">Menu Name</span></label>
                                <input type="text" v-model="form.name" placeholder="e.g. Main Navigation" class="input input-bordered w-full rounded-2xl" />
                            </div>

                            <button @click="addItem" class="btn btn-outline btn-block rounded-2xl gap-2 border-opacity-20 hover:bg-base-200 hover:text-base-content hover:border-transparent">
                                <i class="fas fa-plus text-xs"></i> Add Item
                            </button>
                        </div>

                        <div class="bg-primary/5 p-6 rounded-[2rem] border border-primary/10">
                            <h4 class="text-xs font-bold text-primary mb-2 flex items-center gap-2">
                                <i class="fas fa-info-circle"></i> Tip
                            </h4>
                            <p class="text-[10px] leading-relaxed opacity-60">
                                Drag and drop items on the right to reorder them. You can link to existing pages or custom URLs.
                            </p>
                        </div>
                    </div>

                    <!-- Menu Content: Items List -->
                    <div class="md:col-span-2 space-y-4">
                        <div class="bg-base-100 rounded-[2rem] border border-base-200 shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-base-100 font-bold text-xs uppercase tracking-widest opacity-40">
                                Navigation Items
                            </div>
                            
                            <div class="p-4">
                                <draggable 
                                    v-model="form.items" 
                                    item-key="id"
                                    handle=".drag-handle"
                                    ghost-class="ghost-item"
                                    class="space-y-3">
                                    <template #item="{ element, index }">
                                        <div class="group border border-base-200 rounded-3xl p-4 bg-base-50/50 hover:bg-white transition-all hover:shadow-lg hover:shadow-base-300/50">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="drag-handle cursor-move opacity-20 group-hover:opacity-100 transition-opacity">
                                                    <i class="fas fa-grip-vertical"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <input type="text" v-model="element.label" class="bg-transparent border-none p-0 text-sm font-bold focus:ring-0 w-full" placeholder="Link Label" />
                                                </div>
                                                <button @click="removeItem(index)" class="btn btn-ghost btn-circle btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <div class="form-control">
                                                    <label class="label py-1"><span class="label-text text-[10px] opacity-40">Link Type</span></label>
                                                    <select v-model="element.type" class="select select-bordered select-sm rounded-xl">
                                                        <option value="custom">Custom URL</option>
                                                        <option value="page">Existing Page</option>
                                                    </select>
                                                </div>
                                                
                                                <div v-if="element.type === 'page'" class="form-control">
                                                    <label class="label py-1"><span class="label-text text-[10px] opacity-40">Select Page</span></label>
                                                    <select @change="(e) => setPageUrl(element, parseInt(e.target.value))" v-model="element.page_id" class="select select-bordered select-sm rounded-xl">
                                                        <option :value="null">Choose a page...</option>
                                                        <option v-for="page in pages" :key="page.id" :value="page.id">{{ page.title }}</option>
                                                    </select>
                                                </div>

                                                <div v-else class="form-control">
                                                    <label class="label py-1"><span class="label-text text-[10px] opacity-40">URL</span></label>
                                                    <input type="text" v-model="element.url" class="input input-bordered input-sm rounded-xl" placeholder="e.g. /about" />
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </draggable>

                                <div v-if="form.items.length === 0" class="py-20 text-center opacity-20 italic">
                                    <i class="fas fa-link text-4xl mb-4 block"></i>
                                    No items added yet. Click "Add Item" to start.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.ghost-item {
    opacity: 0.3;
    background: hsla(220, 100%, 50%, 0.1);
    border: 2px dashed hsla(220, 100%, 50%, 0.3);
    border-radius: 1.5rem;
}
</style>
