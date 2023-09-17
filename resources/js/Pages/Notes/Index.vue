<script setup lang="ts">
import route from "ziggy-js";

const { project } = defineProps<{
    project: App.Models.Project;
    notes: Array<App.Models.Note>;
}>();

const { can } = useRole();

const breadcrumb = [
    {
        label: "Mes projets",
        route: route("projects.index"),
    },
    {
        label: project.title,
        route: route("projects.show", { project }),
    },
    {
        label: "Notes",
        route: route("projects.notes.index", { project }),
    },
];
</script>

<template>
    <AppLayout title="Notes">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
        </template>

        <div
            class="grid grid-cols-1 gap-4 mt-8 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6"
        >
            <template v-if="can('note:create')">
                <NoteCreateModal :project="project">
                    <div
                        class="flex items-center justify-center bg-gray-300 rounded h-80 dark:bg-gray-900 hover:cursor-pointer"
                    >
                        <i-carbon-document-add
                            class="text-5xl dark:text-white"
                        />
                    </div>
                </NoteCreateModal>
            </template>

            <template v-for="note in notes" :key="note.id">
                <NoteCard :project="project" :note="note" />
            </template>
        </div>
    </AppLayout>
</template>
