<script setup lang="ts">
interface Props {
    project: {
        title: string;
        subtitle: string;
        description: string;
    };
}

const { project } = defineProps<Props>();

const { title, subtitle, description } = project;
</script>

<template>
    <Card class="card">
        <template #title>{{ title }}</template>
        <template #subtitle>{{ subtitle }}</template>
        <template #content>
            <p>{{ description }}</p>
        </template>
        <template #footer>
            <Button icon="pi pi-eye" label="Voir" />
            <Button icon="pi pi-folder" label="Archiver" severity="secondary" />
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
