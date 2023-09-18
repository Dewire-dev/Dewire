<script setup lang="ts">
import draggable from "vuedraggable";
import {Input} from "flowbite-vue";
import route from "ziggy-js";
import axios from "axios";
import Multiselect from '@vueform/multiselect'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {useDate} from '@/Composables/date'
import {useDark} from "@vueuse/core";
import {useFormatTime} from "@/Composables/time";

const {project, kanban_list, kanban} = defineProps<{
    project: App.Models.Project;
    kanban_list: Object;
    kanban: Object;
    members: any;
}>();

const storeKanbanTaskForm = useForm({
    name: "",
    members: [],
    description: "",
    date_start: "",
    date_end: "",
    scheduled_time: "",
    kanban_list_id: kanban_list.id,
})
const updateKanbanTaskForm = useForm({
    name: "",
    members: [],
    description: "",
    date_start: "",
    date_end: "",
    scheduled_time: "",
    kanban_list_id: kanban_list.id,
})
let errorsBag = Object;
let enabled = true;
let dragging = false;
let position = 1;
const addingTask = ref(false);
const createNewTask = ref(false);
const tasks = ref(kanban_list.tasks)
const isDark = useDark();
const dragOptions = () => {
    return {
        animation: 200,
        group: "description",
        disabled: !enabled,
        ghostClass: "ghost",
    };
};

const storeKanbanTask = (isUpdate = false) => {
    if (isUpdate) {
        updateKanbanTaskForm
            .patch(route('kanban_tasks.update', {
                kanban_task: updateKanbanTaskForm.id,
                kanban: kanban,
                project: project
            }), {
                onSuccess: () => {
                    return Promise.all([
                        closeTaskModal(true)
                    ])
                }
            });
    } else {
        storeKanbanTaskForm.clearErrors();
        storeKanbanTaskForm
            .post(route('kanban_tasks.store', {
                project: project,
                kanban: kanban,
            }), {
                onSuccess: () => {
                    return Promise.all([
                        storeKanbanTaskForm.name = "",
                        storeKanbanTaskForm.description = "",
                        storeKanbanTaskForm.members = [],
                        storeKanbanTaskForm.date_start = "",
                        storeKanbanTaskForm.date_end = "",
                        storeKanbanTaskForm.scheduled_time = "",

                        closeTaskModal()
                    ])
                }, onError: (response) => {
                    storeKanbanTaskForm.setError(response);
                }
            });
    }
};

const closeTaskModal = (isUpdate = false) => {
    if (isUpdate) {
        addingTask.value = false
    } else {
        createNewTask.value = false;
        storeKanbanTaskForm.clearErrors();
    }
};
const updateKanbanTaskModal = async (element) => {
    const response = await axios.get(
        route('kanban-tasks-get-members', {
            kanban_task: element,
            project: project,
        })
    )
    var membersTest = Object.keys(response.data.members).map(function (key) {
        return key;
    });
    updateKanbanTaskForm.id = element.id;
    updateKanbanTaskForm.name = element.name;
    updateKanbanTaskForm.description = element.description;
    updateKanbanTaskForm.date_start = element.date_start;
    updateKanbanTaskForm.date_end = element.date_end;
    updateKanbanTaskForm.scheduled_time = element.scheduled_time / 60;
    updateKanbanTaskForm.members = membersTest;

    addingTask.value = true;
};
const createNewKanbanTaskModal = () => {
    createNewTask.value = true;
};

watch(() => tasks, (newTasks) => tasks.value = newTasks);

async function updateMoveCard(e) {
    let item = e.added || e.moved;

    if (!item) return;

    let index = item.newIndex;
    let prevCard = tasks.value[index - 1];
    let nextCard = tasks.value[index + 1];
    let task = tasks.value[index];
    let position = task.position;

    if (prevCard && nextCard) {
        position = (prevCard.position + nextCard.position) / 2;
    } else if (prevCard) {
        position = prevCard.position + (prevCard.position / 2);
    } else if (nextCard) {
        position = nextCard.position / 2;
    }

    const response = await axios.post(
        route('kanban-tasks-update-position', {
            kanban_task: task,
            project: project,
        }), {
            position: position,
            kanban_list_id: kanban_list.id,
        },
    )
}

