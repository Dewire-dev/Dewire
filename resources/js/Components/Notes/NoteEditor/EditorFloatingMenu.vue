<script setup lang="ts">
import { Editor, FloatingMenu } from "@tiptap/vue-3";
import { Button } from "flowbite-vue";

defineProps<{
    editor?: Editor;
}>();
</script>

<template>
    <FloatingMenu
        v-if="editor"
        :editor="editor"
        :tippy-options="{ duration: 100 }"
        class="flex gap-2"
    >
        <Button
            @click="editor?.chain().focus().toggleHeading({ level: 1 }).run()"
            :color="
                editor.isActive('heading', { level: 1 }) ? 'default' : 'light'
            "
        >
            H1
        </Button>
        <Button
            @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()"
            :color="
                editor.isActive('heading', { level: 2 }) ? 'default' : 'light'
            "
        >
            H2
        </Button>
        <Button
            @click="editor?.chain().focus().toggleBulletList().run()"
            :color="editor.isActive('bulletList') ? 'default' : 'light'"
        >
            Bullet List
        </Button>
    </FloatingMenu>
</template>
