<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";
import { Button } from "flowbite-vue";

const { project } = defineProps<{
    project: App.Models.Project;
}>();
</script>

<template>
    <Link
        :href="route('projects.show', { project })"
        class="project-card block max-w-sm p-6 bg-white border rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 relative"
    >
        <div class="absolute -top-4 right-2 w-full flex justify-end gap-2">
            <!-- TODO : créer une modal unique de modification de projet et l'importer ailleurs -->
            <ProjectUpdateModal :project="project">
                <Button
                    class="dark:bg-body"
                    color="blue"
                    size="sm"
                    outline
                    square
                >
                    <i-carbon-tools />
                </Button>
            </ProjectUpdateModal>
            <ProjectDeleteModal :project="project">
                <Button
                    class="dark:bg-body"
                    color="red"
                    size="sm"
                    outline
                    square
                >
                    <i-carbon-trash-can />
                </Button>
            </ProjectDeleteModal>
        </div>
        <h5
            class="text-3xl line-clamp-1 font-bold tracking-tight text-gray-900 dark:text-white"
        >
            {{ project.title }}
        </h5>
        <span
            class="text-lg line-clamp-1 font-semibold text-gray-900 dark:text-white"
        >
            {{ project.subtitle }}
        </span>
        <p
            class="my-3 line-clamp-3 font-normal text-gray-700 dark:text-gray-400"
        >
            {{ project.description }}
        </p>
    </Link>
</template>

<style scoped>
.project-card {
    border-color: v-bind("project.color");
}
</style>
