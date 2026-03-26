<template>
    <div
        ref="rootRef"
        class="dropdown dropdown-end"
        :class="{ 'dropdown-open': isOpen }"
    >
        <button
            type="button"
            :tabindex="tabindex"
            :class="triggerClasses"
            @click.stop="toggleOpen"
        >
            <slot name="trigger" />
        </button>
        <ul :tabindex="tabindex" :class="menuClasses" @click="handleMenuClick">
            <slot />
        </ul>
    </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    triggerClass: {
        type: String,
        default: ''
    },
    menuClass: {
        type: String,
        default: ''
    },
    tabindex: {
        type: Number,
        default: 0
    }
});

const rootRef = ref(null);
const isOpen = ref(false);
const instanceId = `topbar-dropdown-${Math.random().toString(36).slice(2)}`;

const triggerClasses = computed(() => [
    'btn btn-ghost border border-base-200 bg-base-100/70 shadow-sm transition-all hover:border-base-300 hover:bg-base-200/60 cursor-pointer list-none pointer-events-auto',
    props.triggerClass
]);

const menuClasses = computed(() => [
    'mt-3 z-[60] p-2 shadow-xl menu menu-sm dropdown-content bg-base-100 rounded-box border border-base-200',
    props.menuClass
]);

function closeDropdown() {
    if (isOpen.value) {
        isOpen.value = false;
    }
}

function toggleOpen() {
    const shouldOpen = !isOpen.value;
    isOpen.value = shouldOpen;

    if (shouldOpen) {
        window.dispatchEvent(new CustomEvent('topbar-dropdown-open', {
            detail: { id: instanceId }
        }));
    }
}

function handleDocumentPointerDown(event) {
    if (!isOpen.value || !rootRef.value) return;
    if (!rootRef.value.contains(event.target)) {
        closeDropdown();
    }
}

function handleEscape(event) {
    if (event.key === 'Escape') {
        closeDropdown();
    }
}

function handleMenuClick(event) {
    const target = event?.target;
    if (target?.closest('a,button')) {
        closeDropdown();
    }
}

function handleOtherDropdownOpened(event) {
    if (event?.detail?.id !== instanceId) {
        closeDropdown();
    }
}

onMounted(() => {
    document.addEventListener('pointerdown', handleDocumentPointerDown);
    document.addEventListener('keydown', handleEscape);
    window.addEventListener('topbar-dropdown-open', handleOtherDropdownOpened);
});

onBeforeUnmount(() => {
    document.removeEventListener('pointerdown', handleDocumentPointerDown);
    document.removeEventListener('keydown', handleEscape);
    window.removeEventListener('topbar-dropdown-open', handleOtherDropdownOpened);
});
</script>
