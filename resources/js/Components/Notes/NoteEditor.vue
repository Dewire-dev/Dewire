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

onBeforeUnmount(() => {
    editor.value?.destroy();
});
</script>

<template>
    <editor-content :editor="editor" class="editor" />
</template>

<style scoped lang="scss">
.editor {
    @apply bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white
}
</style>
