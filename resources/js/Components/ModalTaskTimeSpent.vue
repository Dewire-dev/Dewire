<script setup lang="ts">
import { useFormatTime } from '@/Composables/time'
import {TaskTimeSpend} from "@/Interfaces/TaskTimeSpend";
import axios from "axios";
import route from "ziggy-js";
import {Task} from "@/Interfaces/Task";

const emit = defineEmits(['close', 'reload']);

const props = defineProps({
    date: {
        type: Date,
        required: true,
    },
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
    readonly: {
        type: Boolean,
        default: false,
    },
})

function addTaskTimeSpend() {
    let oneTimeIsNotValid = false
    for (const taskTimeSpend of props.taskTimeSpends as TaskTimeSpend[]) {
        if (!taskTimeSpend.time) {
            oneTimeIsNotValid = true;
            break;
        }
    }

    if (oneTimeIsNotValid) {
        return
    }

    props.taskTimeSpends.push({
        time: undefined,
        description: '',
    })
}

async function saveTaskTimeSpends () {
    const dataToSave: Array<TaskTimeSpend> = []
    for (const taskTimeSpend of props.taskTimeSpends as TaskTimeSpend[]) {
        if (taskTimeSpend.time && useFormatTime().validateTime(taskTimeSpend.time.toString())) {
            dataToSave.push({
                id: taskTimeSpend?.id,
                time: useFormatTime().validateTime(taskTimeSpend.time.toString()) as number,
                task_id: props.task.id,
                description: taskTimeSpend.description,
                date: taskTimeSpend.date ?? props.date,
            })
        }
    }

    await axios.put(
        route('tasks.updateTaskTimeSpends', {
            task: props.task.id,
        }),
        {
            taskTimeSpends: dataToSave,
        },
    )

    emit('reload')
    emit('close')
}

async function deleteTaskTimeSpend (id: number, index: number) {
    // remove from taskTimeSpends
    props.taskTimeSpends?.splice(index, 1)
    if(id) {
        await axios.delete(
            route('tasks.deleteTaskTimeSpends', {
                task: props.task.id,
                taskTimeSpend: id,
            })
        )
        emit('reload')
    }
}
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
                <div v-for="(taskTimeSpend, index) in taskTimeSpends" class="grid grid-cols-12 flex justify-around my-5">
                    <div class="col-span-2 mx-2">
                        <TextInput
                            v-model="taskTimeSpend.time"
                            name="time"
                            classes="p-1 w-100"
                            :readonly="readonly"
                        />
                    </div>
                    <div class="col-span-9 mx-2">
                        <TextInput
                            v-model="taskTimeSpend.description"
                            name="description"
                            classes="p-1 w-100"
                            :readonly="readonly"
                        />
                    </div>
                    <div class="col-span-1 flex justify-end items-center">
                        <i-carbon-trash-can class="cursor-pointer" @click="deleteTaskTimeSpend(taskTimeSpend?.id, index)" />
                    </div>
                </div>
                <section v-if="!readonly" class="grid grid-cols-12 column">
                    <div class="col-span-5">
                        <SecondaryButton class="primary" @click="addTaskTimeSpend()">Ajouter un temps...</SecondaryButton>
                    </div>
                    <div class="col-span-2"></div> <!-- Espace vide -->
                    <div class="col-span-5">
                        <SecondaryButton v-if="taskTimeSpends.length > 0" @click="saveTaskTimeSpends">Sauvegarder les temps ajoutés</SecondaryButton>
                    </div>
                </section>
            </section>
        </template>

        <template #footer>

        </template>
    </DialogModal>
</template>
