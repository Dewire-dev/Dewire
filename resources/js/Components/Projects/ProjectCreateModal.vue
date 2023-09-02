<script setup lang="ts">
import route from "ziggy-js";

const confirmingProjectCreation = ref(false);

const form = useForm({
    title: "",
    subtitle: "",
    description: "",
    color: "",
});

watch(confirmingProjectCreation, () => form.reset());

const confirmProjectCreation = () => {
    confirmingProjectCreation.value = true;
};

const createProject = () => {
    form.post(route("projects.store"), {
        errorBag: "storeProject",
        onSuccess: () => (confirmingProjectCreation.value = false),
    });
};
</script>

<template>
    <div @click.prevent="confirmProjectCreation">
        <slot />
    </div>

    <DialogModal
        :show="confirmingProjectCreation"
        @close="confirmingProjectCreation = false"
    >
        <template #title>Nouveau projet</template>

        <template #content>
            <form @submit.prevent>
                <div class="mb-6">
                    <label
                        for="project_title"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Titre</label
                    >
                    <input
                        v-model="form.title"
                        type="text"
                        id="project_title"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label
                        for="project_subtitle"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Sous-titre</label
                    >
                    <input
                        v-model="form.subtitle"
                        type="text"
                        id="project_subtitle"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label
                        for="project_description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Description</label
                    >
                    <input
                        v-model="form.description"
                        type="text"
                        id="project_description"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label
                        for="project_color"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Couleur</label
                    >
                    <!-- TODO : intégrer un input de type color -->
                    <input
                        v-model="form.color"
                        type="text"
                        id="project_color"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required
                    />
                </div>
            </form>
        </template>

        <template #footer>
            <SecondaryButton @click="confirmingProjectCreation = false">
                Annuler
            </SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="createProject"
            >
                Sauvegarder
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
