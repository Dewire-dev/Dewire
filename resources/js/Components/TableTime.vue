<script setup lang="ts">
import Item from '@/Interfaces/Item'
import ItemHeader from '@/Interfaces/ItemHeader'
import { Task } from "@/Interfaces/Task"
import { TaskTimeSpend } from "@/Interfaces/TaskTimeSpend"
import axios from "axios"
import route from "ziggy-js";

const showModalTask = ref(false)
const showModalTaskTimeSpend = ref(false)

const taskSelected = ref<Task|null>(null);
const taskTimeSpends = ref<Array<TaskTimeSpend>>([]);

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
    currentUserSelected: {
        type: Object,
        required: true,
    },
});

async function openTask(item: Item) {
    const response = await axios.get(
        route('tasks.show', {
            id: item.id as number,
        }),
    )

    taskSelected.value = response.data.task;
    showModalTask.value = true
}

async function openTime(item: Item) {
    console.log(props.currentUserSelected)
    const response = await axios.get(
        route('tasks.taskTimeSpends', {
            task: (item.id as number),
            date: (item.date as string),
            user: props.currentUserSelected.id,
        }),
    )

    taskSelected.value = response.data.task;
    taskTimeSpends.value = response.data.taskTimeSpends;
    showModalTaskTimeSpend.value = true
}

</script>

<template>
    <Table
        :headers="headers"
        :items="items"
        @openTask="openTask"
        @openTime="openTime"
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
        :show="showModalTask"
        :states="states"
        @close="showModalTask = false"
    />

    <ModalTaskTimeSpent
        :task-time-spends="taskTimeSpends"
        :task="taskSelected"
        :show="showModalTaskTimeSpend"
        @close="showModalTaskTimeSpend = false"
    />


</template>
