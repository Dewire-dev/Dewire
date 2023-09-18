<script setup lang="ts">
import route from "ziggy-js";
import {Input} from "flowbite-vue";
import {Link} from "@inertiajs/vue3";

const {project} = defineProps<{
    project: App.Models.Project;
    kanbans: any[];
}>();

const addingKanbanBoard = ref(false);

const storeKanbanForm = useForm({
    name: "",
});

const updateKanbanName = useForm({
    name: "",
    kanban_id: "",
})

const destroyKanbanForm = useForm<{
    id?: number;
}>({
    id: undefined,
});

const deletingKanban = ref(false);

const closeStoreKanbanModal = () => {
    addingKanbanBoard.value = false;
    storeKanbanForm.name = "";
    storeKanbanForm.clearErrors();
};

const storeKanban = () => {
    storeKanbanForm.post(route("kanbans.store", project), {
        onSuccess: closeStoreKanbanModal,
        onError: (response) => {
            updateKanbanName.setError(response);
        }
    });
};

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
        route("kanbans.destroy", {project, kanban: destroyKanbanForm.id}),
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
                class="flex items-center justify-center bg-gray-300 rounded h-80 dark:bg-gray-500 hover:cursor-pointer"
            >
                <i-carbon-document-add class="text-5xl dark:text-gray-200"/>
            </div>
            <Link
                v-for="kanban in kanbans"
                :href="route('kanbans.show', { project, kanban })"
                class="flex flex-col justify-between p-6 bg-gray-300 rounded h-80 dark:bg-gray-500"
            >
                <InputNameKanban :item="kanban" :project="project"></InputNameKanban>
                <div class="flex justify-center">
                    <i-carbon-data-table class="text-5xl dark:text-gray-200"/>
                </div>

                <div class="text-center">
                    <danger-button @click.prevent="openDestroyKanbanModal(kanban.id)">
                        Supprimer
                    </danger-button>
                </div>
            </Link>
        </div>

        <!-- Add note dialog modal -->
        <DialogModal :show="addingKanbanBoard" @close="closeStoreKanbanModal">
            <template #title>Nouveau tableau de bord Kanban</template>

            <template #content>
                <div>
                    <label
                        class="block mb-2 text-sm font-medium "
                        :class="storeKanbanForm.errors.name ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Nom</label>
                    <div class="flex relative">
                        <input placeholder="Nom de la tâche"
                               v-model="storeKanbanForm.name"
                               v-on:keyup.enter="storeKanban()"
                               type="text"
                               :class="storeKanbanForm.errors.name
                 ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 text-black'
                 : 'bg-gray-50 border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'">
                    </div>
                    <span v-if="storeKanbanForm.errors.name" class="text-red-600">
                    {{ storeKanbanForm.errors.name }}
                </span>
                </div>
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
