<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { datesAreOnSameDay, useFormatDate } from '@/Composables/date'
import { Task } from '@/Interfaces/Task'
import { TaskTimeSpend } from '@/Interfaces/TaskTimeSpend'
import ItemHeader from '@/Interfaces/ItemHeader'
import Item from "@/Interfaces/Item";

const currentDate = ref(new Date())
const monday = ref();
const tuesday = ref();
const wednesday = ref();
const thursday = ref();
const friday = ref();

const currentUserSelected = ref();
const users = ref();

const props = defineProps<{
    tasks: Array<Task>;
    // users: Array<User>;
}>();

onBeforeMount(() => {
    monday.value = currentDate.value.getDate() - currentDate.value.getDay() + 1;
    tuesday.value = monday.value + 1;
    wednesday.value = monday.value + 2;
    thursday.value = monday.value + 3;
    friday.value = monday.value + 4;
    monday.value = new Date(currentDate.value.setDate(monday.value));
    tuesday.value = new Date(currentDate.value.setDate(tuesday.value));
    wednesday.value = new Date(currentDate.value.setDate(wednesday.value));
    thursday.value = new Date(currentDate.value.setDate(thursday.value));
    friday.value = new Date(currentDate.value.setDate(friday.value));
})

const dates = computed(() => [monday.value, friday.value])

const days = computed(() => {
    return [
        {
            label: 'monday',
            date: monday.value,
        },
        {
            label: 'tuesday',
            date: tuesday.value,
        },
        {
            label: 'wednesday',
            date: wednesday.value,
        },
        {
            label: 'thursday',
            date: thursday.value
        },
        {
            label: 'friday',
            date: friday.value,
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
    return props.tasks.map((task: Task) => {
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
        if (datesAreOnSameDay(taskTimeSpend.date, date)) {
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
    return day ? useFormatDate(day.date, 'dddd DD MMMM').toUpperCase() : ''
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
                <!--<Calendar v-model="dates" selectionMode="range" readonly/>-->
                <Table
                    :headers="headers"
                    :items="items"
                />
            </div>
        </div>
    </AppLayout>
</template>
