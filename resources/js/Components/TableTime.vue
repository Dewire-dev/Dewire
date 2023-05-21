<script setup lang="ts">
import Item from '@/Interfaces/Item'
import ItemHeader from '@/Interfaces/ItemHeader'
import { Task } from "@/Interfaces/Task"
import axios from "axios"
import route from "ziggy-js";

const showModal = ref(false)

const taskSelected = ref<Task>(null);

const props = defineProps({
    headers: {
        type: Array<ItemHeader>,
        default: [],
    },
    items: {
        type: Array<Array<Item>>,
        default: [],
    },
    days: {
        type: Array<Day>,
        default: [],
    },
    tasks: {
        type: Array<Task>,
        default: [],
    },
    states: {
        type: Array,
        required: true,
    },
});

async function openTask(idTask) {
    const response = await axios.get(
        route('tasks.show', {
            id: idTask,
        }),
    )

    taskSelected.value = response.data.task;
    showModal.value = true
}

</script>

<template>
    <Table
        :headers="headers"
        :items="items"
        @openTask="openTask"
    >
        <template #customLine>
            <TableLigneTotalTimeSpendPerDay
                :days="days"
                :tasks="tasks"
            />
        </template>
    </Table>

    <ModalTask
        :task="taskSelected"
        :show="showModal"
        :states="states"
        @close="showModal = false"
    />
</template>
