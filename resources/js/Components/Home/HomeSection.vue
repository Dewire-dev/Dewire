<script setup lang="ts">
const slots = useSlots();

const hasTitle = Object.keys(slots).includes("title");
const hasSubTitle = Object.keys(slots).includes("subtitle");
</script>

<template>
    <section
        class="h-screen flex items-center justify-center bg-white dark:bg-gray-900"
    >
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div
                v-if="hasTitle && hasSubTitle"
                class="mb-8 mx-auto text-center max-w-screen-md lg:mb-16"
            >
                <h2
                    v-if="hasTitle"
                    class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white"
                >
                    <slot name="title" />
                </h2>
                <p
                    v-if="hasSubTitle"
                    class="font-light text-gray-500 sm:text-xl dark:text-gray-400"
                >
                    <slot name="subtitle" />
                </p>
            </div>
            <slot />
        </div>
    </section>
</template>
