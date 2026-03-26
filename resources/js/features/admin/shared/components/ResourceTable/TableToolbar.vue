<script setup>
import { Link } from '@inertiajs/vue3';
import { PhSlidersHorizontal, PhPlus } from '@phosphor-icons/vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

const props = defineProps({
    search: String,
    searchPlaceholder: String,
    toggleableColumns: {
        type: Array,
        default: () => []
    },
    visibleColumns: {
        type: Array,
        default: () => []
    },
    createRoute: String,
    createLabel: String,
    persistenceKey: String
});

const emit = defineEmits(['update:search', 'update:visibleColumns']);

function toggleColumn(key) {
    let newVisible = [...props.visibleColumns];
    if (newVisible.includes(key)) {
        newVisible = newVisible.filter(k => k !== key);
    } else {
        newVisible.push(key);
    }

    emit('update:visibleColumns', newVisible);

    if (props.persistenceKey) {
        localStorage.setItem(`resource-table-columns-${props.persistenceKey}`, JSON.stringify(newVisible));
    }
}
</script>

<template>
    <div class="flex items-center gap-3 w-full md:w-auto mt-4 md:mt-0 justify-end flex-wrap">
        <!-- Column Toggle -->
        <div v-if="toggleableColumns.length > 0" class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-square bg-base-100 border-base-200 shadow-sm hover:shadow-md hover:border-primary/40 text-base-content/60 hover:text-primary transition-all">
                <PhSlidersHorizontal class="text-lg" />
            </label>
            <div tabindex="0" class="dropdown-content z-[20] p-2 shadow-2xl bg-base-100 rounded-box w-56 mt-3 border border-base-200">
                <p class="px-2 py-1 text-xs uppercase tracking-wider font-bold opacity-60">
                    {{ t('admin.common.toggle_columns', 'Toggle columns') }}
                </p>
                <div class="space-y-0.5 mt-1">
                    <label
                        v-for="col in toggleableColumns"
                        :key="col.key"
                        class="w-full flex items-center justify-between gap-2 cursor-pointer hover:bg-base-200 px-2 py-2 rounded-box transition-colors group/item"
                    >
                        <span class="label-text font-semibold group-hover/item:text-primary transition-colors text-left">{{ col.label }}</span>
                        <input
                            type="checkbox"
                            :checked="visibleColumns.includes(col.key)"
                            @change="toggleColumn(col.key)"
                            class="toggle toggle-primary toggle-sm"
                        />
                    </label>
                </div>
            </div>
        </div>

        <slot name="actions"></slot>

        <Link v-if="createRoute" :href="createRoute" class="btn btn-primary shadow-lg shadow-primary/20 hover:shadow-xl hover:-translate-y-0.5 transition-all">
            <PhPlus weight="bold" class="mr-1" /> {{ createLabel || t('admin.common.create', 'Create') }}
        </Link>
    </div>
</template>
