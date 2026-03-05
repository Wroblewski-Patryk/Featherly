<template>
    <AdminLayout :full-width="true">
        <BlockBuilder 
            title="Form" 
            save-label="Save Form"
            back-label="Back"
            :back-route="route('admin.forms.index')"
            :categories="formCategories"
            :saving="form.processing"
            @save="save"
        >
            <template #info>
                <div class="form-control">
                    <label class="label"><span class="label-text">Form Title</span></label>
                    <input type="text" v-model="form.name" class="input input-bordered input-sm" placeholder="e.g. Contact Us" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Success Message</span></label>
                    <textarea v-model="form.settings.success_message" class="textarea textarea-bordered textarea-sm h-20" placeholder="Thank you for your message!"></textarea>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Notification Email</span></label>
                    <input type="email" v-model="form.settings.notification_email" class="input input-bordered input-sm" placeholder="admin@example.com" />
                </div>
            </template>

            <template #canvas-header>
                <div class="p-12 bg-primary/5 border-b border-black/5 flex flex-col items-center text-center">
                    <h1 class="text-4xl font-black mb-2">{{ form.name || 'Untitled Form' }}</h1>
                    <p class="opacity-40 text-sm">Preview of the generated form interface</p>
                </div>
            </template>
        </BlockBuilder>
    </AdminLayout>
</template>

<script setup>
import { PhTextbox } from '@phosphor-icons/vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import BlockBuilder from '@/Components/BlockBuilder.vue';
import { useForm } from '@inertiajs/vue3';
import { useBlockBuilderStore } from '@/Stores/useBlockBuilderStore';
import { onMounted, computed } from 'vue';

const props = defineProps({
    form_data: Object,
    menus: Array
});

const store = useBlockBuilderStore();

const blocks = computed({
    get: () => store.blocks,
    set: (value) => {
        store.blocks = value;
        store.isDirty = true;
    }
});
const viewport = ref('desktop');
const leftTab = ref('blocks');

const categories = ref([
    {
        id: 'forms',
        name: 'Form Fields',
        icon: 'Textbox',
        blocks: [
            { type: 'form_input', label: 'Text Input', icon: 'TextT' },
            { type: 'form_textarea', label: 'Long Text', icon: 'TextAlignLeft' },
            { type: 'form_select', label: 'Dropdown', icon: 'ListBullets' },
            { type: 'button', label: 'Submit Button', icon: 'CursorClick' },
        ]
    },
    {
        id: 'content',
        name: 'Design Elements',
        icon: 'PaintBrush',
        blocks: [
            { type: 'heading', label: 'Heading', icon: 'TextHOne' },
            { type: 'paragraph', label: 'Instruction', icon: 'Paragraph' },
            { type: 'image', label: 'Illustration', icon: 'Image' },
            { type: 'divider', label: 'Divider', icon: 'Minus' },
            { type: 'spacer', label: 'Spacer', icon: 'ArrowsVertical' },
        ]
    },
    {
        id: 'layout',
        name: 'Structure',
        icon: 'SquaresFour',
        blocks: [
            { type: 'columns', label: 'Side by Side', icon: 'Columns' },
            { type: 'group', label: 'Field Group', icon: 'ObjectGroup' },
        ]
    }
]);

const cloneBlock = (block) => {
    return store.createBlockObject(block.type);
};

const form = useForm({
    name: props.form_data?.name || '',
    content: props.form_data?.content || [],
    settings: props.form_data?.settings || { success_message: 'Message sent!', notification_email: '', submit_url: '' },
});

onMounted(() => {
    store.init(props.form_data?.content || []);
});

const save = () => {
    form.content = store.blocks;
    if (props.form_data?.id) {
        form.put(route('admin.forms.update', props.form_data.id), {
            onSuccess: () => store.isDirty = false
        });
    } else {
        form.post(route('admin.forms.store'), {
            onSuccess: () => store.isDirty = false
        });
    }
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.1);
}

.ghost-block {
    opacity: 0.5;
    background: #c8ebfb;
    border: 2px dashed #000;
}
</style>
