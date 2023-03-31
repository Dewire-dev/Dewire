<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import route from "ziggy-js";
import { useForm } from '@inertiajs/vue3';

const {chat, project} = defineProps<{
    chat: {
        id: number;
        subject: string;
        name: string;
    };
    messages: Array<{
        id: number;
        content: string;
    }>;
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    }
}>();

const breadcrumb = [
    {
        label: 'Mes projets',
        route: route('projects.index')
    },
    {
        label: project.title,
        route: route('projects.show', {project})
    }
];

const form = useForm({
    content: null,
})

</script>
<template>
    <AppLayout :title="'Chat ' + chat.name">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb"/>
            <div class="">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center">
                    {{ chat.name }}
                </h2>
            </div>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-gray-800 dark:text-gray-200">
                <div v-for="message in messages">
                    <p>{{ message.content }}</p>
                </div>
            </div>
            <form @submit.prevent="form.post(route('chats.store', {project, chat, form}))">
                <div class="form-group">
                    <textarea id="content" v-model="form.content" aria-placeholder="Ecrivez votre message" class="form-control"></textarea>
                </div>
                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
                    Envoyer
                </button>
            </form>
        </div>
    </AppLayout>
</template>
