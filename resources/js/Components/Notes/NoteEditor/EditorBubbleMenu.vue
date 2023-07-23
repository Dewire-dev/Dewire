<script setup lang="ts">
import { Editor, BubbleMenu } from "@tiptap/vue-3";
import { Badge } from "flowbite-vue";

defineProps<{
    editor?: Editor;
}>();
</script>

<template>
    <BubbleMenu
        v-if="editor"
        :editor="editor"
        :tippy-options="{ duration: 100, placement: 'top-start' }"
        class="flex"
    >
        <Badge
            @click.prevent="editor.chain().focus().toggleBold().run()"
            :type="editor.isActive('bold') ? 'default' : 'dark'"
        >
            <i-carbon-text-bold />
        </Badge>
        <Badge
            @click="editor.chain().focus().toggleItalic().run()"
            :type="editor.isActive('italic') ? 'default' : 'dark'"
        >
            <i-carbon-text-italic />
        </Badge>
        <Badge
            @click="editor.chain().focus().toggleUnderline().run()"
            :type="editor.isActive('underline') ? 'default' : 'dark'"
        >
            <i-carbon-text-underline />
        </Badge>
        <Badge
            @click="editor.chain().focus().toggleStrike().run()"
            :type="editor.isActive('strike') ? 'default' : 'dark'"
        >
            <i-carbon-text-strikethrough />
        </Badge>
        <Badge
            @click="editor.chain().focus().toggleHighlight().run()"
            :type="editor.isActive('highlight') ? 'default' : 'dark'"
        >
            <i-carbon-text-highlight />
        </Badge>
        <Badge
            @click="editor.chain().focus().toggleCode().run()"
            :type="editor.isActive('code') ? 'default' : 'dark'"
        >
            <i-carbon-code />
        </Badge>
    </BubbleMenu>
</template>
