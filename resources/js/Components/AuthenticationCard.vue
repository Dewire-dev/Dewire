<script setup>
import {useDark} from "@vueuse/core";
const isDark = useDark();
</script>
<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
        <i @click="isDark = !isDark" :class="isDark ? 'pi pi-sun text-white' : 'pi pi-moon'" class="cursor-pointer toggler-theme"></i>
    </div>
</template>
