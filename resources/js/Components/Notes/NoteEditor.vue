<script setup lang="ts">
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Underline from "@tiptap/extension-underline";
import Highlight from "@tiptap/extension-highlight";
import Subscript from "@tiptap/extension-subscript";
import Superscript from "@tiptap/extension-superscript";

const props = withDefaults(
    defineProps<{
        modelValue?: string;
    }>(),
    { modelValue: undefined }
);

const emit = defineEmits<{
    (e: "update:modelValue", html?: string): void;
}>();

const editor = useEditor({
    extensions: [StarterKit, Underline, Highlight, Subscript, Superscript],
    editorProps: {
        attributes: {
            class: "prose dark:prose-invert prose-sm sm:prose-base lg:prose-lg xl:prose-2xl m-5 focus:outline-none",
        },
    },
    content: props.modelValue,
    onUpdate: () => {
        emit("update:modelValue", editor.value?.getHTML());
    },
});

watch(
    () => props.modelValue,
    (value) => {
        if (!value || editor.value?.getHTML() === value) return;
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
    <div
        class="p-5 text-gray-900 bg-gray-100 border-2 border-gray-600 rounded-md dark:bg-gray-900 dark:text-white"
    >
        <!-- <div>
            <input
                type="checkbox"
                :checked="isEditable"
                @change="() => (isEditable = !isEditable)"
            />
            Editable
        </div> -->
        <EditorBubbleMenu :editor="editor" />
        <EditorFloatingMenu :editor="editor" />
        <editor-content :editor="editor" />
    </div>
</template>
