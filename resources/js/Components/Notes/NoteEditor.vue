<script setup lang="ts">
import { useEditor, EditorContent, type JSONContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";

const props = withDefaults(
    defineProps<{
        modelValue?: JSONContent;
    }>(),
    { modelValue: undefined }
);

const emit = defineEmits<{
    (e: "update:modelValue", json?: JSONContent): void;
}>();

const editor = useEditor({
    extensions: [StarterKit],
    editorProps: {
        attributes: {
            class: "prose dark:prose-invert prose-sm sm:prose-base lg:prose-lg xl:prose-2xl m-5 focus:outline-none",
        },
    },
    content: props.modelValue,
    onUpdate: () => {
        emit("update:modelValue", editor.value?.getJSON());
    },
});

watch(
    () => props.modelValue,
    (value) => {
        if (
            !value ||
            JSON.stringify(editor.value?.getJSON()) === JSON.stringify(value)
        )
            return;
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
