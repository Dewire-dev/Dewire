<script setup lang="ts">
import route from "ziggy-js";

const { project } = defineProps<{
    project: App.Models.Project;
    chats: Array<App.Models.Chat>;
}>();

const breadcrumb = [
    {
        label: "Mes projets",
        route: route("projects.index"),
    },
    {
        label: project.title,
        route: route("projects.show", { project }),
    },
    {
        label: "Chats",
        route: route("chats.index", { project }),
    },
];
</script>

<template>
    <AppLayout title="Chats">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
            <div class="">
                <h2
                    class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center"
                >
                    Liste des conversations
                </h2>
            </div>
        </template>

        <div class="grid grid-cols-3 gap-6">
            <ChatCard v-for="chat in chats" :chat="chat" :project="project" />
        </div>
    </AppLayout>
</template>
