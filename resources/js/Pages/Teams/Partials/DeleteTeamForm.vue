<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/Jetstream/ActionSection.vue';
import ConfirmationModal from '@/Components/Jetstream/ConfirmationModal.vue';
import DangerButton from '@/Components/Jetstream/DangerButton.vue';
import SecondaryButton from '@/Components/Jetstream/SecondaryButton.vue';

const props = defineProps({
    team: Object,
});

const confirmingTeamDeletion = ref(false);
const form = useForm({});

const confirmTeamDeletion = () => {
    confirmingTeamDeletion.value = true;
};

const deleteTeam = () => {
    form.delete(route('teams.destroy', props.team), {
        errorBag: 'deleteTeam',
    });
};
</script>

<template>
    <ActionSection>
        <template #title>
            Supprimer l'équipe
        </template>

        <template #description>
            Supprimer définitivement cette équipe.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                Une fois qu'une équipe est supprimée, toutes ses ressources et données seront supprimées définitivement. Avant de supprimer cette équipe, veuillez télécharger les données ou les informations que vous souhaitez conserver concernant cette équipe.
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmTeamDeletion">
                    Supprimer l'équipe
                </DangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <ConfirmationModal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    Supprimer l'équipe
                </template>

                <template #content>
                    Êtes-vous sûr de vouloir supprimer cette équipe ? Une fois qu'une équipe est supprimée, toutes ses ressources et données seront supprimées définitivement.
                </template>

                <template #footer>
                    <SecondaryButton @click="confirmingTeamDeletion = false">
                        Annuler
                    </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTeam"
                    >
                        Supprimer l'équipe
                    </DangerButton>
                </template>
            </ConfirmationModal>
        </template>
    </ActionSection>
</template>
