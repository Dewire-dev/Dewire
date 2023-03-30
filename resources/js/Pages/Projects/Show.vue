<script setup lang="ts">
import ChatCard from "../../Components/Dashboard/ChatCard.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

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
    }>;
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
            <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h3 class="text-lg text-gray-800 dark:text-gray-200">
                    Liste des conversations
                </h3>
                <div class="grid grid-cols-3 gap-6 mx-6 mt-12">
                    <ChatCard v-for="chat in chats" :chat="chat" :project="project" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
