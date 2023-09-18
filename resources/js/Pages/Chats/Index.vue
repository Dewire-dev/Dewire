<script setup lang="ts">
import {ref} from 'vue';
import route from "ziggy-js";
import DialogModal from "@/Components/DialogModal.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";
import {Button, Input} from "flowbite-vue";

const modalChatCreate = ref(false);
const chatName = ref('');
const chatSubject = ref('');

const { project, users } = defineProps<{
    project: App.Models.Project;
    chats: Array<{
        id: number;
        subject: string;
        name: string;
        project_id: string;
        countUnreadMessage: number;
    }>;
    users: Array<{
        id: number;
        name: string;
        email: string;
        firstname: string;
        lastname: string;
    }>;
}>();

const chatUsers = reactive(users.map(user => ({ value: user.id, checked: false, name: user.name, firstname: user.firstname, lastname: user.lastname })));

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
    axios.post(route('chats.store', { project }), {
        chatName: chatName.value,
        chatSubject: chatSubject.value,
        chatUsers: chatUsers.filter(user => user.checked).map(user => user.value)
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
                    <Input
                        v-model="chatName"
                        required
                        label="Nom"
                        placeholder="Nom de la conversation"
                        class="mb-3"
                    />
                </div>
                <div class="subject-chat">
                    <Input
                        v-model="chatSubject"
                        required
                        label="Objet"
                        placeholder="Objet de la conversation"
                        class="mb-3"
                    />
                </div>
                <div class="users-chat">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Utilisateurs</label>
                    <div v-for="user in chatUsers" class="flex">
                        <checkbox
                            :value="user.value"
                            :name="user.firstname + ' ' + user.lastname"
                            v-model="user.checked"
                        />
                        <input-label :value="user.firstname + ' ' + user.lastname" class="ml-2" />
                    </div>
                </div>
            </template>

            <template #footer>

                <SecondaryButton @click="modalChatCreate = false"
                    >Annuler</SecondaryButton
                >

                <PrimaryButton
                    class="ml-3"
                    @click="createChat"
                >
                    Ajouter
                </PrimaryButton>

            </template>
        </DialogModal>
        <Button color="green" class="flex items-center mb-3" @click="modalChatCreate = true">
            <template #prefix>
                <i-carbon-add />
            </template>
            Ajouter
        </Button>
        <div class="grid grid-cols-3 gap-6">
            <ChatCard v-for="chat in chats" :chat="chat" :project="project" />
        </div>
    </AppLayout>
</template>
