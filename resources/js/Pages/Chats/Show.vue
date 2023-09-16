<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import route from "ziggy-js";
import { useForm } from '@inertiajs/vue3';
import Banner from "../../Components/Banner.vue";
import axios from "axios";
import {Button} from "flowbite-vue";

const {chat, project, unReadMessages, chatsUsers, checkedUsersTeamNotChat} = defineProps<{
    chat: {
        id: number;
        subject: string;
        name: string;
    };
    messages: Array<{
        id: number;
        content: string;
    }>;
    unReadMessages: Array<{
        id: number;
        message_id: number;
        content: string;
        user_id: string;
    }>;
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    },
    chatsUsers: Array<{
        id: number;
        user_id: string;
        chat_id: number;
        user_name: string;
    }>;
    countUnreadMessages: number;
    checkedUsersTeamNotChat: Array<{
        id: number;
        name: string;
        email: string;
        checked: false;
    }>;
}>();

const breadcrumb = [
    {
        label: 'Mes projets',
        route: route('projects.index')
    },
    {
        label: project.title,
        route: route('projects.show', {project})
    },
    {
        label: "Chats",
        route: route("chats.index", { project }),
    },
];

const form = useForm({
    content: "",
})

let markRead = false;
let firstElementUnRead = unReadMessages[0];

const addingUser = ref(false);

const closeStoreUserModal = () => {
    addingUser.value = false;
};

function storeUser() {
    axios.post(route('messages.addUser', { project, chat }), {
        users: checkedUsersTeamNotChat.filter(user => user.checked).map(user => user.id)
    })
    .then(function (response){
        location.reload();
        closeStoreUserModal();
    })
    .catch(function (error){
        alert(error);
    })
}

function formMarkRead() {
    axios.post(route('messages.read', { project, chat }), {
        unReadMessages: unReadMessages
    })
    .then(function (response){
        location.reload();
    })
    .catch(function (error){
        alert(error);
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
                <Dropdown
                    align="right"
                    width="60"
                    class="text-right"
                >
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                            >
                                Paramètres

                                <svg
                                    class="ml-2 -mr-0.5 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                                    />
                                </svg>
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <div class="w-60 text-left">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Membres de la conversation
                            </div>
                            <template
                                v-for="user in chatsUsers"
                                :key="user.id"
                            >
                                <DropdownLink as="button">
                                    <div class="flex items-center">
                                        <div>{{ user.user_name }}</div>
                                    </div>
                                </DropdownLink>

                            </template>

                            <div
                                class="border-t border-gray-200 dark:border-gray-600"
                            />

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Paramètres de la conversation
                            </div>

                            <DropdownLink as="button" @click="addingUser = true">
                                Ajouter des utilisateurs
                            </DropdownLink>

                            <UserChatDeleteModal :project="project" :chat="chat">
                                <DropdownLink as="button">
                                    Quitter la conversation
                                </DropdownLink>
                            </UserChatDeleteModal>
                        </div>
                    </template>
                </Dropdown>
                <DialogModal :show="addingUser" @close="closeStoreUserModal">
                    <template #title>Ajouter des utilisateurs</template>

                    <template #content>
                        <div v-for="user in checkedUsersTeamNotChat" v-if="checkedUsersTeamNotChat.length" class="flex">
                            <checkbox
                                :value="user.id"
                                :name="user.name"
                                :id="user.id"
                                v-model="user.checked"
                                :true-value="user.id"
                                :false-value="null"
                            />
                            <input-label :value="user.name" class="ml-2" />
                        </div>
                        <div v-else>
                            Tous les utilisateurs du projet sont déjà dans la conversation.
                        </div>
                    </template>

                    <template #footer>
                        <SecondaryButton @click="closeStoreUserModal"
                        >Annuler</SecondaryButton
                        >

                        <PrimaryButton
                            class="ml-3"
                            @click="storeUser"
                        >
                            Ajouter
                        </PrimaryButton>
                    </template>
                </DialogModal>
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
            <form @submit.prevent="form.post(route('messages.store', { project, chat })); form.content='' ">
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
