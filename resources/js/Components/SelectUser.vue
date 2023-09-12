<script setup>
const emit = defineEmits(['change']);

const props = defineProps({
    contentClasses: {
        type: String,
        default: () => '',
    },
    label: {
        type: String,
        required: false,
    },
    items: {
        type: Array,
        required: true,
    },
    value: {
        required: false,
    },
});

function onChange (event) {
    if (props.items) {
        const userSelected = props.items.find((item) => item.id === event.target.value)
        emit('change', userSelected);
    }
}
</script>

<template>
    <div :class="contentClasses">
        <label v-if="label" for="user-select" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">{{ label }}</label>
        <select @change="onChange" id="default" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <template v-for="item in items">
                <option :value="item.id" :selected="value && item.id === value.id">{{ item.firstname + ' ' + item.lastname }}</option>
            </template>
        </select>
    </div>
</template>
