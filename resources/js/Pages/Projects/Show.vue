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
        <div class="text-gray-800 dark:text-gray-200">
            <p>{{ project.subtitle }}</p>
            <p>{{ project.description }}</p>
        </div>
    </AppLayout>
</template>
