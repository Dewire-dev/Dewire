<script setup lang="ts">
import route from "ziggy-js";

const { project, chat } = defineProps<{
    project: App.Models.Project;
    chat: App.Models.Chat;
}>();

const confirmingUserChatDeletion = ref(false);

const form = useForm({
    chatId: chat.id
});

const confirmUserChatDeletion = () => {
    confirmingUserChatDeletion.value = true;
};

const deleteUserChat = () => {
    form.post(route("messages.deleteUser", {project: project, chat: chat}), {
        errorBag: "deleteUserChat",
    });
};
</script>

<template>
    <div @click.prevent="confirmUserChatDeletion">
        <slot />
    </div>

    <ConfirmationModal
        :show="confirmingUserChatDeletion"
        @close="confirmingUserChatDeletion = false"
    >
        <template #title>Quitter la conversation</template>

        <template #content>
            Êtes-vous sûr de vouloir quitter la conversation ? Une fois la conversation
            quitté, vous devez y être invité pour la rejoindre à nouveau.
        </template>

        <template #footer>
            <SecondaryButton @click="confirmingUserChatDeletion = false">
                Annuler
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="deleteUserChat"
            >
                Quitter la conversation
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
