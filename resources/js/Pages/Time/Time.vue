<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { Task } from '@/Interfaces/Task'
import { TaskTimeSpend } from '@/Interfaces/TaskTimeSpend'
import ItemHeader from '@/Interfaces/ItemHeader'
import Item from "@/Interfaces/Item";
import {useDate} from "@/Composables/date";
import route from "ziggy-js";
import axios from "axios";

const currentUserSelected = ref();
const tasks = ref<Array<Task>>([]);
const firstDayOfWeek = ref();
const lastDayOfWeek = ref();
const users = ref([]);

const waitingBeforeSendingRequest = ref(false)

const props = defineProps<{
    firstDayOfWeek: string,
    lastDayOfWeek: string,
    tasks: Array<Task>;
    // users: Array<User>;
}>();

onBeforeMount(() => {
    tasks.value = props.tasks
    firstDayOfWeek.value = props.firstDayOfWeek
    lastDayOfWeek.value = props.lastDayOfWeek
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
                text: task.label,
                value: 'task',
                bold: true,
            },
            {
                text: task.type,
                value: 'category',
            },
            {
                text: formatTimeSpend(getTimeSpendOnOneTask(task.task_time_spends)),
                value: 'total'
            },
            {
                text: formatTimeSpend(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('monday').date)),
                value: 'monday',
            },
            {
                text: formatTimeSpend(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('tuesday').date)),
                value: 'tuesday',
            },
            {
                text: formatTimeSpend(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('wednesday').date)),
                value: 'wednesday',
            },
            {
                text: formatTimeSpend(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('thursday').date)),
                value: 'thursday',
            },
            {
                text: formatTimeSpend(getTimeSpendOnOneTaskPerDay(task.task_time_spends, getDayByLabel('friday').date)),
                value: 'friday',
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

function formatTimeSpend (timeSpend: number): string {
    let hours: number = 0
    let minutes: number = 0

    if (timeSpend < 60) {
        return timeSpend + 'm'
    }

    minutes = timeSpend % 60
    hours = (timeSpend - minutes) / 60

    return hours + 'h' + ((minutes < 10) ? '0' : '') + minutes + 'm'
}

function getTimeSpendOnOneTask (taskTimeSpends: Array<TaskTimeSpend>): number {
    let timeSpend = 0

    taskTimeSpends.forEach((taskTimeSpend) => {
        timeSpend += taskTimeSpend.time
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
            next: true,
        }),
    )

    tasks.value = response.data.tasks
    firstDayOfWeek.value = response.data.firstDay
    lastDayOfWeek.value = response.data.lastDay
    waitingBeforeSendingRequest.value = false
}
</script>

<template>
    <AppLayout title="Time">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Time
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h3 class="text-lg text-gray-800 dark:text-gray-200">
                Mes tâches et temps saisis
            </h3>
            <div class="mx-6 mt-12">
                <div class="flex">
                    <i-carbon-chevron-left class="cursor-pointer" @click="getPreviousWeek" />
                    <span>{{ useDate().formatDate(firstDayOfWeek, 'DD/MM/YYYY') }} - {{ useDate().formatDate(lastDayOfWeek, 'DD/MM/YYYY') }}</span>
                    <i-carbon-chevron-right class="cursor-pointer" @click="getNextWeek" />
                </div>
                <Table
                    :headers="headers"
                    :items="items"
                />
            </div>
        </div>
    </AppLayout>
</template>
