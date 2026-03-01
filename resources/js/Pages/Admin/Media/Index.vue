<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps(['media']);

const uploadForm = useForm({
    file: null,
    alt_text: ''
});

const deleteForm = useForm({});
const fileInput = ref(null);

function submitUpload() {
    uploadForm.post('/admin/media', {
        onSuccess: () => {
            uploadForm.reset();
            if (fileInput.value) fileInput.value.value = '';
        }
    });
}

function handleFileChange(event) {
    uploadForm.file = event.target.files[0];
}

function deleteMedia(id) {
    if (confirm('Are you sure you want to delete this media file?')) {
        deleteForm.delete(`/admin/media/${id}`);
    }
}
</script>

<template>
    <Head title="Media Library" />
    <AdminLayout>
        <div class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold">Media Library</h1>
                
                <form @submit.prevent="submitUpload" class="flex items-center gap-2 bg-base-100 p-2 rounded-box shadow-sm border border-base-200">
                    <input type="file" @change="handleFileChange" class="file-input file-input-bordered file-input-sm w-full max-w-xs" accept="image/*" required ref="fileInput" />
                    <input type="text" v-model="uploadForm.alt_text" placeholder="Alt Text (optional)" class="input input-bordered input-sm" />
                    <button type="submit" class="btn btn-primary btn-sm" :disabled="uploadForm.processing">
                        <span v-if="uploadForm.processing" class="loading loading-spinner loading-xs"></span>
                        Upload
                    </button>
                </form>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <div v-for="item in media.data" :key="item.id" class="card bg-base-100 shadow-sm border border-base-200 relative group overflow-hidden">
                    <figure class="aspect-square bg-base-200">
                        <img :src="'/storage/' + item.path" :alt="item.alt_text" class="object-cover w-full h-full" />
                    </figure>
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <button @click="deleteMedia(item.id)" class="btn btn-error btn-sm btn-circle text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                    <div class="p-2 text-xs truncate" :title="item.path">
                        {{ item.path.split('/').pop() }}
                    </div>
                </div>

                <div v-if="media.data.length === 0" class="col-span-full py-12 text-center text-base-content/50 border-2 border-dashed border-base-300 rounded-box">
                    No media files found. Upload some images above!
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
