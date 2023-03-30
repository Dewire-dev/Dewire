<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import route from "ziggy-js";

const {project} = defineProps<{
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    };
}>();

const deleteProject = () => {
    router.delete(route("projects.destroy", {project}));
};
</script>

<template>
    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

        <Link :href="route('projects.show', { project })">
            <h5
                class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ project.title }}
            </h5>
            <span class="text-gray-900 dark:text-white">
                {{ project.subtitle }}
            </span>
        </Link>
        <p class="my-3 font-normal text-gray-700 dark:text-gray-400">
            {{ project.description }}
        </p>
        <div class="flex gap-1">
            <Link
                :href="route('projects.show', { project })"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Voir
            </Link>
            <button
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                Modifier
            </button>
            <button
                @click="deleteProject"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                Supprimer
            </button>
        </div>
    </div>
</template>
