<script setup lang="ts">
import { useFormatTime } from '@/Composables/time'

const emit = defineEmits(['close']);

const props = defineProps({
    taskTimeSpends: {
        type: Array,
        required: true,
    },
    task: {
        type: Object,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <DialogModal :show="show" @close="emit('close')">
        <template #title>
            <section class="grid grid-cols-12">
                <div class="col-span-11">
                    <span v-if="task.project">[{{ task.project.title }}] </span>{{ task.label }}
                </div>
                <div class="col-span-1 flex justify-end items-center">
                    <i-carbon-close class="cursor-pointer" @click="emit('close')" />
                </div>
            </section>
        </template>

        <template #content>
            <section>
                <div v-for="taskTimeSpend in taskTimeSpends" class="grid grid-cols-12 flex justify-around">
                    <div class="col-span-2 mx-2">
                        <TextInput :value="useFormatTime().formatTimeHoursMinutes(taskTimeSpend.time)" name="time" class="p-1 w-100"/>
                    </div>
                    <div class="col-span-10 mx-2">
                        <TextInput :value="taskTimeSpend.description" name="description" class="p-1 w-100"/>
                    </div>
                </div>
            </section>
        </template>

        <template #footer>

        </template>
    </DialogModal>
</template>
