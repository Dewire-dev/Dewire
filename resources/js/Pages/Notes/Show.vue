<script setup lang="ts">
import route from "ziggy-js";

const { project, note } = defineProps<{
    project: any;
    note: any;
}>();

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
    {
        label: note.name,
        route: route('projects.notes.show', { project, note }),
    },
];

const content = useDebouncedRef(JSON.parse(note.content), 1000);

watch(content, (value) => {
    router.patch(route("notes.save", { project, note }), {
        content: value,
    });
});
</script>

<template>
    <AppLayout :title="note.name">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
            <div class="">
                <h2
                    class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center"
                >
                    {{ note.name }}
                </h2>
            </div>
        </template>

        <NoteEditor v-model="content" />
    </AppLayout>
</template>
