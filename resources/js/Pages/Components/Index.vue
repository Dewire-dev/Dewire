<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import ButtonPartial from "./Partials/Button.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <div
            class="mt-12 p-4 rounded border bg-gray-100 border-body dark:bg-body dark:border-gray-100"
        >
            <div class="flex flex-col gap-8">
                <ButtonPartial />
            </div>
        </div>
    </AppLayout>
</template>
