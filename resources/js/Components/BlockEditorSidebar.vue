<script setup>
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';

const store = useBlockBuilderStore();
</script>

<template>
    <div class="animate-in slide-in-from-right-4 fade-in duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold flex items-center gap-2">
                <div class="badge badge-primary badge-sm">{{ store.activeBlock.type }}</div>
                Settings
            </h3>
            <button @click="store.setActiveBlock(null)" class="btn btn-xs btn-outline">← Back</button>
        </div>

        <div role="tablist" class="tabs tabs-bordered mb-6">
            <!-- Content Tab -->
            <input type="radio" name="block_tabs" role="tab" class="tab" aria-label="Content" checked />
            <div role="tabpanel" class="tab-content pt-4 space-y-4">
                
                <!-- Column Block Controls -->
                <div v-if="store.activeBlock.type === 'columns'" class="space-y-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Number of Columns</span></label>
                        <select v-model="store.activeBlock.content.columns" class="select select-bordered w-full">
                            <option :value="2">2 Columns</option>
                            <option :value="3">3 Columns</option>
                            <option :value="4">4 Columns</option>
                        </select>
                    </div>
                </div>

                <!-- Heading Block Controls -->
                <div v-if="store.activeBlock.type === 'heading'" class="space-y-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Heading Level</span></label>
                        <select v-model="store.activeBlock.content.level" class="select select-bordered w-full">
                            <option value="h1">H1 - Hero</option>
                            <option value="h2">H2 - Section</option>
                            <option value="h3">H3 - Subsection</option>
                            <option value="h4">H4 - Small</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Text</span></label>
                        <input type="text" v-model="store.activeBlock.content.text" class="input input-bordered w-full" />
                    </div>
                </div>

                <!-- HERO -->
                <template v-if="store.activeBlock.type === 'hero'">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Headline</span></label>
                        <input type="text" v-model="store.activeBlock.content.headline" class="input input-bordered input-sm" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Subheadline</span></label>
                        <textarea v-model="store.activeBlock.content.subheadline" class="textarea textarea-bordered textarea-sm"></textarea>
                    </div>
                </template>

                <!-- TEXT -->
                <template v-if="store.activeBlock.type === 'text'">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Content</span></label>
                        <textarea v-model="store.activeBlock.content.text" class="textarea textarea-bordered textarea-sm h-48"></textarea>
                    </div>
                </template>
                
                <!-- NAV -->
                <template v-if="store.activeBlock.type === 'nav'">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Menu Items (JSON)</span></label>
                        <textarea v-model="store.activeBlock.content.items" class="textarea textarea-bordered textarea-sm h-32" placeholder='[{"name":"Home", "link":"/"}]'></textarea>
                    </div>
                </template>
                
                <!-- IMAGE -->
                <template v-if="store.activeBlock.type === 'image'">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Image URL</span></label>
                        <input type="text" v-model="store.activeBlock.content.url" class="input input-bordered input-sm" placeholder="/storage/..." />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Alt Text</span></label>
                        <input type="text" v-model="store.activeBlock.content.alt" class="input input-bordered input-sm" />
                    </div>
                </template>
            </div>

            <!-- Animations Tab -->
            <input type="radio" name="block_tabs" role="tab" class="tab" aria-label="Animations" />
            <div role="tabpanel" class="tab-content pt-4 space-y-4">
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-4">
                        <input type="checkbox" v-model="store.activeBlock.appearance.animations.enabled" class="checkbox checkbox-primary" />
                        <span class="label-text">Enable GSAP Animations</span>
                    </label>
                </div>

                <template v-if="store.activeBlock.appearance.animations.enabled">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Animation Preset</span></label>
                        <select v-model="store.activeBlock.appearance.animations.preset" class="select select-bordered w-full">
                            <option value="fadeUp">Fade Up</option>
                            <option value="fadeIn">Fade In</option>
                            <option value="slideLeft">Slide from Left</option>
                            <option value="scaleIn">Scale In</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Duration (s)</span></label>
                            <input type="number" step="0.1" v-model="store.activeBlock.appearance.animations.duration" class="input input-bordered w-full" />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Delay (s)</span></label>
                            <input type="number" step="0.1" v-model="store.activeBlock.appearance.animations.delay" class="input input-bordered w-full" />
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Trigger</span></label>
                        <select v-model="store.activeBlock.appearance.animations.trigger" class="select select-bordered w-full">
                            <option value="on-load">On Page Load</option>
                            <option value="in-view">On Scroll (In View)</option>
                        </select>
                    </div>
                </template>
                <div v-else class="text-center py-10 opacity-50 bg-base-300 rounded-box border border-dashed border-base-content/20">
                    <p class="text-sm">Animations are disabled for this block.</p>
                </div>
            </div>

            <!-- Appearance Tab -->
            <input type="radio" name="block_tabs" role="tab" class="tab" aria-label="Appearance" />
            <div role="tabpanel" class="tab-content pt-4 space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Custom CSS Classes</span></label>
                    <input type="text" v-model="store.activeBlock.appearance.customClasses" placeholder="e.g. text-center pt-12" class="input input-bordered input-sm w-full font-mono text-xs" />
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs">Bg Color</span></label>
                        <div class="flex">
                            <input type="color" v-model="store.activeBlock.appearance.backgroundColor" class="input input-bordered input-sm p-1 w-10 h-8" />
                            <input type="text" v-model="store.activeBlock.appearance.backgroundColor" class="input input-bordered input-sm w-full text-xs font-mono" />
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs">Text Color</span></label>
                        <div class="flex">
                            <input type="color" v-model="store.activeBlock.appearance.textColor" class="input input-bordered input-sm p-1 w-10 h-8" />
                            <input type="text" v-model="store.activeBlock.appearance.textColor" class="input input-bordered input-sm w-full text-xs font-mono" />
                        </div>
                    </div>
                </div>

                <div class="divider my-2 text-xs opacity-50">Typography</div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text text-xs">Font Size</span></label>
                        <input type="text" v-model="store.activeBlock.appearance.fontSize" placeholder="e.g. 1.25rem" class="input input-bordered input-sm w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text text-xs">Font Weight</span></label>
                        <select v-model="store.activeBlock.appearance.fontWeight" class="select select-bordered select-sm w-full">
                            <option value="normal">Normal</option>
                            <option value="bold">Bold</option>
                            <option value="300">Light</option>
                            <option value="900">Black</option>
                        </select>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label py-1"><span class="label-text text-xs">Text Align</span></label>
                    <div class="join join-horizontal w-full">
                        <button v-for="align in ['left', 'center', 'right', 'justify']" :key="align"
                                @click="store.activeBlock.appearance.textAlign = align"
                                :class="['join-item btn btn-xs flex-1', store.activeBlock.appearance.textAlign === align ? 'btn-primary' : 'btn-outline']">
                            {{ align.charAt(0).toUpperCase() }}
                        </button>
                    </div>
                </div>

                <div class="divider my-2 text-xs opacity-50">Border</div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text text-xs">Radius</span></label>
                        <input type="text" v-model="store.activeBlock.appearance.borderRadius" placeholder="e.g. 1rem" class="input input-bordered input-sm w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text text-xs">Width</span></label>
                        <input type="text" v-model="store.activeBlock.appearance.borderWidth" placeholder="e.g. 2px" class="input input-bordered input-sm w-full" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label py-1"><span class="label-text text-xs">Border Color</span></label>
                    <div class="flex">
                        <input type="color" v-model="store.activeBlock.appearance.borderColor" class="input input-bordered input-sm p-1 w-10 h-8" />
                        <input type="text" v-model="store.activeBlock.appearance.borderColor" class="input input-bordered input-sm w-full text-xs font-mono" />
                    </div>
                </div>

                <div class="divider my-2 text-xs opacity-50">Shadow</div>
                <div class="form-control">
                    <select v-model="store.activeBlock.appearance.boxShadow" class="select select-bordered select-sm w-full">
                        <option value="none">None</option>
                        <option value="0 4px 6px -1px rgb(0 0 0 / 0.1)">Small</option>
                        <option value="0 10px 15px -3px rgb(0 0 0 / 0.1)">Medium</option>
                        <option value="0 25px 50px -12px rgb(0 0 0 / 0.25)">Large</option>
                    </select>
                </div>

                <div class="divider my-2 text-xs opacity-50">Padding</div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text text-xs">Top</span></label>
                        <input type="text" v-model="store.activeBlock.appearance.paddingTop" placeholder="e.g. 2rem" class="input input-bordered input-sm w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text text-xs">Bottom</span></label>
                        <input type="text" v-model="store.activeBlock.appearance.paddingBottom" placeholder="e.g. 2rem" class="input input-bordered input-sm w-full" />
                    </div>
                </div>

                <div class="divider my-2 text-xs opacity-50">Margin</div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text text-xs">Top</span></label>
                        <input type="text" v-model="store.activeBlock.appearance.marginTop" placeholder="e.g. 2rem" class="input input-bordered input-sm w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text text-xs">Bottom</span></label>
                        <input type="text" v-model="store.activeBlock.appearance.marginBottom" placeholder="e.g. 2rem" class="input input-bordered input-sm w-full" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
