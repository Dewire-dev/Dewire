<script setup lang="ts">
import route from "ziggy-js";

const { project, note } = defineProps<{
    project: App.Models.Project;
    note: App.Models.Note;
}>();

const confirmingNoteDeletion = ref(false);

const form = useForm({});

const confirmNoteDeletion = () => {
    confirmingNoteDeletion.value = true;
};

const deleteNote = () => {
    form.delete(route("projects.notes.destroy", { project, note }), {
        errorBag: "deleteNote",
    });
};
</script>

<template>
    <div @click.prevent="confirmNoteDeletion">
        <slot />
    </div>

    <ConfirmationModal
        :show="confirmingNoteDeletion"
        @close="confirmingNoteDeletion = false"
    >
        <template #title>Supprimer la note</template>

        <template #content>
            Êtes-vous sûr de vouloir supprimer cette note ? Une fois qu'une note
            est supprimé, toutes ses ressources et données seront supprimées
            définitivement.
        </template>

        <template #footer>
            <SecondaryButton @click="confirmingNoteDeletion = false">
                Annuler
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="deleteNote"
            >
                Supprimer la note
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
