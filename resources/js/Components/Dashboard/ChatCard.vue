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
    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

        <Link :href="route('chats.show', { project, chat })">
            <h5
                class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ chat.name }}
            </h5>
        </Link>
        <p class="my-3 font-normal text-gray-700 dark:text-gray-400">
            {{ chat.subject }}
        </p>
        <div class="flex gap-1">
            <Link
                :href="route('chats.show', { project, chat })"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Voir
            </Link>
        </div>
    </div>
</template>
