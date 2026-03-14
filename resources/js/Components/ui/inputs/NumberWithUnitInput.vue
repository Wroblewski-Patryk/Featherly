<template>
    <div class="join w-full">
        <input
            type="number"
            :value="numericValue"
            :disabled="disabled"
            @input="handleInput($event.target.value)"
            class="input input-sm input-bordered join-item h-8 min-h-0 w-full border-r-0 bg-base-100 font-mono shadow-none focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
            :class="disabled ? 'cursor-not-allowed opacity-50' : ''"
            :placeholder="placeholder"
        />
        <UnitSelect
            v-model="localUnit"
            :options="units"
            :join-item="true"
            :disabled="disabled"
            width-class="w-20"
            extra-class="rounded-l-none"
        />
    </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import UnitSelect from './UnitSelect.vue';

const props = defineProps({
    modelValue: { type: String, default: '' },
    placeholder: { type: String, default: 'auto' },
    disabled: { type: Boolean, default: false },
    units: {
        type: Array,
        default: () => ['px', '%', 'rem', 'em', 'vh', 'vw']
    }
});

const emit = defineEmits(['update:modelValue']);

const localUnit = ref('px');

watch(
    () => props.modelValue,
    (newVal) => {
        if (!newVal) return;
        const match = String(newVal).match(/[a-zA-Z%]+$/);
        if (match) {
            localUnit.value = match[0];
        }
    },
    { immediate: true }
);

const numericValue = computed(() => {
    if (!props.modelValue) return '';
    const match = String(props.modelValue).match(/^-?\d*\.?\d+/);
    return match ? match[0] : '';
});

const handleInput = (val) => {
    if (val === '' || val === null || val === undefined) {
        emit('update:modelValue', undefined);
        return;
    }
    emit('update:modelValue', `${val}${localUnit.value}`);
};

watch(localUnit, () => {
    if (numericValue.value !== '') {
        emit('update:modelValue', `${numericValue.value}${localUnit.value}`);
    }
});
</script>
