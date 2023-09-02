<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button } from "flowbite-vue";

defineProps<{
    projects: Array<App.Models.Project>;
}>();

const breadcrumb = [
    {
        label: "Mes projets",
        route: null,
    },
];
</script>

<template>
    <AppLayout title="Mes projets">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
        </template>
        <div>
            <ProjectCreateModal>
                <Button color="green" class="flex items-center">
                    <template #prefix>
                        <i-carbon-add />
                    </template>
                    Ajouter
                </Button>
            </ProjectCreateModal>
            <div
                class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
            >
                <ProjectCard v-for="project in projects" :project="project" />
            </div>
        </div>
    </AppLayout>
</template>
