<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps<{
    projects: Array<{
        id: number;
        title: string;
        subtitle: string;
        description: string;
    }>;
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
            <div class="">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center">
                    Mes projets
                </h2>
            </div>
        </template>
        <div class="grid grid-cols-3 gap-6">
            <ProjectCard v-for="project in projects" :project="project" />
        </div>
    </AppLayout>
</template>
