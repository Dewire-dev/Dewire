<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps<{
    chat: {
        id: number;
        subject: string;
        name: string;
    };
    messages: Array<{
        id: number;
        content: string;
    }>
}>();

</script>
<template>
    <AppLayout :title="'Chat ' + chat.name">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ chat.name }}
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-gray-800 dark:text-gray-200">
                <p>{{ chat.subject }}</p>
                <div v-for="message in messages">
                    <p>{{ message.content }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
