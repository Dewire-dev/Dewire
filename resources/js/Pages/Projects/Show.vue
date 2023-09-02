<script setup lang="ts">
import route from "ziggy-js";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps<{
    project: App.Models.Project;
}>();

const breadcrumb = [
    {
        label: "Mes projets",
        route: route("projects.index"),
    },
    {
        label: props.project.title,
        route: null,
    },
];
</script>

<template>
    <AppLayout :title="'Projet ' + project.title">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
        </template>

        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
            <ModuleCard
                v-for="mod in project.modules"
                :project="project"
                :mod="mod"
            ></ModuleCard>
        </div>
    </AppLayout>
</template>
