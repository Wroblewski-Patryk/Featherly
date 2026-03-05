<script setup>
import { ref, markRaw } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PhPencilSimple, PhTrash, PhHouse, PhTextbox } from '@phosphor-icons/vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ResourceTable from '@/Components/ResourceTable.vue';

const props = defineProps(['forms']);
const tableRef = ref(null);
const deleteForm = useForm({});

const breadcrumbs = [
    { label: 'Admin', url: '/admin', icon: markRaw(PhHouse) },
    { label: 'Forms' }
];

const columns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'name', label: 'Name', sortable: true },
    { key: 'created_at', label: 'Created At', sortable: true, optional: true },
    { key: 'actions', label: 'Actions', sortable: false, align: 'right' }
];

function deleteFormItem(item) {
    deleteForm.delete(`/admin/forms/${item.id}`);
}
</script>

<template>
    <Head title="Manage Forms" />
    <AdminLayout>
        <ResourceTable
            title="Forms"
            description="Capture leads and feedback with custom-built forms."
            :icon="markRaw(PhTextbox)"
            :breadcrumbs="breadcrumbs"
            :resources="forms"
            :columns="columns"
            create-route="/admin/forms/create"
            create-label="Create Form"
            persistence-key="forms"
            ref="tableRef"
            @delete-confirmed="deleteFormItem"
        >
            <template #cell-actions="{ item }">
                <div class="flex justify-end gap-2">
                    <Link :href="`/admin/forms/${item.id}/edit`" class="btn btn-sm btn-ghost btn-square hover:bg-primary/10 hover:text-primary transition-all">
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
