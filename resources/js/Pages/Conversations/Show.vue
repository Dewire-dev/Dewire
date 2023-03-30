<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps<{
    conversation: {
        id: number;
        subject: string;
        name: string;
    };
}>();

</script>
<template>
    <AppLayout :title="'Conversation ' + conversation.name">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ conversation.name }}
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-gray-800 dark:text-gray-200">
                <p>{{ conversation.subject }}</p>
            </div>
        </div>
    </AppLayout>
</template>
