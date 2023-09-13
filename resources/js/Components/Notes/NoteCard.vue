<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";
import { Button } from "flowbite-vue";

defineProps<{
    project: App.Models.Note;
    note: App.Models.Note;
}>();

const { can } = useRole();
</script>

<template>
    <Link
        :href="route('projects.notes.show', { project, note })"
        class="relative h-80 p-4 bg-white border border-green-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700"
    >
        <div class="absolute -top-4 right-2 w-full flex justify-end gap-2">
            <!-- TODO : créer une modal unique de modification de projet et l'importer ailleurs -->
            <template v-if="can('note:update') && ($page.props.auth.user.id === note.user?.id)">
                <NoteUpdateModal :project="project" :note="note">
                    <Button
                        class="bg-white dark:bg-body"
                        color="blue"
                        size="sm"
                        outline
                        square
                    >
                        <i-carbon-tools />
                    </Button>
                </NoteUpdateModal>
            </template>
            <template v-if="can('note:delete') && ($page.props.auth.user.id === note.user?.id)">
                <NoteDeleteModal :project="project" :note="note">
                    <Button
                        class="bg-white dark:bg-body"
                        color="red"
                        size="sm"
                        outline
                        square
                    >
                        <i-carbon-trash-can />
                    </Button>
                </NoteDeleteModal>
            </template>
        </div>
        <div class="mb-4 dark:text-white">
            <p class="text-2xl line-clamp-1">{{ note.name }}</p>
            <p clas>crée par {{ note.user?.name }}</p>
        </div>
        <p
            v-if="note.content"
            v-html="note.content"
            class="px-2 prose rounded dark:prose-invert line-clamp-4"
            :class="{ 'border border-gray-600': note.content }"
        ></p>
    </Link>
</template>
