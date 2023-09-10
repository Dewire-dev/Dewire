<script setup lang="ts">
import Item from '@/Interfaces/Item'
import ItemHeader from '@/Interfaces/ItemHeader'
import { Task } from "@/Interfaces/Task"
import { TaskTimeSpend } from "@/Interfaces/TaskTimeSpend"
import axios from "axios"
import route from "ziggy-js";
import {TaskComment} from "@/Interfaces/TaskComment";

const emit = defineEmits(['reloadTasks']);

const showModalTask = ref(false)
const showModalTaskTimeSpend = ref(false)

const taskSelected = ref<Task|null>(null);
const taskTimeSpends = ref<Array<TaskTimeSpend>>([]);
const dateTaskTimeSpend = ref(null);

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
    userConnected: {
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
    const response = await axios.get(
        route('tasks.taskTimeSpends', {
            task: (item.id as number),
            date: (item.date as string),
            user: props.currentUserSelected.id,
        }),
    )

    taskSelected.value = response.data.task;
    const taskTimeSpendsFormatted: Array<TaskTimeSpend> = []
    response.data.taskTimeSpends.forEach((taskTimeSpend: TaskTimeSpend) => {
        taskTimeSpendsFormatted.push({
            id: taskTimeSpend.id,
            task_id: (taskSelected.value as Task).id,
            time: useFormatTime().formatTimeHoursMinutes(taskTimeSpend.time as number),
            description: taskTimeSpend.description,
            date: taskTimeSpend.date,
        })
    })
    taskTimeSpends.value = taskTimeSpendsFormatted
    dateTaskTimeSpend.value = item.date
    showModalTaskTimeSpend.value = true
}

async function sendComment(comment: string) {
    if (comment.length === 0) {
        return
    }
    const response = await axios.post(
        route('tasks.addComment', {
            task: (taskSelected.value as Task).id,
        }), {
            comment: comment,
        },
    )

    taskSelected.value = response.data.task
}

async function deleteComment(taskComment: TaskComment) {
    const response = await axios.delete(
        route('tasks.deleteComment', {
            task: (taskSelected.value as Task).id,
            taskComment: taskComment.id,
        }),
    )

    taskSelected.value = response.data.task
}

async function saveTask() {
    const response = await axios.put(
        route('tasks.update', {
            id: (taskSelected.value as Task).id as number,
        }),
        {
            state: (taskSelected.value as Task).state,
            description: (taskSelected.value as Task).description as string,
        },
    )

    taskSelected.value = response.data.task;
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
        @sendComment="sendComment"
        @deleteComment="deleteComment"
        @saveTask="saveTask"
    />

    <ModalTaskTimeSpent
        v-if="taskSelected"
        :date="dateTaskTimeSpend"
        :task-time-spends="taskTimeSpends"
        :task="taskSelected"
        :show="showModalTaskTimeSpend"
        :readonly="userConnected.id !== currentUserSelected.id"
        @reload="emit('reloadTasks')"
        @close="showModalTaskTimeSpend = false"
    />
</template>
