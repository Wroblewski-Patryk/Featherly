import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useToastStore = defineStore('toast', () => {
    const toasts = ref([]);

    const add = (toast) => {
        const id = Date.now() + Math.random().toString(36).substr(2, 9);
        const newToast = {
            id,
            message: toast.message || '',
            type: toast.type || 'info', // info, success, warning, error
            duration: toast.duration || 3000,
        };

        toasts.value.push(newToast);

        if (newToast.duration > 0) {
            setTimeout(() => {
                remove(id);
            }, newToast.duration);
        }

        return id;
    };

    const success = (message, duration = 3000) => add({ message, type: 'success', duration });
    const error = (message, duration = 5000) => add({ message, type: 'error', duration });
    const warning = (message, duration = 4000) => add({ message, type: 'warning', duration });
    const info = (message, duration = 3000) => add({ message, type: 'info', duration });

    const remove = (id) => {
        const index = toasts.value.findIndex(t => t.id === id);
        if (index !== -1) {
            toasts.value.splice(index, 1);
        }
    };

    return {
        toasts,
        add,
        success,
        error,
        warning,
        info,
        remove
    };
});
