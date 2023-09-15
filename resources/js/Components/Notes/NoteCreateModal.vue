<script setup lang="ts">
import route from "ziggy-js";

const { project } = defineProps<{
    project: App.Models.Project;
}>();

const confirmingNoteCreation = ref(false);

const form = useForm({
    name: "",
});

watch(confirmingNoteCreation, () => form.reset());

const confirmNoteCreation = () => {
    confirmingNoteCreation.value = true;
};

const createNote = () => {
    form.post(route("projects.notes.store", { project }), {
        errorBag: "storeNote",
        onSuccess: () => (confirmingNoteCreation.value = false),
    });
};
</script>

<template>
    <span @click.prevent="confirmNoteCreation">
        <slot />
    </span>

    <DialogModal
        :show="confirmingNoteCreation"
        @close="confirmingNoteCreation = false"
    >
        <template #title>Nouvelle note</template>

        <template #content>
            <form @submit.prevent>
                <div class="mb-6">
                    <label
                        for="note_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Nom</label
                    >
                    <input
                        v-model="form.name"
                        type="text"
                        id="note_name"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required
                    />
                </div>
            </form>
        </template>

        <template #footer>
            <SecondaryButton @click="confirmingNoteCreation = false">
                Annuler
            </SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="createNote"
            >
                Sauvegarder
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
