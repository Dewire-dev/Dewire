<script setup lang="ts">
import { useEditor, EditorContent, FloatingMenu, type JSONContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import { Button } from "flowbite-vue";

const props = withDefaults(
    defineProps<{
        modelValue?: JSONContent | string;
    }>(),
    { modelValue: "" }
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
        if (JSON.stringify(editor.value?.getJSON()) === JSON.stringify(value))
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
    <div class="p-5 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
        <div>
            <input
                type="checkbox"
                :checked="isEditable"
                @change="() => (isEditable = !isEditable)"
            />
            Editable
        </div>
        <FloatingMenu
            v-if="editor"
            :editor="editor"
            :tippy-options="{ duration: 100 }"
            class="flex gap-2"
        >
            <Button
                color="light"
                @click="
                    editor?.chain().focus().toggleHeading({ level: 1 }).run()
                "
                :class="{
                    'is-active': editor.isActive('heading', { level: 1 }),
                }"
            >
                H1
            </Button>
            <Button
                color="light"
                @click="
                    editor?.chain().focus().toggleHeading({ level: 2 }).run()
                "
                :class="{
                    'is-active': editor.isActive('heading', { level: 2 }),
                }"
            >
                H2
            </Button>
            <Button
                color="light"
                @click="editor?.chain().focus().toggleBulletList().run()"
                :class="{ 'is-active': editor.isActive('bulletList') }"
            >
                Bullet List
            </Button>
        </FloatingMenu>
        <editor-content :editor="editor" />
    </div>
</template>
