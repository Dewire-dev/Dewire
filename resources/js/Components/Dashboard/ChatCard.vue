<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";

defineProps<{
    chat: {
        id: number;
        subject: string;
        name: string;
    };
    project: {
        id: number;
        title: string;
        subtitle: string;
        description: string;
    };
}>();
</script>
<template>
    <Card class="card">
        <template #title>{{ chat.name }}</template>
        <template #content>
            <p>{{ chat.subject }}</p>
        </template>
        <template #footer>
            <Link :href="route('chats.show', { project, chat })">
                <Button icon="pi pi-eye" label="Voir" />
            </Link>
        </template>
    </Card>
</template>
