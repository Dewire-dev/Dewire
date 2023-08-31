<script setup lang="ts">
import { cva, type VariantProps } from "class-variance-authority";

const button = cva(
    "inline-flex items-center px-4 py-2 font-semibold transition ease-in-out duration-150",
    {
        variants: {
            variant: {
                primary:
                    "bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:ring-gray-800 dark:focus:ring-gray-200 dark:focus:ring-offset-gray-800 border-transparent",
                secondary:
                    "bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border-gray-300 dark:border-gray-500 focus:ring-gray-800 dark:focus:ring-white dark:focus:ring-offset-gray-800 shadow-sm disabled:opacity-25",
            },
            size: {
                small: "text-xs",
                medium: "text-md",
                large: "text-xl",
            },
        },
        compoundVariants: [
            {
                variant: ["primary", "secondary"],
                class: "border rounded-md focus:ring-2 focus:ring-offset-2 focus:outline-none",
            },
        ],
    }
);

export type ButtonProps = VariantProps<typeof button>;

withDefaults(
    defineProps<{
        type: "submit" | "button" | "reset" | undefined;
        variant: ButtonProps["variant"];
        size: ButtonProps["size"];
        disabled: boolean;
    }>(),
    { type: "button", variant: "primary", size: "small", disabled: false }
);
</script>

<template>
    <button
        :type="type"
        :class="button({ variant, size })"
        :disabled="disabled"
    >
        <slot />
    </button>
</template>
