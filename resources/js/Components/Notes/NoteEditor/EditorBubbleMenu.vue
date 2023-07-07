<script setup lang="ts">
import { Editor, BubbleMenu } from "@tiptap/vue-3";

defineProps<{
    editor?: Editor;
}>();
</script>

<template>
    <BubbleMenu
        v-if="editor"
        :editor="editor"
        :tippy-options="{ duration: 100 }"
    >
        <span
            @click="editor.chain().focus().toggleBold().run()"
            class="badge"
            :class="{ active: editor.isActive('bold') }"
        >
            bold
        </span>
        <span
            @click="editor.chain().focus().toggleItalic().run()"
            class="badge"
            :class="{ active: editor.isActive('italic') }"
        >
            italic
        </span>
        <span
            @click="editor.chain().focus().toggleStrike().run()"
            class="badge"
            :class="{ active: editor.isActive('strike') }"
        >
            strike
        </span>
    </BubbleMenu>
</template>

<style scoped lang="scss">
.badge {
    @apply text-xs font-medium mr-2 px-2.5 py-0.5 rounded;
    &.active {
        @apply bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-300;
    }
    &:not(.active) {
        @apply bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300;
    }
}
</style>

