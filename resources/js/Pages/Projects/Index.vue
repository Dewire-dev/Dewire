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
        label: 'Mes projets',
        route: null
    }
];
</script>

<template>
    <AppLayout title="Mes projets">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb"/>
            <div class="">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center">Mes projets</h2>
            </div>
        </template>
        <div class="grid grid-cols-3 gap-6">
            <div v-for="project in projects" class="max-w-xs project-card dark:border-gray-700">
                <img class="rounded-lg" src="https://cdn.pixabay.com/photo/2017/05/26/07/48/cookies-2345439_960_720.jpg">
                <span class="dark:text-white flex justify-center mt-1">{{ project.title}}</span>
            </div>
            <ProjectCard v-for="project in projects" :project="project" />
        </div>
    </AppLayout>
</template>
<style scoped>
.project-card {
    border-radius: 10px;
}
</style>
