<script setup lang="ts">
import route from "ziggy-js";
import {Input} from "flowbite-vue";
import { Link } from "@inertiajs/vue3";

const {project} = defineProps<{
    project: App.Models.Project;
    kanbans: any[];
}>();

const addingKanbanBoard = ref(false);

const storeKanbanForm = useForm({
    name: "",
});

const closeStoreKanbanModal = () => {
    addingKanbanBoard.value = false;
    storeKanbanForm.name = "";
};

const storeKanban = () => {
    storeKanbanForm.post(route("kanbans.store", project), {
      onSuccess: closeStoreKanbanModal,
    });
};

const destroyKanbanForm = useForm<{
    id?: number;
}>({
    id: undefined,
});

const deletingKanban = ref(false);

const openDestroyKanbanModal = (id: number) => {
    deletingKanban.value = true;
    destroyKanbanForm.id = id;
};

const closeDestroyKanbanModal = () => {
    deletingKanban.value = false;
    destroyKanbanForm.id = undefined;
};

const destroyKanban = () => {
    if (!destroyKanbanForm.id) return;
    destroyKanbanForm.delete(
        route("kanbans.destroy", { project, kanban: destroyKanbanForm.id }),
        {
            onSuccess: closeDestroyKanbanModal,
        }
    );
};

const breadcrumb = [
    {
        label: "Mes projets",
        route: route("projects.index"),
    },
    {
        label: project.title,
        route: route("projects.show", {project}),
    },
    {
        label: "Tableaux Kanban",
        route: route("kanbans.index", {project}),
    },
];
</script>

<template>
    <AppLayout title="Kanban">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb"/>
            <div class="">
                <h2
                    class="text-xl font-semibold text-center text-gray-800 dark:text-gray-200"
                >
                    Kanban
                </h2>
            </div>
        </template>

        <div
            class="grid grid-cols-1 gap-4 mt-8 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6"
        >
            <!-- Add note button -->
            <div
                @click="addingKanbanBoard = true"
                class="flex items-center justify-center bg-gray-300 rounded h-80 dark:bg-gray-900 hover:cursor-pointer"
            >
                <i-carbon-document-add class="text-5xl dark:text-white"/>
            </div>
            <Link
                v-for="kanban in kanbans"
                :href="route('kanbans.show', { project, kanban })"
                class="flex flex-col justify-between p-6 bg-gray-300 rounded h-80 dark:bg-gray-900"
            >
                <span class="mb-4 text-2xl dark:text-white line-clamp-1">{{
                        kanban.name
                    }}</span>
                <div class="text-center">
                    <span
                        @click.prevent="openDestroyKanbanModal(kanban.id)"
                        class="text-red-600 hover:text-red-700 hover:underline hover:cursor-pointer">Supprimer</span>
                </div>
            </Link>
        </div>

        <!-- Add note dialog modal -->
        <DialogModal :show="addingKanbanBoard" @close="closeStoreKanbanModal">
            <template #title>Nouveau tableau de bord Kanban</template>

            <template #content>
                <Input
                    v-model="storeKanbanForm.name"
                    required
                    label="Nom"
                    placeholder="Nom du tableau Kanban"
                />
            </template>

            <template #footer>
                <SecondaryButton @click="closeStoreKanbanModal">Annuler</SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': storeKanbanForm.processing }"
                    :disabled="storeKanbanForm.processing"
                    @click="storeKanban"
                >
                    Ajouter
                </PrimaryButton>
            </template>
        </DialogModal>

        <!-- Delete note dialog modal -->
        <ConfirmationModal :show="deletingKanban" @close="closeDestroyKanbanModal">
            <template #title>Supprimer le tableau Kanban</template>

            <template #content>
                Êtes-vous sûr de vouloir supprimer le tableau Kanban "{{
                    kanbans.find((kanban) => kanban.id === destroyKanbanForm.id)?.name
                }}" ?
            </template>

            <template #footer>
                <SecondaryButton @click="closeDestroyKanbanModal">
                    Annuler
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': destroyKanbanForm.processing }"
                    :disabled="destroyKanbanForm.processing"
                    @click="destroyKanban()"
                >
                    Supprimer le tableau Kanban
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
