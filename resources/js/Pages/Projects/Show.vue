<script setup lang="ts">
defineProps<{
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    };
}>();
</script>

<template>
    <AppLayout :title="'Projet ' + project.title">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ project.title }}
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-gray-800 dark:text-gray-200">
                <p>{{ project.subtitle }}</p>
                <p>{{ project.description }}</p>
            </div>
        </div>
    </AppLayout>
</template>
