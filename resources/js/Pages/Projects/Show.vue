<script setup lang="ts">
import ChatCard from "../../Components/Dashboard/ChatCard.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import route from "ziggy-js";
import { Button } from "flowbite-vue";

defineProps<{
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    };
    chats: Array<{
        id: number;
        subject: string;
        name: string;
        countUnreadMessages: number;
    }>;
}>();

const breadcrumb = [
    {
        label: 'Mes projets',
        route: route('projects.index')
    },
    {
        label: props.project.title,
        route: null
    },
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

        <Link :href="route('projects.notes.index', { project })">
            <Button color="yellow">Notes</Button>
        </Link>

        <div class="mt-10">
            <h3 class="text-lg text-gray-800 dark:text-gray-200">
                Liste des conversations
            </h3>
            <div class="grid grid-cols-3 gap-6 mx-6 mt-12">
                <ChatCard v-for="chat in chats" :chat="chat" :project="project" />
            </div>
        </div>
    </AppLayout>
</template>
