<script setup>
import { ref, markRaw, computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { PhPencilSimple, PhTrash, PhHouse, PhLayout } from '@phosphor-icons/vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ResourceTable from '@/Components/ResourceTable.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

const props = defineProps(['templates']);
const activeLocale = computed(() => usePage().props.locale);
const tableRef = ref(null);
const deleteForm = useForm({});

const breadcrumbs = [
    { label: t('admin.dashboard.title', 'Dashboard'), url: route('admin.dashboard.index'), icon: markRaw(PhHouse) },
    { label: t('admin.menu.templates', 'Templates') }
];

const columns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'title', label: t('admin.templates.title_field', 'Title'), sortable: true },
    { key: 'type', label: t('admin.templates.type_field', 'Type'), sortable: true, optional: true },
    { key: 'is_active', label: t('admin.templates.status_field', 'Status'), sortable: true, optional: true },
    { key: 'actions', label: t('admin.common.actions', 'Actions'), sortable: false, align: 'right' }
];

function deleteTemplate(item) {
    deleteForm.delete(route('admin.templates.destroy', item.id));
}
</script>

<template>
    <Head :title="t('admin.templates.management_title', 'Manage Templates')" />
    <AdminLayout>
        <ResourceTable
            :title="t('admin.menu.templates', 'Templates')"
            :description="t('admin.templates.description', 'Reusable layouts for headers, footers, and global sections.')"
            :icon="markRaw(PhLayout)"
            :breadcrumbs="breadcrumbs"
            :resources="templates"
            :columns="columns"
            :create-route="route('admin.templates.create')"
            :create-label="t('admin.templates.create_btn', 'Create Template')"
            persistence-key="templates"
            ref="tableRef"
            @delete-confirmed="deleteTemplate"
        >
            <template #cell-title="{ item }">
                <Link :href="route('admin.templates.edit', item.id)" class="font-medium hover:text-primary transition-colors">
                    {{ t(item.title) }}
                </Link>
            </template>
            <template #cell-type="{ item }">
                <div class="badge badge-neutral capitalize font-bold bg-base-300 border-none px-3">
                    {{ item.type }}
                </div>
            </template>

            <template #cell-actions="{ item }">
                <div class="flex justify-end gap-2">
                    <Link :href="route('admin.templates.edit', item.id)" class="btn btn-sm btn-ghost btn-square hover:bg-primary/10 hover:text-primary transition-all" :title="t('admin.common.edit', 'Edit')">
                        <PhPencilSimple weight="regular" class="w-4 h-4" />
                    </Link>
                    <button @click="tableRef?.openDeleteModal(item)" class="btn btn-sm btn-ghost btn-square hover:bg-error/10 hover:text-error transition-all" :title="t('admin.common.delete', 'Delete')">
                        <PhTrash weight="regular" class="w-4 h-4" />
                    </button>
                </div>
            </template>
        </ResourceTable>
    </AdminLayout>
</template>
