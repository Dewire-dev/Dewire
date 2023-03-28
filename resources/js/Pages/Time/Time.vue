<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { datesAreOnSameDay, formatDate } from '@/Services/date'
import {Task} from "@/Interfaces/Task";

const currentDate = ref(new Date())
const monday = ref();
const tuesday = ref();
const wednesday = ref();
const thursday = ref();
const friday = ref();

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
            label: formatDate(monday.value, 'dddd DD MMMM').toUpperCase(),
            date: monday.value,
        },
        {
            label: formatDate(tuesday.value, 'dddd DD MMMM').toUpperCase(),
            date: tuesday.value,
        },
        {
            label: formatDate(wednesday.value, 'dddd DD MMMM').toUpperCase(),
            date: wednesday.value,
        },
        {
            label: formatDate(thursday.value, 'dddd DD MMMM').toUpperCase(),
            date: thursday.value
        },
        {
            label: formatDate(friday.value, 'dddd DD MMMM').toUpperCase(),
            date: friday.value,
        },
    ]
});

function getTimeSpendOnOneTaskPerDay (taskTimeSpends: Array<any>, date: Date): number {
    let timeSpend = 0

    console.log(taskTimeSpends)
    taskTimeSpends.forEach((taskTimeSpend) => {
        if (datesAreOnSameDay(taskTimeSpend.date, date)) {
            timeSpend += taskTimeSpend.time
        }
    });

    return timeSpend
}

function showTimeSpend (timeSpend: number): string {
    let hours: number = 0
    let minutes: number = 0

    if (timeSpend < 60) {
        return timeSpend + 'm'
    }

    minutes = timeSpend % 60
    hours = (timeSpend - minutes) / 60

    return hours + 'h' + ((minutes < 10) ? '0' : '') + minutes + 'm'
}

function getTimeSpendOnOneTask (taskTimeSpends: Array<any>): number {
    let timeSpend = 0

    taskTimeSpends.forEach((taskTimeSpend) => {
        timeSpend += taskTimeSpend.time
    });

    return timeSpend
}

const user = {
    firstName: 'Logan',
    lastName: 'LE SAUX',
}

defineProps<{
    tasks: Array<Task>;
}>();
</script>

<template>
    <AppLayout title="Time">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h3 class="text-lg text-gray-800 dark:text-gray-200">
                Mes tâches et temps saisis
            </h3>
            <div class="mx-6 mt-12">
                <Calendar v-model="dates" selectionMode="range" readonly/>
                <DataTable :value="tasks">
                    <Column field="label" header="Label"></Column>
                    <Column field="type" header="Type"></Column>
                    <Column v-for="day in days" :header="day.label">
                        <template #body="slotProps">
                            {{ showTimeSpend(getTimeSpendOnOneTaskPerDay(slotProps.data.task_time_spends, day.date)) }}
                        </template>
                    </Column>
                    <Column field="userTimeSpend" header="Total">
                        <template #body="slotProps">
                            {{ showTimeSpend(getTimeSpendOnOneTask(slotProps.data.task_time_spends)) }}
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
