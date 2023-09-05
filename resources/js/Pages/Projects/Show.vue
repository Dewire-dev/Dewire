<script setup lang="ts">
import route from "ziggy-js";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button } from "flowbite-vue";

const props = defineProps<{
    project: App.Models.Project;
    availableModules: Array<App.Models.Module>;
}>();

const { can } = useRole();

const breadcrumb = [
    {
        label: "Mes projets",
        route: route("projects.index"),
    },
    {
        label: props.project.title,
        route: null,
    },
];
</script>

<template>
    <AppLayout :title="'Projet ' + project.title">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
        </template>
        <div>
            <template v-if="can('module:attach') && availableModules.length">
                <ModuleAttachModal :project="project" :availableModules="availableModules">
                    <Button color="green" class="flex items-center">
                        <template #prefix>
                            <i-carbon-add />
                        </template>
                        Ajouter
                    </Button>
                </ModuleAttachModal>
            </template>

            <div
                class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
            >
                <ModuleCard
                    v-for="mod in project.modules"
                    :project="project"
                    :mod="mod"
                ></ModuleCard>
            </div>
        </div>
    </AppLayout>
</template>
