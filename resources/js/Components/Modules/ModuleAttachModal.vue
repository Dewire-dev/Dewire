<script setup lang="ts">
import route from "ziggy-js";

const { project } = defineProps<{
    project: App.Models.Project;
    availableModules: Array<App.Models.Module>;
}>();

const confirmingModuleAttachment = ref(false);

const form = useForm({
    mod: "",
});

watch(confirmingModuleAttachment, () => form.reset());

const confirmModuleAttachment = () => {
    confirmingModuleAttachment.value = true;
};

const attachModule = () => {
    form.post(route("modules.attach", { project, module: form.mod }), {
        errorBag: "attachModule",
        onSuccess: () => (confirmingModuleAttachment.value = false),
    });
};
</script>

<template>
    <span @click.prevent="confirmModuleAttachment">
        <slot />
    </span>

    <DialogModal
        :show="confirmingModuleAttachment"
        @close="confirmingModuleAttachment = false"
    >
        <template #title>Nouveau module</template>

        <template #content>
            <form @submit.prevent>
                <div class="mb-6">
                    <label
                        for="project_module"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Module</label
                    >
                    <select
                        v-model="form.mod"
                        id="project_module"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                        <option selected value="">Choisir un module</option>
                        <option
                            v-for="mod in availableModules"
                            :value="mod.slug"
                        >
                            {{ mod.name }}
                        </option>
                    </select>
                </div>
            </form>
        </template>

        <template #footer>
            <SecondaryButton @click="confirmingModuleAttachment = false">
                Annuler
            </SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="attachModule"
            >
                Sauvegarder
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
