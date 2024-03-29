<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { Task } from '@/Interfaces/Task'
import { TaskTimeSpend } from '@/Interfaces/TaskTimeSpend'
import ItemHeader from '@/Interfaces/ItemHeader'
import Item from "@/Interfaces/Item";
import {useDate} from "@/Composables/date";
import route from "ziggy-js";
import axios from "axios";
import { User } from "@/Interfaces/User";
import TableTime from "@/Components/TableTime.vue";
import {useFormatTime} from "@/Composables/time";

const currentUserSelected = ref<User>();
const userConnected = ref<User>();
const tasks = ref<Array<Task>>([]);
const firstDayOfWeek = ref();
const lastDayOfWeek = ref();
const users = ref<Array<User>>([]);
const states = ref<Array<string>>([]);

const waitingBeforeSendingRequest = ref(false)
const waitingChangingUserBeforeSendingRequest = ref(false)

const props = defineProps<{
    currentUserSelected: User,
    userConnected: User,
    firstDayOfWeek: string,
    lastDayOfWeek: string,
    tasks: Array<Task>;
    users: Array<User>;
    states: Array<string>;
}>();

onBeforeMount(() => {
    currentUserSelected.value = props.currentUserSelected
    userConnected.value = props.userConnected
    tasks.value = props.tasks
    firstDayOfWeek.value = props.firstDayOfWeek
    lastDayOfWeek.value = props.lastDayOfWeek
    users.value = props.users
    states.value = props.states
})

const days = computed(() => {
    const date = new Date(firstDayOfWeek.value)
    const monday = new Date(date)
    const tuesday = new Date(date.setDate(date.getDate() + 1))
    const wednesday = new Date(date.setDate(date.getDate() + 1))
    const thursday = new Date(date.setDate(date.getDate() + 1))
    const friday = new Date(date.setDate(date.getDate() + 1))
    return [
        {
            label: 'monday',
            date: monday,
        },
        {
            label: 'tuesday',
            date: tuesday,
        },
        {
            label: 'wednesday',
            date: wednesday,
        },
        {
            label: 'thursday',
            date: thursday,
        },
        {
            label: 'friday',
            date: friday,
        },
    ]
});

const headers = computed((): Array<ItemHeader> => [
    {
        text: 'Tâches',
        value: 'task',
    },
    {
        text: 'Projets',
        value: 'project',
    },
    {
        text: 'Catégorie',
        value: 'category',
    },
    {
        text: getFormatDateByLabel('monday'),
        value: 'monday',
    },
    {
        text: getFormatDateByLabel('tuesday'),
        value: 'tuesday',
    },
    {
        text: getFormatDateByLabel('wednesday'),
        value: 'wednesday',
    },
    {
        text: getFormatDateByLabel('thursday'),
        value: 'thursday',
    },
    {
        text: getFormatDateByLabel('friday'),
        value: 'friday',
    },
    {
        text: 'Total',
        value: 'total',
    },
]);

const items = computed((): Array<Array<Item>> => {
    return tasks.value.map((task: Task) => {
        return [
            {
                id: task.id,
                text: task.label,
                value: 'task',
                bold: true,
                clickableText: true,
                eventToEmit: 'openTask',
            },
            {
                id: task.id,
                text: task.project ? task.project.title : '',
                value: 'project',
                bold: true,
            },
            {
                id: task.id,
                text: task.type,
                value: 'category',
            },
            {
                id: task.id,
                text: useFormatTime().formatTimeHoursMinutes(getTimeSpendOnOneTask(task.task_time_spends)),
                value: 'total'
            },
            {
                id: task.id,
                text: useFormatTime().formatTimeHoursMinutes(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('monday').date)),
                date: useDate().formatDate(getDayByLabel('monday').date, 'YYYY-MM-DD'),
                value: 'monday',
                clickableItem: true,
                eventToEmit: 'openTime',
                iconHoverAdd: true,
            },
            {
                id: task.id,
                text: useFormatTime().formatTimeHoursMinutes(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('tuesday').date)),
                date: useDate().formatDate(getDayByLabel('tuesday').date, 'YYYY-MM-DD'),
                value: 'tuesday',
                clickableItem: true,
                eventToEmit: 'openTime',
                iconHoverAdd: true,
            },
            {
                id: task.id,
                text: useFormatTime().formatTimeHoursMinutes(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('wednesday').date)),
                date: useDate().formatDate(getDayByLabel('wednesday').date, 'YYYY-MM-DD'),
                value: 'wednesday',
                clickableItem: true,
                eventToEmit: 'openTime',
                iconHoverAdd: true,
            },
            {
                id: task.id,
                text: useFormatTime().formatTimeHoursMinutes(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('thursday').date)),
                date: useDate().formatDate(getDayByLabel('thursday').date, 'YYYY-MM-DD'),
                value: 'thursday',
                clickableItem: true,
                eventToEmit: 'openTime',
                iconHoverAdd: true,
            },
            {
                id: task.id,
                text: useFormatTime().formatTimeHoursMinutes(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('friday').date)),
                date: useDate().formatDate(getDayByLabel('friday').date, 'YYYY-MM-DD'),
                value: 'friday',
                clickableItem: true,
                eventToEmit: 'openTime',
                iconHoverAdd: true,
            },
        ]
    })
});

