<script setup lang="ts">
import route from "ziggy-js";
import {Input} from "flowbite-vue";

const {item, project} = defineProps<{
    item: Object;
    project: Object;
}>();

const storeKanbanListNameForm = useForm({
    name: item.name,
})

const name = ref(null);

const storeKanbanListName = () => {
    storeKanbanListNameForm.post(route('kanban-lists-update-name', {project: project, kanban_list: item}), {
        onSuccess: name.value.blur(),
    });
};

</script>

<template>
    <input
        v-on:keyup.enter="storeKanbanListName"
        @change="storeKanbanListName"
        v-model="storeKanbanListNameForm.name"
        ref="name"
        required
        class="cursor-pointer bg-white dark:bg-gray-800 dark:text-gray-200 shadow rounded-md p-1 placeholder-gray-200"
        placeholder="Nom de la liste"
    />
</template>
<style scoped>

input:focus-visible {
    outline: 1px solid white;
}
</style>
