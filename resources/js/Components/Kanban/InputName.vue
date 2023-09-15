<script setup lang="ts">
import route from "ziggy-js";
import {Input} from "flowbite-vue";
import {vOnClickOutside} from '@vueuse/components'

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
        v-on-click-outside="() => item.displayInputName = false"
        v-on:keyup.enter="storeKanbanListName"
        @change="storeKanbanListName"
        v-model="storeKanbanListNameForm.name"
        ref="name"
        required
        class="cursor-pointer bg-white shadow rounded-md p-1"
        placeholder="Nom de la liste"
    />
</template>
