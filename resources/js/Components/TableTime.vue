<script setup lang="ts">
import Item from '@/Interfaces/Item'
import ItemHeader from '@/Interfaces/ItemHeader'
import {Task} from "@/Interfaces/Task";

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
});

</script>

<template>
    <Table
        :headers="headers"
        :items="items"
    >
        <template #customLine>
            <TableLigneTotalTimeSpendPerDay
                :days="days"
                :tasks="tasks"
            />
        </template>
    </Table>
</template>
