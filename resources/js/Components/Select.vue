<script setup>
const props = defineProps({
    label: {
        type: String,
        required: false,
    },
    items: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: String,
        required: false,
        default: '',
    },
});

defineEmits([
    'update:modelValue',
])
</script>

<template>
    <label v-if="label" :for="label" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">{{ label }}</label>
    <select
        id="default"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <template v-for="item in items">
            <option :selected="item === modelValue">{{ item }}</option>
        </template>
    </select>
</template>
