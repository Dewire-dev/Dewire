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
            color="light"
            @click="editor?.chain().focus().toggleHeading({ level: 1 }).run()"
            :class="{
                'is-active': editor.isActive('heading', { level: 1 }),
            }"
        >
            H1
        </Button>
        <Button
            color="light"
            @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()"
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
</template>
