<script setup>
import { ref, watch } from 'vue';
import { PhFolderPlus, PhX, PhPencilSimple } from '@phosphor-icons/vue';

const props = defineProps({
    isOpen: Boolean,
    processing: Boolean,
    folder: Object // If provided, we are in RENAME mode
});

const emit = defineEmits(['close', 'submit']);

const name = ref('');

watch(() => props.folder, (newFolder) => {
    name.value = newFolder ? newFolder.name : '';
}, { immediate: true });

const handleSubmit = () => {
    if (!name.value) return;
    emit('submit', name.value);
};
</script>

<template>
    <dialog class="modal" :class="isOpen ? 'modal-open' : ''">
        <div class="modal-box border border-base-300 shadow-xl rounded-box p-6 max-w-md">
            <button @click="$emit('close')" class="btn btn-ghost btn-sm btn-square absolute right-8 top-8"><PhX class="w-5 h-5" /></button>

            <div class="flex items-center gap-5 mb-10">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                    <PhPencilSimple v-if="folder" weight="fill" class="w-6 h-6" />
                    <PhFolderPlus v-else weight="fill" class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-black text-xl tracking-tight">{{ folder ? 'Zmień nazwę' : 'Nowy folder' }}</h3>
                    <p class="text-[9px] opacity-40 uppercase font-black tracking-widest mt-0.5">Uporządkuj swoje pliki</p>
                </div>
            </div>
            
            <form @submit.prevent="handleSubmit" class="space-y-8">
                <div class="form-control group">
                    <label class="label"><span class="label-text font-black opacity-30 text-[10px] uppercase tracking-widest mb-1">Nazwa folderu</span></label>
                    <input 
                        v-model="name" 
                        type="text" 
                        placeholder="np. Kampania Letnia" 
                        class="input input-bordered w-full focus:input-primary h-12 text-base font-bold px-4 bg-base-100 transition-all shadow-sm" 
                        required 
                        autofocus
                    />
                </div>
                
                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" @click="$emit('close')" class="btn btn-ghost h-12 px-6 font-bold">Anuluj</button>
                    <button type="submit" class="btn btn-primary h-12 px-8 font-bold shadow-lg shadow-primary/20" :disabled="processing">
                        <span v-if="processing" class="loading loading-spinner"></span>
                        {{ folder ? 'Zapisz' : 'Utwórz' }}
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop" @click="$emit('close')">
            <button>close</button>
        </form>
    </dialog>
</template>
