<script setup lang="ts">
defineProps<{
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    };
}>();

const breadcrumb = [
    {
        label: 'Mes projets',
        route: route('projects.index')
    }
];
</script>

<template>
    <AppLayout :title="'Projet ' + project.title">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb"/>
            <div class="">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center">Mes projets</h2>
            </div>
        </template>
        <div class="text-gray-800 dark:text-gray-200">
            <p>{{ project.subtitle }}</p>
            <p>{{ project.description }}</p>
        </div>
    </AppLayout>
</template>
