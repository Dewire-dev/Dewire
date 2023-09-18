<script setup lang="ts">
import route from "ziggy-js";
import {Input} from "flowbite-vue";

const {item, project} = defineProps<{
    item: Object;
    project: Object;
}>();

const updateKanbanNameForm = useForm({
    name: item.name,
})

const name = ref(null);

const updateKanbanName = (e) => {
    updateKanbanNameForm.post(route('kanban-update-name', {project: project, kanban: item}), {
        onSuccess: name.value.blur(),
        onError: (response) => {
            updateKanbanNameForm.setError(response);
        }
    });
};

</script>

<template>
    <input
        v-on:keydown.enter.prevent="updateKanbanName"
        @change="updateKanbanName"
        @click.prevent=""
        v-model="updateKanbanNameForm.name"
        ref="name"
        required
        :class="updateKanbanNameForm.errors.name
                 ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 text-black'
                 : 'bg-gray-50 border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'"
        placeholder="Nom du tableau"
    />
</template>
<style scoped>

input:focus-visible {
    outline: 1px solid white;
}
</style>
