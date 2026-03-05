<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { PhPencilSimple, PhTrash, PhHouse, PhList } from '@phosphor-icons/vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ResourceTable from '@/Components/ResourceTable.vue';

import { ref, markRaw } from 'vue';
defineProps(['menus']);
const tableRef = ref(null);

const breadcrumbs = [
    { label: 'Admin', url: '/admin', icon: markRaw(PhHouse) },
    { label: 'Menus' }
];

const columns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'name', label: 'Name', sortable: true },
    { key: 'items_count', label: 'Items', sortable: false, align: 'center', optional: true },
    { key: 'created_at', label: 'Created At', sortable: true, optional: true },
    { key: 'actions', label: 'Actions', sortable: false, align: 'right' }
];

function deleteMenu(item) {
    router.delete(`/admin/menus/${item.id}`);
}
</script>

<template>
    <Head title="Menus Management" />
    <AdminLayout>
        <ResourceTable
            title="Menus"
            description="Build and organize your site's navigation structures."
            :icon="markRaw(PhList)"
            :breadcrumbs="breadcrumbs"
            :resources="menus"
            :columns="columns"
            create-route="/admin/menus/create"
            create-label="Create Menu"
            persistence-key="menus"
            ref="tableRef"
            @delete-confirmed="deleteMenu"
        >
            <template #cell-items_count="{ item }">
                <div class="badge badge-primary badge-outline badge-sm rounded-full px-3 font-medium border-opacity-20 text-[10px]">
                    {{ (item.items || []).length }} LINKS
                </div>
            </template>

            <template #cell-actions="{ item }">
                <div class="flex justify-end gap-2">
                    <Link :href="`/admin/menus/${item.id}/edit`" class="btn btn-sm btn-ghost btn-square hover:bg-primary/10 hover:text-primary transition-all">
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
