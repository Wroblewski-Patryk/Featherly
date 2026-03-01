<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';
import DynamicBlock from '@/Components/DynamicBlock.vue';
import BlockEditorSidebar from '@/Components/BlockEditorSidebar.vue';

const props = defineProps(['page']);
const store = useBlockBuilderStore();

const form = useForm({
    title: props.page?.title || { pl: '', en: '' },
    slug: props.page?.slug || { pl: '', en: '' },
    is_published: props.page?.is_published || false,
    content: null,
    meta_title: props.page?.meta_title || { pl: '', en: '' },
    meta_description: props.page?.meta_description || { pl: '', en: '' },
    og_image: props.page?.og_image || '',
    header_template_id: props.page?.header_template_id || '',
    footer_template_id: props.page?.footer_template_id || '',
});

// Auto-generate slug from title if it's a new page or user is typing title and slug is empty
const generateSlug = (text) => {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
};

watch(() => form.title.pl, (newTitle) => {
    if (!props.page?.id || !form.slug.pl || form.slug.pl === generateSlug(form.title.pl.slice(0, -1))) {
        form.slug.pl = generateSlug(newTitle);
    }
});

watch(() => form.title.en, (newTitle) => {
    if (!props.page?.id || !form.slug.en || form.slug.en === generateSlug(form.title.en.slice(0, -1))) {
        form.slug.en = generateSlug(newTitle);
    }
});

onMounted(() => {
    store.setBlocks(props.page?.content || []);
});

function savePage() {
    form.content = store.blocks;
    if (props.page?.id) {
        form.put(`/admin/pages/${props.page.id}`);
    } else {
        form.post(`/admin/pages`);
    }
}
</script>

