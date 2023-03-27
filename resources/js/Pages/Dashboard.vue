<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const projects = [
    {
        title: "Island Crossing",
        subtitle: "Laravel, Vue, Quasar",
        description:
            "Application offrant un wiki de l'univers Animal Crossing et permettant de gérer ses collections",
    },
    {
        title: "Malton",
        subtitle: "Symfony, API Platform, Vue, Quasar",
        description:
            "Application proposant de résoudre des énigmes venant des jeux Layton",
    },
];
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h3 class="text-lg text-gray-800 dark:text-gray-200">
                Mes projets
            </h3>
            <div class="grid grid-cols-3 gap-6 mx-6 mt-12">
                <ProjectCard v-for="project in projects" :project="project" />
            </div>
        </div>
    </AppLayout>
</template>
