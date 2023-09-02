<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps<{
    project: App.Models.Project;
    mod: App.Models.Module;
}>();
</script>

<template>
    <Link
        :href="`/projects/${project.id}/${mod.slug}`"
        class="module-card flex justify-center items-center py-16 rounded-xl text-white text-4xl font-bold"
    >
        {{ mod.name }}
    </Link>
</template>

<style>
.module-card {
    background-color: v-bind("mod.color");
}
</style>