function getTimeSpendOnOneTaskPerDay (taskTimeSpends: Array<TaskTimeSpend>, date: Date): number {
    let timeSpend = 0

    taskTimeSpends.forEach((taskTimeSpend) => {
        if (useDate().datesAreOnSameDay(taskTimeSpend.date, date)) {
            timeSpend += taskTimeSpend.time
        }
    });

    return timeSpend
}

function getTimeSpendOnOneTask (taskTimeSpends: Array<TaskTimeSpend>): number {
    let timeSpend = 0

    taskTimeSpends.forEach((taskTimeSpend) => {
        if (taskTimeSpend.date >= firstDayOfWeek.value && taskTimeSpend.date <= lastDayOfWeek.value) {
            timeSpend += taskTimeSpend.time
        }
    });

    return timeSpend
}

function getDayByLabel (label: string): any {
    return days.value.find((day: any) => {
        if (day.label === label) {
            return day
        }
    })
}

function getFormatDateByLabel (label: string): string {
    const day = getDayByLabel(label)
    return day ? useDate().formatDate(day.date, 'dddd DD MMMM').toUpperCase() : ''
}

async function getPreviousWeek () {
    if (waitingBeforeSendingRequest.value === true) {
        return
    }

    waitingBeforeSendingRequest.value = true
    const response = await axios.get(
        route('time.getPreviousWeek', {
            date: firstDayOfWeek.value,
            user: currentUserSelected.value ? currentUserSelected.value.id : '',
            previous: true,
        }),
    )

    tasks.value = response.data.tasks
    firstDayOfWeek.value = response.data.firstDay
    lastDayOfWeek.value = response.data.lastDay
    waitingBeforeSendingRequest.value = false
}

async function getNextWeek () {
    if (waitingBeforeSendingRequest.value === true) {
        return
    }

    waitingBeforeSendingRequest.value = true
    const response = await axios.get(
        route('time.getNextWeek', {
            date: firstDayOfWeek.value,
            user: currentUserSelected.value ? currentUserSelected.value.id : '',
            next: true,
        }),
    )

    tasks.value = response.data.tasks
    firstDayOfWeek.value = response.data.firstDay
    lastDayOfWeek.value = response.data.lastDay
    waitingBeforeSendingRequest.value = false
}

async function changeUser (userSelected: User) {
    if (waitingChangingUserBeforeSendingRequest.value === true) {
        return
    }
    currentUserSelected.value = userSelected

    waitingChangingUserBeforeSendingRequest.value = true
    const response = await axios.get(
        route('time.getTasksByUser', {
            date: firstDayOfWeek.value,
            user: currentUserSelected.value ? currentUserSelected.value.id : '',
            next: true,
        }),
    )

    tasks.value = response.data.tasks
    waitingChangingUserBeforeSendingRequest.value = false
}

async function reloadTasks () {
    const response = await axios.get(
        route('time.getTasksByUser', {
            date: firstDayOfWeek.value,
            user: currentUserSelected.value ? currentUserSelected.value.id : '',
            next: true,
        }),
    )

    tasks.value = response.data.tasks
    waitingChangingUserBeforeSendingRequest.value = false
}
</script>

<template>
    <AppLayout title="Time">
        <template #header>
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-200">
                Time
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                Mes tâches et temps saisis
            </h3>
            <div class="mx-6 mt-12">
                <div class="flex flex-col lg:flex-row items-center mb-3 lg:justify-between">
                    <div class="flex lg:items-center">
                        <i-carbon-chevron-left class="cursor-pointer dark:text-white text-3xl" @click="getPreviousWeek" />
                        <div class="bg-gray-100 dark:bg-gray-900 rounded py-3 px-8 text-gray-900 dark:text-white">
                            {{ useDate().formatDate(firstDayOfWeek, 'DD/MM/YYYY') }} - {{ useDate().formatDate(lastDayOfWeek, 'DD/MM/YYYY') }}
                        </div>
                        <i-carbon-chevron-right class="cursor-pointer dark:text-white text-3xl" @click="getNextWeek" />
                    </div>

                    <SelectUser :items="users" :value="currentUserSelected" content-classes="mt-5 lg:mt-0" @change="changeUser"/>
                </div>
                <template v-if="!waitingBeforeSendingRequest && !waitingChangingUserBeforeSendingRequest">
                    <TableTime
                        :headers="headers"
                        :items="items"
                        :days="days"
                        :tasks="tasks"
                        :states="states"
                        :current-user-selected="currentUserSelected"
                        :user-connected="userConnected"
                        @reloadTasks="reloadTasks"
                    />
                </template>
                <Loader v-else/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
</style>
