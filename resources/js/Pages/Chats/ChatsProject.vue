<script setup lang="ts">
import ChatCard from "../../Components/Dashboard/ChatCard.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import route from "ziggy-js";

const props = defineProps<{
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
    <AppLayout :title="'Chats ' + project.title">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb"/>
            <div class="">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center">Mes conversations</h2>
            </div>
        </template>

        <div class="mt-10">
            <div class="grid grid-cols-3 gap-6 mx-6 mt-12">
                <ChatCard v-for="chat in chats" :chat="chat" :project="project" />
            </div>
        </div>
    </AppLayout>
</template>
