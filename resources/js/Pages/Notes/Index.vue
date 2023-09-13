<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Input } from "flowbite-vue";
import route from "ziggy-js";

const { project } = defineProps<{
    project: App.Models.Project;
    notes: Array<App.Models.Note>;
}>();

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
        label: "Notes",
        route: route("projects.notes.index", { project }),
    },
];

const storeNoteForm = useForm({
    name: "",
});

const addingNote = ref(false);

const closeStoreNoteModal = () => {
    addingNote.value = false;
    storeNoteForm.name = "";
};

const storeNote = () => {
    storeNoteForm.post(route("projects.notes.store", project));
};

const destroyNoteForm = useForm<{
    id?: string;
}>({
    id: undefined,
});

const deletingNote = ref(false);

const openDestroyNoteModal = (id: string) => {
    deletingNote.value = true;
    destroyNoteForm.id = id;
};

const closeDestroyNoteModal = () => {
    deletingNote.value = false;
    destroyNoteForm.id = undefined;
};

const destroyNote = () => {
    if (!destroyNoteForm.id) return;
    destroyNoteForm.delete(
        route("projects.notes.destroy", { project, note: destroyNoteForm.id }),
        {
            onSuccess: closeDestroyNoteModal,
        }
    );
};
</script>

<template>
    <AppLayout title="Notes">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
            <div class="">
                <h2
                    class="text-xl font-semibold text-center text-gray-800 dark:text-gray-200"
                >
                    Notes
                </h2>
            </div>
        </template>

        <div
            class="grid grid-cols-1 gap-4 mt-8 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6"
        >
            <!-- Add note button -->
            <div
                @click="addingNote = true"
                class="flex items-center justify-center bg-gray-300 rounded h-80 dark:bg-gray-900 hover:cursor-pointer"
            >
                <i-carbon-document-add class="text-5xl dark:text-white" />
            </div>

            <!-- List notes -->
            <Link
                v-for="note in notes"
                :href="route('projects.notes.show', { project, note })"
                class="flex flex-col justify-between p-6 bg-gray-300 rounded h-80 dark:bg-gray-900"
            >
                <span class="mb-4 text-2xl dark:text-white line-clamp-1">{{
                    note.name
                }}</span>
                <p
                    v-if="note.content"
                    v-html="note.content"
                    class="h-full px-2 prose rounded dark:prose-invert line-clamp-4"
                    :class="{ 'border border-gray-600': note.content }"
                ></p>
                <div class="text-center">
                    <span
                        @click.prevent="openDestroyNoteModal(note.id)"
                        class="text-red-600 hover:text-red-700 hover:underline hover:cursor-pointer"
                        >Supprimer</span
                    >
                </div>
            </Link>
        </div>

        <!-- Add note dialog modal -->
        <DialogModal :show="addingNote" @close="closeStoreNoteModal">
            <template #title>Nouvelle note</template>

            <template #content>
                <Input
                    v-model="storeNoteForm.name"
                    required
                    label="Nom"
                    placeholder="Nouvelle note"
                />
            </template>

            <template #footer>
                <SecondaryButton @click="closeStoreNoteModal"
                    >Annuler</SecondaryButton
                >

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': storeNoteForm.processing }"
                    :disabled="storeNoteForm.processing"
                    @click="storeNote"
                >
                    Ajouter
                </PrimaryButton>
            </template>
        </DialogModal>

        <!-- Delete note dialog modal -->
        <ConfirmationModal :show="deletingNote" @close="closeDestroyNoteModal">
            <template #title>Supprimer la note</template>

            <template #content>
                Êtes-vous sûr de vouloir supprimer la note "{{
                    notes.find((note) => note.id === destroyNoteForm.id)?.name
                }}" ?
            </template>

            <template #footer>
                <SecondaryButton @click="closeDestroyNoteModal">
                    Annuler
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': destroyNoteForm.processing }"
                    :disabled="destroyNoteForm.processing"
                    @click="destroyNote()"
                >
                    Supprimer la note
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
