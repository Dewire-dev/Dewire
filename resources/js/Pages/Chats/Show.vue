<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import route from "ziggy-js";
import { useForm } from '@inertiajs/vue3';
import Banner from "../../Components/Banner.vue";
import axios from "axios";
import {Button} from "flowbite-vue";

const {chat, project, unReadMessages} = defineProps<{
    chat: App.Models.Chat;
    messages: Array<App.Models.Message>;
    unReadMessages: Array<{
        id: number;
        message_id: number;
        content: string;
        user_id: string;
    }>;
    project: App.Models.Project,
    chatsUsers: Array<App.Models.ChatsUser>;
    countUnreadMessages: number;
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
    content: "",
})

let markRead = false;
let firstElementUnRead = unReadMessages[0];

function formMarkRead() {
    axios.post(route('messages.read', { project, chat }), {
        unReadMessages: unReadMessages
    })
    .then(function (response){
        location.reload();
    })
    .catch(function (error){
        console.log(error);
    })
}

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

        <ul role="list" class="max-w-none divide-y divide-gray-200 dark:divide-gray-700">
            <li class="py-3 sm:py-4" v-for="(message) in messages" :key="message.id">
                <div class="mb-3" v-if="!markRead && unReadMessages.find(value => message.id === value.message_id) && firstElementUnRead.message_id === message.id">
                    <InputLabel>{{ countUnreadMessages }} messages non lus</InputLabel>
                    <form @submit.prevent="formMarkRead">
                        <Button color="green" class="flex items-center">
                            Marquer comme lu
                        </Button>
                    </form>
                </div>
                <div class="flex items-center space-x-3" v-if="!markRead || unReadMessages.find(value => message.id === value.message_id)">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-1xl font-semibold text-green-500">
                            {{ message.sender?.name }}
                        </p>
                        <p class="text-2xl text-black-500 dark:text-white">
                            {{ message.content }}
                        </p>
                    </div>
                </div>
            </li>
        </ul>


        <div class="bottom-0 z-50 max-w-none divide-y divide-gray-200 dark:divide-gray-700">
            <form @submit.prevent="form.post(route('messages.store', { project, chat }))">
                <div class="flex items-center px-3 py-2 rounded-lg">
                    <textarea id="content" v-model="form.content" rows="4" class="block mx-4 p-2.5 w-full text-2xl text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ton message..."></textarea>
                    <button type="submit" class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                        <svg aria-hidden="true" class="w-6 h-6 rotate-90" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                        <span class="sr-only">Envoyer</span>
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>

    textarea {
        resize: none;
    }

</style>
