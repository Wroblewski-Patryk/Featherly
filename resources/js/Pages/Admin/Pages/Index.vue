<script setup>
import { ref, markRaw } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { PhPencilSimple, PhTrash, PhHouse, PhFileText } from '@phosphor-icons/vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ResourceTable from '@/Components/ResourceTable.vue';

const props = defineProps(['pages']);
const tableRef = ref(null);
const deleteForm = useForm({});

const breadcrumbs = [
    { label: 'Admin', url: '/admin', icon: markRaw(PhHouse) },
    { label: 'Pages' }
];

const columns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'title', label: 'Title', sortable: true },
    { key: 'slug', label: 'Slug', sortable: true, optional: true },
    { key: 'created_at', label: 'Created At', sortable: true, optional: true },
    { key: 'actions', label: 'Actions', sortable: false, align: 'right' }
];

function deletePage(item) {
    deleteForm.delete(`/admin/pages/${item.id}`);
}
</script>

<template>
    <Head title="Manage Pages" />
    <AdminLayout>
        <ResourceTable
            title="Pages"
            description="Manage your website pages and visual content."
            :icon="markRaw(PhFileText)"
            :breadcrumbs="breadcrumbs"
            :resources="pages"
            :columns="columns"
            create-route="/admin/pages/create"
            create-label="Create Page"
            persistence-key="pages"
            ref="tableRef"
            @delete-confirmed="deletePage"
        >
            <template #cell-slug="{ item }">
                <span class="text-xs font-mono bg-base-200 p-1 px-2 rounded-lg opacity-70 group-hover:opacity-100 transition-opacity">
                    {{ item.slug?.pl || item.slug?.en || item.slug }}
                </span>
            </template>

            <template #cell-actions="{ item }">
                <div class="flex justify-end gap-2">
                    <Link :href="`/admin/pages/${item.id}/edit`" class="btn btn-sm btn-ghost btn-square hover:bg-primary/10 hover:text-primary transition-all">
                        <PhPencilSimple weight="regular" class="w-4 h-4" />
                    </Link>
                    <button @click="tableRef?.openDeleteModal(item)" class="btn btn-sm btn-ghost btn-square hover:bg-error/10 hover:text-error transition-all">
                        <PhTrash weight="regular" class="w-4 h-4" />
                    </button>
                </div>
            </template>
        </ResourceTable>
    </AdminLayout>
</template>
