<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";
import { Button, TheCard } from "flowbite-vue";

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
    <TheCard class="card">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ chat.name }}</h5>
        <p class="font-normal text-gray-700 dark:text-gray-400">
            {{ chat.subject }}
        </p>
        <Link :href="route('chats.show', { project, chat })">
            <Button>Voir</Button>
        </Link>
    </TheCard>
</template>