// Remove Task
const destroyTaskForm = useForm<{
    id?: number;
}>({
    id: undefined,
});
const destroyKanbanTask = (element) => {
    destroyTaskForm.id = element.id;
    destroyTaskForm.delete(
        route("kanban_tasks.destroy", {
            project: project,
            kanban_task: destroyTaskForm.id,
            kanban: kanban
        }));
};

</script>

<template>
    <draggable
        :list="kanban_list.tasks"
        :disabled="!enabled"
        item-key="name"
        ghost-class="ghost"
        group="tasks"
        v-bind="dragOptions"
        tag="ul"
        class="list-group space-y-3 px-3"
        @start="dragging = true"
        @end="dragging = false"
        @change="updateMoveCard"
    >
        <template #item="{ element }">
            <li @click="updateKanbanTaskModal(element)" :class="{ 'not-draggable': !enabled }"
                class="group relative bg-white p-3 shadow rounded-md border-b border-gray-300 hover:cursor-pointer">
                <button
                    @click.prevent.stop="destroyKanbanTask(element)"
                    class="hidden absolute top-1 right-1 w-8 h-8 group-hover:grid place-content-center rounded-md text-gray-600 hover:text-black hover:bg-gray-200">
                    <i-carbon-close class="w-5 h-5"/>
                </button>
                <div>
                    {{ element.name }}
                </div>
                <div v-if="element.date_start != null && element.date_end != null" class="flex space-x-1">
          <span class="dark:text-gray-400">{{ useDate().formatDate(element.date_start, 'DD/MM/YYYY') }} -  {{
                  useDate().formatDate(element.date_end, 'DD/MM/YYYY')
              }}</span>
                </div>
                <div class="flex space-x-1">
                    <template v-for="member in element.task.users">
                        <img :title="member.firstname+ ' ' + member.lastname" class="w-5 h-5 rounded-full object-cover"
                             :src="'https://ui-avatars.com/api/?name='+member.firstname.slice(0, 1)+member.lastname.slice(0, 1)+'&color=FFFFFF&amp;background=1f2937'"
                             alt="Théo">
                    </template>
                </div>
            </li>
        </template>
    </draggable>
    <!--  Update Task-->
    <DialogModal :isOverFlow="false" :show="addingTask" @close="closeTaskModal(true)">
        <template #title>Modifier la tâche</template>

        <template #content>
            <div>
                <label
                    class="block mb-2 text-sm font-medium "
                    :class="updateKanbanTaskForm.errors.name ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Nom</label>
                <div class="flex relative">
                    <input placeholder="Nom de la tâche"
                           v-model="updateKanbanTaskForm.name"
                           v-on:keyup.enter="storeKanbanTask(true)"
                           type="text"
                           :class="updateKanbanTaskForm.errors.name
                 ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 text-black'
                 : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'">
                </div>
                <span v-if="updateKanbanTaskForm.errors.name" class="text-red-600">
                    {{ updateKanbanTaskForm.errors.name }}
                </span>
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium"
                       :class="updateKanbanTaskForm.errors.description ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Description</label>
                <div class="flex relative">
          <textarea
              :class="updateKanbanTaskForm.errors.description
                 ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 text-black'
                 : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'"
              v-model="updateKanbanTaskForm.description"
              v-on:keyup.enter="storeKanbanTask(true)"
              required
              placeholder="Description de la tâche"
          />
                </div>
                <span v-if="updateKanbanTaskForm.errors.description" class="text-red-600">
            {{ updateKanbanTaskForm.errors.description }}
          </span>
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium"
                       :class="updateKanbanTaskForm.errors.members ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Responsable(s)</label>
                <div class="flex relative">
                    <Multiselect
                        :classes="{
                            dropdown: 'max-h-60 multiselect-dropdown absolute -left-px -right-px bottom-0 transform translate-y-full -mt-px overflow-y-scroll z-50 dark:bg-gray-700 flex flex-col rounded',
                        }"
                        :class="updateKanbanTaskForm.errors.members
              ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full dark:bg-red-100 dark:border-red-400 text-black'
              : 'border w-full text-sm rounded border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500'"
                        v-model="updateKanbanTaskForm.members"
                        :options="members"
                        mode="tags"
                        :create-option="false"
                    ></Multiselect>
                </div>
                <span v-if="updateKanbanTaskForm.errors.members" class="text-red-600">
            {{ updateKanbanTaskForm.errors.members }}
          </span>
            </div>
            <div class="mt-2">
                <label
                    class="block mb-2 text-sm font-medium "
                    :class="updateKanbanTaskForm.errors.scheduled_time ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Temps estimé (en heures)</label>
                <div class="flex relative">
                    <input placeholder="Temps estimé"
                           v-model="updateKanbanTaskForm.scheduled_time"
                           type="text"
                           :class="updateKanbanTaskForm.errors.scheduled_time
                 ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 text-black'
                 : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'">
                </div>
                <span v-if="updateKanbanTaskForm.errors.scheduled_time" class="text-red-600">
            {{ updateKanbanTaskForm.errors.scheduled_time }}
          </span>
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium"
                       :class="updateKanbanTaskForm.errors.date_start ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Date
                    de début</label>
                <div class="flex relative">
                    <VueDatePicker
                        :input-class-name="updateKanbanTaskForm.errors.date_start
              ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 dark:text-black'
              : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'"
                        v-model="updateKanbanTaskForm.date_start"
                        locale="fr"
                        format="dd/MM/yyyy"
                        :disabled-week-days="[6, 0]"
                        :auto-apply="true"
                        :dark="isDark"
                    ></VueDatePicker>
                </div>
                <span v-if="updateKanbanTaskForm.errors.date_start" class="text-red-600">
            {{ updateKanbanTaskForm.errors.date_start }}
          </span>
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium"
                       :class="updateKanbanTaskForm.errors.date_end ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Date
                    de fin</label>
                <div class="flex relative">
                    <VueDatePicker
                        :input-class-name="updateKanbanTaskForm.errors.date_end
              ? 'rounded bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 dark:text-black'
              : 'rounded border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'"
                        v-model="updateKanbanTaskForm.date_end"
                        locale="fr"
                        format="dd/MM/yyyy"
                        :disabled-week-days="[6, 0]"
                        :auto-apply="true"
                        :dark="isDark"
                    ></VueDatePicker>
                </div>
                <span v-if="updateKanbanTaskForm.errors.date_end" class="text-red-600">
            {{ updateKanbanTaskForm.errors.date_end }}
          </span>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeTaskModal(true)">Annuler</SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': storeKanbanTaskForm.processing }"
                :disabled="storeKanbanTaskForm.processing"
                @click="storeKanbanTask(true)"
            >
                Enregistrer
            </PrimaryButton>
        </template>
    </DialogModal>
    <!--  Store new Task-->
    <DialogModal :isOverFlow="false" :show="createNewTask" @close="closeTaskModal(false)">
        <template #title>Créer une tâche</template>
        <template #content>
            <div>
                <label
                    class="block mb-2 text-sm font-medium "
                    :class="storeKanbanTaskForm.errors.name ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Nom</label>
                <div class="flex relative">
                    <input placeholder="Nom de la tâche"
                           v-model="storeKanbanTaskForm.name"
                           v-on:keyup.enter="storeKanbanTask()"
                           type="text"
                           :class="storeKanbanTaskForm.errors.name
                 ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 text-black'
                 : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'">
                </div>
                <span v-if="storeKanbanTaskForm.errors.name" class="text-red-600">
            {{ storeKanbanTaskForm.errors.name }}
          </span>
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium"
                       :class="storeKanbanTaskForm.errors.description ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Description</label>
                <div class="flex relative">
          <textarea
              :class="storeKanbanTaskForm.errors.description
                 ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 text-black'
                 : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'"
              v-model="storeKanbanTaskForm.description"
              v-on:keyup.enter="storeKanbanTask()"
              required
              placeholder="Description de la tâche"
          />
                </div>
                <span v-if="storeKanbanTaskForm.errors.description" class="text-red-600">
            {{ storeKanbanTaskForm.errors.description }}
          </span>
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium"
                       :class="storeKanbanTaskForm.errors.members ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Responsable(s)</label>
                <div class="flex relative">
                    <Multiselect
                        :classes="{
                            dropdown: 'max-h-60 multiselect-dropdown absolute -left-px -right-px bottom-0 transform translate-y-full -mt-px overflow-y-scroll z-50 dark:bg-gray-700 flex flex-col rounded-b',
                        }"
                        :class="storeKanbanTaskForm.errors.members
              ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full dark:bg-red-100 dark:border-red-400 text-black'
              : 'border w-full text-sm rounded border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500'"
                        v-model="storeKanbanTaskForm.members"
                        :options="members"
                        mode="tags"
                        :create-option="false"
                    ></Multiselect>
                </div>
                <span v-if="storeKanbanTaskForm.errors.members" class="text-red-600">
            {{ storeKanbanTaskForm.errors.members }}
          </span>
            </div>
            <div class="mt-2">
                <label
                    class="block mb-2 text-sm font-medium "
                    :class="storeKanbanTaskForm.errors.scheduled_time ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Temps
                    estimé (en heures)</label>
                <div class="flex relative">
                    <input placeholder="Temps estimé"
                           v-model="storeKanbanTaskForm.scheduled_time"
                           type="text"
                           :class="storeKanbanTaskForm.errors.scheduled_time
                 ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 text-black'
                 : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'">
                </div>
                <span v-if="storeKanbanTaskForm.errors.scheduled_time" class="text-red-600">
            {{ storeKanbanTaskForm.errors.scheduled_time }}
          </span>
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium"
                       :class="storeKanbanTaskForm.errors.date_start ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Date
                    de début</label>
                <div class="flex relative">
                    <VueDatePicker
                        :input-class-name="storeKanbanTaskForm.errors.date_start
              ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 dark:text-black'
              : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'"
                        v-model="storeKanbanTaskForm.date_start"
                        locale="fr"
                        format="dd/MM/yyyy"
                        :disabled-week-days="[6, 0]"
                        :auto-apply="true"
                        :dark="isDark"
                    ></VueDatePicker>
                </div>
                <span v-if="storeKanbanTaskForm.errors.date_start" class="text-red-600">
            {{ storeKanbanTaskForm.errors.date_start }}
          </span>
            </div>
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium"
                       :class="storeKanbanTaskForm.errors.date_end ? 'text-red-500' : 'text-gray-900 dark:text-gray-300'">Date
                    de fin</label>
                <div class="flex relative">
                    <VueDatePicker
                        :input-class-name="storeKanbanTaskForm.errors.date_end
              ? 'bg-red-50 border border-red-500 placeholder-red-400 text-sm rounded focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 dark:text-black'
              : 'border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5'"
                        v-model="storeKanbanTaskForm.date_end"
                        locale="fr"
                        format="dd/MM/yyyy"
                        :disabled-week-days="[6, 0]"
                        :auto-apply="true"
                        :dark="isDark"
                    ></VueDatePicker>
                </div>
                <span v-if="storeKanbanTaskForm.errors.date_end" class="text-red-600">
            {{ storeKanbanTaskForm.errors.date_end }}
          </span>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeTaskModal(false)">Annuler</SecondaryButton>
            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': storeKanbanTaskForm.processing }"
                :disabled="storeKanbanTaskForm.processing"
                @click="storeKanbanTask(false)"
            >
                Enregistrer
            </PrimaryButton>
        </template>
    </DialogModal>

    <div class="px-3 mt-3">
        <button @click="createNewKanbanTaskModal"
                class="flex items-center p-2 text-sm font-medium text-gray-600 dark:text-gray-200 hover:text-black hover:bg-gray-400 w-full rounded-md">
            <i-carbon-add class="h-5 w-5"></i-carbon-add>
            <span class="ml-1">Ajouter une tâche</span>
        </button>
    </div>
</template>
<style scoped>
.multiselect.is-active {
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
}

.button {
    margin-top: 35px;
}

.flip-list-move {
    transition: transform 0.5s;
}

.no-move {
    transition: transform 0s;
}

.ghost {
    opacity: 0.5;
    background: #ffc107;
}

.list-group {
    min-height: 20px;
}

.list-group-item {
    cursor: move;
}

.list-group-item i {
    cursor: pointer;
}
</style>
