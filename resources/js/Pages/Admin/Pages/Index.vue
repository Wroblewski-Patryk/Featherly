<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps(['pages']);
const deleteForm = useForm({});

function deletePage(id) {
    if (confirm('Are you sure you want to delete this page?')) {
        deleteForm.delete(`/admin/pages/${id}`);
    }
}
</script>

<template>
    <Head title="Manage Pages" />
    <AdminLayout>
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Pages</h1>
                <Link href="/admin/pages/create" class="btn btn-primary">Create Page</Link>
            </div>
            
            <div class="overflow-x-auto bg-base-100 rounded-box shadow-sm border border-base-200">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="page in pages.data" :key="page.id">
                            <td>{{ page.id }}</td>
                            <!-- Spatie translates into arrays, so we show 'pl' or raw fallback -->
                            <td class="font-medium">{{ page.title?.pl || page.title?.en || page.title }}</td>
                            <td><span class="text-xs font-mono bg-base-200 p-1 rounded">{{ page.slug?.pl || page.slug?.en || page.slug }}</span></td>
                            <td>{{ new Date(page.created_at).toLocaleDateString() }}</td>
                            <td class="flex gap-2">
                                <Link :href="`/admin/pages/${page.id}/edit`" class="btn btn-sm btn-ghost">Edit</Link>
                                <button @click="deletePage(page.id)" class="btn btn-sm btn-error btn-outline">Delete</button>
                            </td>
                        </tr>
                        <tr v-if="pages.data.length === 0">
                            <td colspan="5" class="text-center py-8 text-base-content/50">No pages found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="join mt-4 flex justify-center" v-if="pages.links.length > 3">
                <Link 
                    v-for="(link, k) in pages.links" 
                    :key="k" 
                    :href="link.url || '#'" 
                    class="join-item btn btn-sm"
                    :class="{'btn-active': link.active, 'btn-disabled': !link.url}"
                    v-html="link.label" />
            </div>
        </div>
    </AdminLayout>
</template>
