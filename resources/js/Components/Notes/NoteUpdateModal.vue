<script setup lang="ts">
import route from "ziggy-js";

const { project, note } = defineProps<{
    project: App.Models.Project;
    note: App.Models.Note;
}>();

const confirmingNoteModification = ref(false);

const form = useForm({
    name: note.name,
});

watch(confirmingNoteModification, () => form.reset());

const confirmNoteModification = () => {
    confirmingNoteModification.value = true;
};

const updateNote = () => {
    form.put(route("projects.notes.update", { project, note }), {
        errorBag: "updateNote",
        preserveState: false,
        onSuccess: () => (confirmingNoteModification.value = false),
    });
};
</script>

<template>
    <div @click.prevent="confirmNoteModification">
        <slot />
    </div>

    <DialogModal
        :show="confirmingNoteModification"
        @close="confirmingNoteModification = false"
    >
        <template #title>Note {{ note.name }}</template>

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
            <SecondaryButton @click="confirmingNoteModification = false">
                Annuler
            </SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="updateNote"
            >
                Sauvegarder
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
