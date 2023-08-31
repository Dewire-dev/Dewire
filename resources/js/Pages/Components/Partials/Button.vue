<script setup lang="ts">
import DwButton, { type ButtonProps } from "@/Components/Dewire/DwButton.vue";

const DButtonVariants: Array<ButtonProps> = [
    { variant: "primary" },
    { variant: "secondary" },
];

const buttons = [
    ...DButtonVariants.map(
        ({ variant }): ButtonProps => ({ variant, size: "small" })
    ),
    ...DButtonVariants.map(
        ({ variant }): ButtonProps => ({ variant, size: "medium" })
    ),
    ...DButtonVariants.map(
        ({ variant }): ButtonProps => ({ variant, size: "large" })
    ),
];
</script>

<template>
    <div>
        <p class="text-gray-800 dark:text-white text-xl font-bold">Boutons</p>
        <div class="flex gap-2 mt-2">
            <template v-for="button in buttons">
                <DwButton :variant="button.variant" :size="button.size">
                    {{ button.variant }}
                </DwButton>
            </template>
        </div>
    </div>
</template>
