<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";

const { project } = defineProps<{
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    };
}>();

const deleteProject = () => {
    router.delete(route("projects.destroy", { project }));
};
</script>

<template>
    <Card class="card">
        <template #title>{{ project.title }}</template>
        <template #subtitle>{{ project.subtitle }}</template>
        <template #content>
            <p>{{ project.description }}</p>
        </template>
        <template #footer>
            <Link :href="route('projects.show', { project })">
                <Button icon="pi pi-eye" label="Voir" />
            </Link>
            <Button icon="pi pi-wrench" label="Modifier" severity="secondary" />
            <Button
                @click="deleteProject"
                icon="pi pi-trash"
                severity="danger"
            />
        </template>
    </Card>
</template>

<style scoped lang="scss">
.card {
    button {
        &:not(:nth-child(1)) {
            @apply ml-2;
        }
    }
}
</style>
