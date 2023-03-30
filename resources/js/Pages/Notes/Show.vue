<script setup lang="ts">
defineProps<{
    note: any;
}>();
</script>

<template>
    <AppLayout :title="note.name">
        <pre class="text-white">
            {{ note }}
        </pre>
    </AppLayout>
</template>
