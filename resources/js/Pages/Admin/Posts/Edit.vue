<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';
import DynamicBlock from '@/Components/DynamicBlock.vue';

const props = defineProps(['post']);
const store = useBlockBuilderStore();

const form = useForm({
    title: props.post?.title || { pl: '', en: '' },
    slug: props.post?.slug || { pl: '', en: '' },
    excerpt: props.post?.excerpt || { pl: '', en: '' },
    is_published: props.post?.is_published || false,
    content: null,
    meta_title: props.post?.meta_title || { pl: '', en: '' },
    meta_description: props.post?.meta_description || { pl: '', en: '' },
    og_image: props.post?.og_image || '',
});

onMounted(() => {
    store.setBlocks(props.post?.content || []);
});

function savePost() {
    form.content = store.blocks;
    if (props.post?.id) {
        form.put(`/admin/posts/${props.post.id}`);
    } else {
        form.post(`/admin/posts`);
    }
}
</script>

<template>
    <Head :title="post?.id ? 'Edit Post' : 'Create Post'" />
    <AdminLayout>
        <div class="h-[calc(100vh-4rem)] flex overflow-hidden -m-6"> <!-- Negative margin to counteract AdminLayout padding to full bleed -->
            
            <!-- Center Canvas -->
            <div class="flex-1 bg-base-300 overflow-y-auto relative p-8">
                <!-- Device Viewport Simulator -->
                <div class="max-w-screen-md mx-auto shadow-2xl bg-base-100 min-h-[800px] border border-base-200 relative group transition-all duration-300 ease-in-out p-12">
                    <!-- Post Header Preview -->
                    <div class="mb-12 border-b border-base-200 pb-8 opacity-50 select-none">
                        <h1 class="text-4xl font-bold mb-4">{{ form.title.pl || form.title.en || 'Post Title' }}</h1>
                        <p class="text-xl">{{ form.excerpt.pl || form.excerpt.en || 'Short excerpt will appear here...' }}</p>
                    </div>

                    <div v-for="block in store.blocks" :key="block.id" 
                         @click="store.setActiveBlock(block.id)"
                         :class="['relative border border-transparent transition-all cursor-pointer', store.activeBlockId === block.id ? '!border-primary z-10' : 'hover:border-primary/50']">
                        
                        <DynamicBlock :block="block" />
                        
                        <!-- Block Overlays / Controls -->
                        <div v-if="store.activeBlockId === block.id" class="absolute top-0 right-0 translate-x-12 bg-base-100 shadow-xl border border-base-200 p-1 rounded-lg flex flex-col gap-1 z-20">
                            <button @click.stop="store.moveBlock(block.id, 'up')" class="btn btn-sm btn-ghost p-2" title="Move Up"><svg fill="currentColor" viewBox="0 0 20 20" class="w-4 h-4"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg></button>
                            <button @click.stop="store.moveBlock(block.id, 'down')" class="btn btn-sm btn-ghost p-2" title="Move Down"><svg fill="currentColor" viewBox="0 0 20 20" class="w-4 h-4"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></button>
                            <div class="h-px bg-base-200 my-1"></div>
                            <button @click.stop="store.removeBlock(block.id)" class="btn btn-sm btn-error btn-ghost p-2 text-error" title="Delete"><svg fill="currentColor" viewBox="0 0 20 20" class="w-4 h-4"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg></button>
                        </div>
                        
                        <div v-if="!block.content || Object.keys(block.content).length === 0" class="p-8 text-center text-base-content/50 border border-dashed border-base-300 bg-base-200/50 m-2 rounded">
                            Empty {{ block.type }} block
                        </div>
                    </div>
                    
                    <div v-if="store.blocks.length === 0" class="absolute inset-0 flex flex-col items-center justify-center text-base-content/40 border-4 border-dashed border-base-300 m-8 rounded-2xl gap-4">
                        <span>Add a block to write your article content.</span>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="w-96 bg-base-100 shadow-xl z-30 flex flex-col overflow-hidden shrink-0 border-l border-base-200">
                <div class="p-4 border-b border-base-200 bg-base-200/50 flex justify-between items-center backdrop-blur-md">
                    <h2 class="font-bold">Post Editor</h2>
                    <button @click="savePost" class="btn btn-primary btn-sm" :disabled="form.processing">
                        <span v-if="form.processing" class="loading loading-spinner"></span> <span v-else>Save</span>
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-6">
                    <div v-if="!store.activeBlockId">
                        <div role="tablist" class="tabs tabs-bordered mb-6">
                            <input type="radio" name="post_tabs" role="tab" class="tab w-max" aria-label="General" checked />
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
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">Excerpt (PL)</span></label>
                                    <textarea v-model="form.excerpt.pl" class="textarea textarea-bordered textarea-sm w-full"></textarea>
                                </div>
                                <div class="form-control mb-4">
                                    <label class="cursor-pointer label justify-start gap-4">
                                        <input type="checkbox" v-model="form.is_published" class="checkbox checkbox-primary checkbox-sm" />
                                        <span class="label-text">Published</span>
                                    </label>
                                </div>
                            </div>

                            <input type="radio" name="post_tabs" role="tab" class="tab w-max" aria-label="SEO" />
                            <div role="tabpanel" class="tab-content pt-4">
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">Meta Title (PL)</span></label>
                                    <input type="text" v-model="form.meta_title.pl" class="input input-bordered input-sm w-full" />
                                </div>
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">Meta Desc (PL)</span></label>
                                    <textarea v-model="form.meta_description.pl" class="textarea textarea-bordered textarea-sm w-full h-24"></textarea>
                                </div>
                                <div class="form-control mb-4">
                                    <label class="label"><span class="label-text">OG Image URL</span></label>
                                    <input type="text" v-model="form.og_image" class="input input-bordered input-sm w-full" placeholder="/storage/media/..." />
                                </div>
                            </div>
                        </div>

                        <div class="divider">Add Blocks</div>
                        <div class="grid grid-cols-2 gap-2">
                            <button @click="store.addBlock('text')" class="btn btn-outline btn-sm justify-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg> Text
                            </button>
                            <button @click="store.addBlock('image')" class="btn btn-outline btn-sm justify-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" /></svg> Image
                            </button>
                        </div>
                    </div>
                    
                    <!-- Active Block Settings -->
                    <div v-else class="animate-in slide-in-from-right-4 fade-in duration-300">
                         <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold flex items-center gap-2"><div class="badge badge-primary badge-sm">{{ store.activeBlock.type }}</div>Settings</h3>
                            <button @click="store.setActiveBlock(null)" class="btn btn-xs btn-outline">← Back to Post</button>
                         </div>
                         
                         <!-- Block Content Fields -->
                         <div v-if="store.activeBlock.type === 'text'" class="space-y-4">
                             <div class="form-control">
                                 <label class="label"><span class="label-text">Content</span></label>
                                 <textarea v-model="store.activeBlock.content.text" class="textarea textarea-bordered textarea-sm h-48"></textarea>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
