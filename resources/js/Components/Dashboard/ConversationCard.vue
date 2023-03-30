<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";

defineProps<{
    conversation: {
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
        <template #title>{{ conversation.name }}</template>
        <template #content>
            <p>{{ conversation.subject }}</p>
        </template>
        <template #footer>
            <Link :href="route('chat.show', { chat: conversation, project })">
                <Button icon="pi pi-eye" label="Voir" />
            </Link>
        </template>
    </Card>
</template>
