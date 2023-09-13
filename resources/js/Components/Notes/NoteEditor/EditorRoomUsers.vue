<script setup lang="ts">
import { Avatar, StackedAvatars, StackedAvatarsCounter } from "flowbite-vue";

defineProps<{
    users: Array<App.Models.User>;
}>();

const MAX_DISPLAY_USERS = 3;
</script>

<template>
    <StackedAvatars>
        <Avatar
            v-for="user in [...users].slice(0, MAX_DISPLAY_USERS)"
            stacked
            :initials="user?.firstname?.charAt(0) + '' + user?.lastname?.charAt(0)"
            rounded
            class="border-2 rounded-full border-gray-600 dark:border-transparent"
        />

        <StackedAvatarsCounter
            v-if="users.length > MAX_DISPLAY_USERS"
            :total="users.length - MAX_DISPLAY_USERS"
            href="#"
        />
    </StackedAvatars>
</template>
