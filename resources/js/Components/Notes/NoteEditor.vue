<script setup lang="ts">
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";

const props = withDefaults(
    defineProps<{
        modelValue: string;
    }>(),
    { modelValue: "" }
);

const emit = defineEmits<{
    (e: "update:modelValue", html: string | undefined): void;
}>();

const editor = useEditor({
    extensions: [StarterKit],
    content: props.modelValue,
    onUpdate: () => {
        emit("update:modelValue", editor.value?.getHTML());
    },
});

watch(
    () => props.modelValue,
    (value) => {
        if (editor.value?.getHTML() === value) return;
        editor.value?.commands.setContent(value, false);
    }
);

const isEditable = ref(true);

watch(isEditable, (value) => {
    editor.value?.setEditable(value);
});

onBeforeUnmount(() => {
    editor.value?.destroy();
});
</script>

<template>
    <div class="p-4 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
        <div>
            <input
                type="checkbox"
                :checked="isEditable"
                @change="() => (isEditable = !isEditable)"
            />
            Editable
        </div>
        <editor-content :editor="editor" />
    </div>
</template>
