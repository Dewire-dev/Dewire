<script setup lang="ts">
import route from "ziggy-js";

const { project } = defineProps<{
    project: App.Models.Project;
}>();

const confirmingProjectDeletion = ref(false);

const form = useForm({});

const confirmProjectDeletion = () => {
    confirmingProjectDeletion.value = true;
};

const deleteProject = () => {
    form.delete(route("projects.destroy", { project }), {
        errorBag: "deleteProject",
    });
};
</script>

<template>
    <div @click.prevent="confirmProjectDeletion">
        <slot />
    </div>

    <ConfirmationModal
        :show="confirmingProjectDeletion"
        @close="confirmingProjectDeletion = false"
    >
        <template #title>Supprimer le projet</template>

        <template #content>
            Êtes-vous sûr de vouloir supprimer ce projet ? Une fois qu'un projet
            est supprimé, toutes ses ressources et données seront supprimées
            définitivement.
        </template>

        <template #footer>
            <SecondaryButton @click="confirmingProjectDeletion = false">
                Annuler
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="deleteProject"
            >
                Supprimer le projet
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
