<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { datesAreOnSameDay, formatDate } from '@/Services/date'

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

function getTimeSpendOnOneTaskPerDay (userTimeSpends: Array<any>, date: Date): number {
    let timeSpend = 0

    userTimeSpends.forEach((userTimeSpend) => {
        if (datesAreOnSameDay(userTimeSpend.date, date)) {
            timeSpend += userTimeSpend.time
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

function getTimeSpendOnOneTask (userTimeSpends: Array<any>): number {
    let timeSpend = 0

    userTimeSpends.forEach((userTimeSpend) => {
        timeSpend += userTimeSpend.time
    });

    return timeSpend
}

const user = {
    firstName: 'Logan',
    lastName: 'LE SAUX',
}

const tasksUser = [
    {
        label: 'Tâche 1',
        description: 'Superbe tâche',
        startAt: '2023-03-27 00:00:00',
        endAt: '2023-03-30 00:00:00',
        state: 'En Cours',
        type: 'PROJET CLIENT',
        userTimeSpends: [
            {
                time: 60,
                description: 'Conception BDD 1h',
                date: '2023-03-27 00:00:00',
            },
            {
                time: 1,
                description: '1Minute',
                date: '2023-03-27 00:00:00',
            },
            {
                time: 3,
                description: '3Min',
                date: '2023-03-27 00:00:00',
            },
        ],
    },
    {
        label: 'Tâche 2',
        description: 'Superbe tâche',
        startAt: '2023-03-27 00:00:00',
        endAt: '2023-03-30 00:00:00',
        state: 'Terminé',
        type: 'PROJET CLIENT',
        userTimeSpends: [
            {
                time: 80,
                description: 'Conception BDD 1h20',
                date: '2023-03-28 00:00:00',
            },
            {
                time: 1,
                description: '1Minute',
                date: '2023-03-29 00:00:00',
            },
            {
                time: 150,
                description: 'desc:2h30',
                date: '2023-03-29 00:00:00',
            },
        ],
    },
    {
        label: 'Tâche 3',
        description: 'Superbe tâche',
        startAt: '2023-03-27 00:00:00',
        endAt: '2023-03-30 00:00:00',
        state: 'À Faire',
        type: 'INTERNE',
        userTimeSpends: [],
    },
    {
        label: 'Tâche 4',
        description: 'Superbe tâche',
        startAt: '2023-03-27 00:00:00',
        endAt: '2023-03-30 00:00:00',
        state: 'En Cours',
        type: 'PROJET CLIENT',
        userTimeSpends: [],
    },
];
</script>

<template>
    <Calendar v-model="dates" selectionMode="range" readonly/>
    <DataTable :value="tasksUser">
        <Column field="label" header="Label"></Column>
        <Column field="type" header="Type"></Column>
        <Column v-for="day in days" :header="day.label">
            <template #body="slotProps">
                {{ showTimeSpend(getTimeSpendOnOneTaskPerDay(slotProps.data.userTimeSpends, day.date)) }}
            </template>
        </Column>
        <Column field="userTimeSpend" header="Total">
            <template #body="slotProps">
                {{ showTimeSpend(getTimeSpendOnOneTask(slotProps.data.userTimeSpends)) }}
            </template>
        </Column>
    </DataTable>
    <!--    <AppLayout title="Time">-->
    <!--        <template #header>-->
    <!--            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">-->
    <!--                Dashboard-->
    <!--            </h2>-->
    <!--        </template>-->

    <!--        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">-->
    <!--            <h3 class="text-lg text-gray-800 dark:text-gray-200">-->
    <!--                Mes projets-->
    <!--            </h3>-->
    <!--            <div class="grid grid-cols-3 gap-6 mx-6 mt-12">-->
    <!--                <ProjectCard v-for="project in projects" :project="project" />-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </AppLayout>-->
</template>
