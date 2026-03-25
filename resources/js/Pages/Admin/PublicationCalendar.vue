<script setup>
import { computed, markRaw } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { PhCalendarBlank, PhClockCountdown, PhFileText, PhFeather, PhCards, PhHouse } from '@phosphor-icons/vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/features/admin/shared/components/ModuleHeader.vue';

const props = defineProps({
    calendar_days: {
        type: Array,
        default: () => [],
    },
    totals: {
        type: Object,
        default: () => ({ items: 0, days: 0, types: {} }),
    },
});

const typeMeta = {
    page: { label: 'Page', icon: PhFileText, badgeClass: 'badge-primary' },
    post: { label: 'Post', icon: PhFeather, badgeClass: 'badge-secondary' },
    project: { label: 'Project', icon: PhCards, badgeClass: 'badge-accent' },
};

const flattenedItems = computed(() => props.calendar_days.flatMap((day) => day.items ?? []));

const typeCount = computed(() => {
    const initial = { page: 0, post: 0, project: 0 };
    for (const item of flattenedItems.value) {
        if (Object.prototype.hasOwnProperty.call(initial, item.type)) {
            initial[item.type] += 1;
        }
    }
    return initial;
});
</script>

<template>
    <Head title="Publication Calendar" />

    <AdminLayout>
        <div class="space-y-6">
            <div class="bg-base-100 p-6 rounded-box shadow-sm border border-base-300">
                <ModuleHeader
                    title="Publication Calendar"
                    description="Planned content items grouped by publication date."
                    :breadcrumbs="[
                        { label: 'Dashboard', icon: markRaw(PhHouse), href: route('admin.dashboard.index') },
                        { label: 'Publication Calendar', icon: markRaw(PhCalendarBlank) }
                    ]"
                    :icon="markRaw(PhCalendarBlank)"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="stat bg-base-100 rounded-box border border-base-300 shadow-sm">
                    <div class="stat-figure text-primary"><PhClockCountdown class="w-6 h-6" /></div>
                    <div class="stat-title">Planned Items</div>
                    <div class="stat-value text-primary">{{ totals.items ?? 0 }}</div>
                    <div class="stat-desc">Across {{ totals.days ?? 0 }} calendar day(s)</div>
                </div>

                <div class="stat bg-base-100 rounded-box border border-base-300 shadow-sm">
                    <div class="stat-title">Pages</div>
                    <div class="stat-value">{{ typeCount.page }}</div>
                </div>

                <div class="stat bg-base-100 rounded-box border border-base-300 shadow-sm">
                    <div class="stat-title">Posts</div>
                    <div class="stat-value">{{ typeCount.post }}</div>
                </div>

                <div class="stat bg-base-100 rounded-box border border-base-300 shadow-sm">
                    <div class="stat-title">Projects</div>
                    <div class="stat-value">{{ typeCount.project }}</div>
                </div>
            </div>

            <div v-if="calendar_days.length" class="space-y-4">
                <div
                    v-for="day in calendar_days"
                    :key="day.date"
                    class="bg-base-100 border border-base-300 rounded-box shadow-sm"
                >
                    <div class="px-5 py-4 border-b border-base-200 flex items-center justify-between gap-4">
                        <h2 class="font-semibold text-lg">{{ day.date }}</h2>
                        <span class="badge badge-outline">{{ day.count }} item(s)</span>
                    </div>

                    <div class="divide-y divide-base-200">
                        <div
                            v-for="item in day.items"
                            :key="`${item.type}-${item.id}`"
                            class="px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3"
                        >
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="badge" :class="typeMeta[item.type]?.badgeClass ?? 'badge-outline'">
                                        {{ typeMeta[item.type]?.label ?? item.type }}
                                    </span>
                                    <span class="text-sm opacity-70">{{ item.published_at_label }}</span>
                                </div>
                                <p class="font-medium">{{ item.title }}</p>
                            </div>
                            <Link class="btn btn-sm btn-outline" :href="item.edit_url">
                                Open
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="alert bg-base-100 border border-base-300 shadow-sm">
                <span>No planned items found. Set status to planned and choose a publication date.</span>
            </div>
        </div>
    </AdminLayout>
</template>
