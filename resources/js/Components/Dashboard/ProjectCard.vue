<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";
import { Button, TheCard } from "flowbite-vue";

const { project } = defineProps<{
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    };
}>();

const deleteProject = () => {
    router.delete(route("projects.destroy", { project }));
};
</script>

<template>
    <TheCard>
        <Link :href="route('projects.show', { project })">
            <h5
                class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
            >
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
            <Link :href="route('projects.show', { project })">
                <Button>Voir</Button>
            </Link>
            <Button color="purple">Modifier</Button>
            <Button @click="deleteProject" color="red">Supprimer</Button>
        </div>
    </TheCard>
</template>
