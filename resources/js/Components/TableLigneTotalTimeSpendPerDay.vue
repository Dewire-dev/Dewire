<script setup lang="ts">
import { Task } from '@/Interfaces/Task'
import { useDate } from "@/Composables/date";
import { useFormatTime } from "../Composables/time";

interface Day {
    label: String,
    date: Date,
}

const props = defineProps({
    days: {
        type: Array<Day>,
        default: [],
    },
    tasks: {
        type: Array<Task>,
        default: [],
    },
});

const firstDayOfWeek = computed(() => {
    let date = null
    props.days.forEach((day: Day) => {
        if (date === null || date > day.date) {
            date = day.date
        }
    })

    date.setHours(0, 0, 0, 0)
    return date
})

const lastDayOfWeek = computed(() => {
    let date = null
    props.days.forEach((day: Day) => {
        if (date === null || date < day.date) {
            date = day.date
        }
    })

    date.setHours(23, 59, 59, 59)
    return date
})

function getTotalTimeSpendOnOneDay (day: Date) {
    let total = 0

    props.tasks.forEach((task: Task) => {
        task.task_time_spends.forEach((taskTimeSpend: TaskTimeSpend) => {
            if (useDate().datesAreOnSameDay(day, taskTimeSpend.date)) {
                total += taskTimeSpend.time
            }
        })
    })

    return total
}

function getTotalTimeSpend () {
    let total = 0

    props.tasks.forEach((task: Task) => {
        task.task_time_spends.forEach((taskTimeSpend: TaskTimeSpend) => {
            const date = new Date(taskTimeSpend.date)
            if (firstDayOfWeek.value < date && lastDayOfWeek.value > date) {
                total += taskTimeSpend.time
            }
        })
    })

    return total
}
</script>

<template>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <td colspan="2" class="px-6 py-4 font-bold">Total: {{ tasks.length }} {{ (tasks.length > 1) ? 'tâches' : 'tâche' }}</td>
        <td v-for="day in days" class="px-6 py-4 text-center font-bold">
            {{ useFormatTime().formatTimeSpend(getTotalTimeSpendOnOneDay(day.date)) }}
        </td>
        <td class="px-6 py-4 text-center font-bold">{{ useFormatTime().formatTimeSpend(getTotalTimeSpend()) }}</td>
    </tr>
</template>
