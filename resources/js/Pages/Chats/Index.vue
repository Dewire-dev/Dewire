<script setup lang="ts">
import {ref} from 'vue';
import route from "ziggy-js";
import DialogModal from "@/Components/DialogModal.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

const modalChatCreate = ref(false);
const chatName = ref('');
const chatSubject = ref('');

const { project, users } = defineProps<{
    project: App.Models.Project;
    chats: Array<App.Models.Chat>;
    users: Array<{
        id: number;
        name: string;
        email: string;
    }>;
}>();

const chatUsers = reactive(users.map(user => ({ value: user.id, checked: false, name: user.name })));

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

function createChat() {
    axios.post('/create_chat', {
        projectId: project.id,
        chatName: chatName.value,
        chatSubject: chatSubject.value,
        chatUsers: chatUsers.filter(user => user.checked).map(user => user.value)
    })
    .then(function (response){
        console.log(response);
    })
    .catch(function (error){
        console.log(error);
    })
}

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

        <DialogModal :show="modalChatCreate" @close="modalChatCreate = false">
            <template #title>
                Créer une conversation
            </template>

            <template #content>
                <div class="name-chat">
                    <label for="name-chat">Nom</label>
                    <input type="text" v-model="chatName" name="name-chat">
                </div>
                <div class="subject-chat">
                    <label for="subject-chat">Objet</label>
                    <input type="text" v-model="chatSubject" name="subject-chat">
                </div>
                <div class="users-chat">
                    <label for="users-chat">Utilisateurs</label>
                    <!--                        <input type="text" list="datalist-users" v-model="chatUsers" name="users-chat">-->
                    <div v-for="user in chatUsers">
                        <input type="checkbox" :value="user.value" :name="user.name" v-model="user.checked">
                        <label :for="user.name">{{ user.name }}</label>
                    </div>

                    <!--                        <datalist id="datalist-users">-->
                    <!--                            <option v-for="user in users" :value="user.email"></option>-->
                    <!--                        </datalist>-->
                </div>
            </template>

            <template #footer>

                <button @click="createChat">
                    Envoyer
                </button>

            </template>
        </DialogModal>
        <button
            @click="modalChatCreate = true"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Créer une conversation
        </button>

        <div class="grid grid-cols-3 gap-6">
            <ChatCard v-for="chat in chats" :chat="chat" :project="project" />
        </div>
    </AppLayout>
</template>
