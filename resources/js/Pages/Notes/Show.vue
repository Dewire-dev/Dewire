<script setup lang="ts">
import route from "ziggy-js";

const { project } = defineProps<{
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
];
</script>

<template>
    <AppLayout :title="note.name">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
            <div class="">
                <h2
                    class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center"
                >
                    {{ note.title }}
                </h2>
            </div>
        </template>

        <pre class="text-white">
            {{ note }}
        </pre>
    </AppLayout>
</template>
