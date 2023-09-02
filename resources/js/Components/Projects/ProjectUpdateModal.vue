<script setup lang="ts">
import route from "ziggy-js";

const { project } = defineProps<{
    project: App.Models.Project;
}>();

const confirmingProjectModification = ref(false);

const form = useForm({
    title: project.title,
    subtitle: project.subtitle,
    description: project.description,
    color: project.color,
});

watch(confirmingProjectModification, () => form.reset());

const confirmProjectModification = () => {
    confirmingProjectModification.value = true;
};

const updateProject = () => {
    form.put(route("projects.update", { project }), {
        errorBag: "updateProject",
        preserveState: false,
        onSuccess: () => (confirmingProjectModification.value = false),
    });
};
</script>

<template>
    <div @click.prevent="confirmProjectModification">
        <slot />
    </div>

    <DialogModal
        :show="confirmingProjectModification"
        @close="confirmingProjectModification = false"
    >
        <template #title>Projet {{ project.color }}</template>

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
            <SecondaryButton @click="confirmingProjectModification = false">
                Annuler
            </SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="updateProject"
            >
                Sauvegarder
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
