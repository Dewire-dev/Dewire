<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Button } from "flowbite-vue";

defineProps<{
    project: App.Models.Project;
    mod: App.Models.Module;
}>();

const { can } = useRole();
</script>

<template>
    <Link
        :href="`/projects/${project.id}/${mod.slug}`"
        class="module-card relative h-48 p-4 flex justify-center items-center py-16 rounded-xl text-white text-4xl font-bold"
    >
        <div class="absolute -top-5 -right-3 w-full flex justify-end">
            <template v-if="can('module:detach')">
                <ModuleDetachModal :project="project" :mod="mod">
                    <Button
                        class="dark:bg-body"
                        color="red"
                        size="sm"
                        outline
                        square
                    >
                        <i-carbon-close />
                    </Button>
                </ModuleDetachModal>
            </template>
        </div>
        {{ mod.name }}
    </Link>
</template>

<style scoped>
.module-card {
    background-color: v-bind("mod.color");
}
</style>
