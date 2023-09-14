<script setup lang="ts">
import { Editor, FloatingMenu } from "@tiptap/vue-3";
import { type Level } from "@tiptap/extension-heading";
import { Button, Dropdown, ListGroup, ListGroupItem } from "flowbite-vue";

const { editor } = defineProps<{
    editor?: Editor;
}>();

const levels: Array<Level> = [1, 2, 3, 4, 5, 6];
</script>

<template>
    <FloatingMenu
        v-if="editor"
        :editor="editor"
        :tippy-options="{ duration: 100 }"
        class="flex gap-2"
    >
        <Dropdown>
            <template #trigger>
                <Button color="light">
                    Titre
                    <template #suffix>
                        <i-carbon-chevron-down />
                    </template>
                </Button>
            </template>
            <ListGroup class="grid grid-cols-3">
                <ListGroupItem
                    v-for="level in levels"
                    :key="level"
                    @click="
                        editor?.chain().focus().toggleHeading({ level }).run()
                    "
                    class="justify-center"
                    :class="{
                        'bg-blue-700': editor.isActive('heading', { level }),
                    }"
                >
                    h{{ level }}
                </ListGroupItem>
            </ListGroup>
        </Dropdown>
        <Button
            @click="editor?.chain().focus().toggleBulletList().run()"
            :color="editor.isActive('bulletList') ? 'default' : 'light'"
        >
            <i-carbon-list-bulleted />
        </Button>
        <Button
            @click="editor?.chain().focus().toggleOrderedList().run()"
            :color="editor.isActive('orderedList') ? 'default' : 'light'"
        >
            <i-carbon-list-numbered />
        </Button>
    </FloatingMenu>
</template>
