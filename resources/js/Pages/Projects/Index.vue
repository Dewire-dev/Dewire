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
</script>

<template>
    <AppLayout title="Mes projets">
        <div class="grid grid-cols-3 gap-6">
            <ProjectCard v-for="project in projects" :project="project" />
        </div>
    </AppLayout>
</template>
