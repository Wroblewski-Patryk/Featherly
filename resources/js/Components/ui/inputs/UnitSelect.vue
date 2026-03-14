<template>
    <select
        :value="modelValue"
        :disabled="disabled"
        @change="emit('update:modelValue', $event.target.value)"
        :class="selectClasses"
    >
        <option v-for="option in normalizedOptions" :key="option.value" :value="option.value">
            {{ option.label }}
        </option>
    </select>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: { type: String, default: 'px' },
    options: {
        type: Array,
        default: () => ([
            { value: 'px', label: 'PX' },
            { value: '%', label: '%' },
            { value: 'em', label: 'EM' },
            { value: 'rem', label: 'REM' },
            { value: 'vh', label: 'VH' },
            { value: 'vw', label: 'VW' }
        ])
    },
    widthClass: { type: String, default: 'w-20' },
    joinItem: { type: Boolean, default: false },
    muted: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    extraClass: { type: String, default: '' }
});

const emit = defineEmits(['update:modelValue']);

const normalizedOptions = computed(() =>
    props.options.map((opt) => {
        if (typeof opt === 'string') {
            return { value: opt, label: opt.toUpperCase() };
        }
        return { value: opt.value, label: opt.label ?? String(opt.value).toUpperCase() };
    })
);

const selectClasses = computed(() => [
    'select select-bordered select-sm h-8 min-h-0 bg-base-100 shadow-none',
    props.widthClass,
    props.joinItem ? 'join-item' : '',
    props.muted ? 'opacity-60 hover:opacity-100 transition-opacity' : '',
    props.disabled ? 'cursor-not-allowed opacity-50' : '',
    props.extraClass
]);
</script>
