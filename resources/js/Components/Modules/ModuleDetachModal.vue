<script setup lang="ts">
import route from "ziggy-js";

const { project, mod } = defineProps<{
    project: App.Models.Project;
    mod: App.Models.Module;
}>();

const confirmingModuleDetachment = ref(false);

const form = useForm({
    mod,
});

const confirmModuleDetachment = () => {
    confirmingModuleDetachment.value = true;
};

const detachModule = () => {
    form.post(route("modules.detach", { project, module: form.mod }), {
        errorBag: "detachModule",
        onSuccess: () => (confirmingModuleDetachment.value = false),
    });
};
</script>

<template>
    <div @click.prevent="confirmModuleDetachment">
        <slot />
    </div>

    <ConfirmationModal
        :show="confirmingModuleDetachment"
        @close="confirmingModuleDetachment = false"
    >
        <template #title>Détacher le module</template>

        <template #content>
            Êtes-vous sûr de vouloir détacher ce module ? Une fois qu'un module
            est détaché, toutes ses ressources et données seront supprimées
            définitivement.
        </template>

        <template #footer>
            <SecondaryButton @click="confirmingModuleDetachment = false">
                Annuler
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="detachModule"
            >
                Détacher le module
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
