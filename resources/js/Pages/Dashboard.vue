<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps<{
    projects: Array<App.Models.Project>;
}>();
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center">
                    Dashboard
                </h2>
            </div>
        </template>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div
                class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800"
            >
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div
                class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800"
            >
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div
                class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800"
            >
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
        </div>
        <div
            class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800"
        >
            <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div
                class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800"
            >
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div
                class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800"
            >
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div
                class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800"
            >
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
            <div
                class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800"
            >
                <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
            </div>
        </div>
    </AppLayout>
</template>
