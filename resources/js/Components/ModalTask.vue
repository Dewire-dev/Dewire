<script setup lang="ts">
import { reactive } from 'vue'
import { Task } from '@/Interfaces/Task'
import { useFormatTime } from '@/Composables/time'
import { useDate } from '@/Composables/date'

const emit = defineEmits(['close']);
const commentToAdd = ref<string>('');

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
    states: {
        type: Array,
        required: true,
    },
})

/*const taskForm: Task = reactive({
    task: props.task,
});*/

function convertLinksToAnchorTags(text: string) {
    const urlRegex = /(https?:\/\/[^\s]+)/g;
    const newLineRegex = /(?:\r\n|\r|\n)/g;
    return text
        .replace(urlRegex, '<a class="dark:text-white italic" href="$1" target="_blank">$1</a>')
        .replace(newLineRegex, '<br />');
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
            <!-- STATE + USERS ASSIGNED -->
            <section class="grid grid-cols-12">
                <div class="col-span-3 mr-3">
                    <Select
                        v-model:value="task.state"
                        :items="states"
                    />
                </div>
                <div class="col-span-9 flex">
                    <div v-for="user in task.users" :key="user.id" class="flex items-center mr-2">
                        <img class="w-10 h-10 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.firstname"/>
                        <span class="ml-2 font-bold">{{ user.firstname }} {{ user.lastname.slice(0, 1) }}.</span>
                    </div>
                </div>
            </section>
            <!-- DATE(S) + SCHEDULED TIME + TIME SPENT -->
            <section class="py-5 flex">
                <div class="flex mr-5">
                    <i-carbon-calendar class="mr-2 dark:text-white" />
                    <template v-if="useDate().datesAreOnSameDay(task.start_at, task.end_at)">
                        {{ useDate().formatDate(task.startAt, 'DD/MM/YYYY')}}
                    </template>
                    <template v-else>
                        {{ useDate().formatDate(task.start_at, 'DD/MM/YYYY')}} - {{ useDate().formatDate(task.end_at, 'DD/MM/YYYY') }}
                    </template>
                    ({{ useFormatTime().formatTimeHoursMinutes(task.scheduled_time) }})
                    </div>
                <div class="flex">
                    <i-carbon-time class="mr-2 dark:text-white" />
                    total time spent
                </div>
            </section>
            <!-- DESCRIPTION -->
            <section class="grid">
                <textarea class="dark:bg-gray-700 h-[350px] resize-none border rounded-md dark:text-white" v-model="task.description"/>
            </section>
            <!-- COMMENTS -->
            <section class="mt-5">
                <div v-for="task_comment in task.task_comments" class="grid grid-cols-12 mb-3">
                    <div class="col-span-1">
                        <img class="w-12 h-12 rounded-full object-cover" :src="task_comment.user.profile_photo_url" :alt="task_comment.user.firstname">
                    </div>
                    <div class="grid col-span-11 pl-2">
                        <div>
                            <span class="dark:text-white mr-1">{{ task_comment.user.firstname }} {{ task_comment.user.lastname }}</span>
                            <span>{{ useDate().formatDate(task_comment.created_at, 'DD/MM/YYYY HH:mm') }}</span>
                        </div>
                        <span v-html="convertLinksToAnchorTags(task_comment.comment)" />
                    </div>
                </div>

                <div class="mt-2">
                    <div class="grid">
                        <textarea class="dark:bg-gray-700 resize-none border rounded-md dark:text-white" v-model="commentToAdd" placeholder="Ajouter un commentaire..."/>
                    </div>
                    <Button class="mt-2 bg-white float-right">Envoyer</Button>
                </div>
            </section>
        </template>

        <template #footer>

        </template>
    </DialogModal>
</template>