<template>
    <Head :title="page?.id ? 'Edit Page' : 'Create Page'" />
    <AdminLayout>
        <div class="h-[calc(100vh-4rem)] flex overflow-hidden -m-6"> <!-- Negative margin to counteract AdminLayout padding to full bleed -->
            
            <!-- Center Canvas -->
            <div class="flex-1 bg-base-300 overflow-y-auto relative p-8">
                <!-- Device Viewport Simulator -->
                <div class="max-w-screen-xl mx-auto shadow-2xl bg-base-100 min-h-[800px] border border-base-200 relative group transition-all duration-300 ease-in-out">
                    
                    <div v-for="block in store.blocks" :key="block.id" 
                         @click="store.setActiveBlock(block.id)"
                         :class="['relative border border-transparent transition-all cursor-pointer', store.activeBlockId === block.id ? '!border-primary z-10' : 'hover:border-primary/50']">
                        
                        <DynamicBlock :block="block" />
                        
                        <!-- Block Overlays / Controls -->
                        <div v-if="store.activeBlockId === block.id" class="absolute top-0 right-0 translate-x-12 bg-base-100 shadow-xl border border-base-200 p-1 rounded-lg flex flex-col gap-1 z-20">
                            <button @click.stop="store.moveBlock(block.id, 'up')" class="btn btn-sm btn-ghost p-2" title="Move Up">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                            </button>
                            <button @click.stop="store.moveBlock(block.id, 'down')" class="btn btn-sm btn-ghost p-2" title="Move Down">
                               <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                            <div class="h-px bg-base-200 my-1"></div>
                            <button @click.stop="store.removeBlock(block.id)" class="btn btn-sm btn-error btn-ghost p-2 text-error" title="Delete">
                               <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>
                        
                        <!-- Empty Block Placeholder -->
                        <div v-if="!block.content || Object.keys(block.content).length === 0" class="p-8 text-center text-base-content/50 border border-dashed border-base-300 bg-base-200/50 m-2 rounded">
                            Empty {{ block.type }} block
                        </div>
                    </div>
                    
                    <div v-if="store.blocks.length === 0" class="absolute inset-0 flex flex-col items-center justify-center text-base-content/40 border-4 border-dashed border-base-300 m-8 rounded-2xl gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span>Add a block to start building your page.</span>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="w-96 bg-base-100 shadow-xl z-30 flex flex-col overflow-hidden shrink-0 border-l border-base-200">
                <div class="p-4 border-b border-base-200 bg-base-200/50 flex justify-between items-center backdrop-blur-md">
                    <h2 class="font-bold">Editor</h2>
                    <button @click="savePage" class="btn btn-primary btn-sm" :disabled="form.processing">
                        <span v-if="form.processing" class="loading loading-spinner"></span>
                        <span v-else>Save</span>
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-6">
                    <!-- Page Level Settings -->
                    <div v-if="!store.activeBlockId">
                        <div role="tablist" class="tabs tabs-bordered mb-6">
                            <input type="radio" name="page_tabs" role="tab" class="tab w-max" aria-label="General" checked />
                            <div role="tabpanel" class="tab-content pt-4">
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">Title (PL)</span></label>
                                    <input type="text" v-model="form.title.pl" class="input input-bordered input-sm w-full" />
                                </div>
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">Title (EN)</span></label>
                                    <input type="text" v-model="form.title.en" class="input input-bordered input-sm w-full" />
                                </div>
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">Slug (PL)</span></label>
                                    <input type="text" v-model="form.slug.pl" class="input input-bordered input-sm w-full" />
                                </div>
                                <div class="divider text-xs opacity-50">Templates Overrides</div>
                                <div class="form-control mb-2">
                                    <label class="label"><span class="label-text text-xs">Header</span></label>
                                    <select v-model="form.header_override_id" class="select select-bordered select-sm w-full">
                                        <option value="">Default (Global)</option>
                                        <option v-for="t in templates" :key="t.id" :value="t.id">{{ t.name }}</option>
                                    </select>
                                </div>
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text text-xs">Footer</span></label>
                                    <select v-model="form.footer_override_id" class="select select-bordered select-sm w-full">
                                        <option value="">Default (Global)</option>
                                        <option v-for="t in templates" :key="t.id" :value="t.id">{{ t.name }}</option>
                                    </select>
                                </div>
                                <div class="divider text-xs opacity-50">Publishing</div>
                                <div class="form-control mb-4">
                                    <label class="label cursor-pointer justify-start gap-4">
                                        <input type="checkbox" v-model="form.is_published" class="checkbox checkbox-primary checkbox-sm" />
                                        <span class="label-text">Published</span>
                                    </label>
                                </div>
                            </div>

                            <input type="radio" name="page_tabs" role="tab" class="tab w-max" aria-label="SEO" />
                            <div role="tabpanel" class="tab-content pt-4">
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">Meta Title (PL)</span></label>
                                    <input type="text" v-model="form.meta_title.pl" class="input input-bordered input-sm w-full" />
                                </div>
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">Meta Desc (PL)</span></label>
                                    <textarea v-model="form.meta_description.pl" class="textarea textarea-bordered textarea-sm w-full h-24"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="divider">Add Blocks</div>
                        <div class="grid grid-cols-2 gap-2">
                            <button @click="store.addBlock('hero')" class="btn btn-outline btn-sm justify-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" /></svg> Hero
                            </button>
                            <button @click="store.addBlock('heading')" class="btn btn-outline btn-sm justify-start gap-2 text-xs">
                                <span class="font-bold">H1-H4</span> Heading
                            </button>
                            <button @click="store.addBlock('text')" class="btn btn-outline btn-sm justify-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg> Text
                            </button>
                            <button @click="store.addBlock('columns')" class="btn btn-outline btn-sm justify-start gap-2 text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg> Columns
                            </button>
                            <button @click="store.addBlock('image')" class="btn btn-outline btn-sm justify-start gap-2 col-span-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" /></svg> Image Library
                            </button>
                        </div>
                    </div>
                    
                    <!-- Active Block Settings -->
                    <BlockEditorSidebar v-else />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
