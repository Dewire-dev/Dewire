<script setup lang="ts">
import draggable from "vuedraggable";
import {Input} from "flowbite-vue";
import route from "ziggy-js";
import axios from "axios";


const {project, kanban_list, kanban} = defineProps<{
    project: App.Models.Project;
    kanban_list: Object;
    kanban: Object;
    members: any;
}>();

const storeKanbanTaskForm = useForm({
    item: {
        name: "",
        description: "",
        kanban_list_id: kanban_list.id,
    },
})
const updateKanbanTaskForm = useForm({
    item: "",
})

let enabled = true;
let dragging = false;
let position = 1;
const addingTask = ref(false);
const createNewTask = ref(false);
const tasks = ref(kanban_list.tasks)
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
                kanban_task: updateKanbanTaskForm.item,
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
        storeKanbanTaskForm
            .post(route('kanban_tasks.store', {
                project: project,
                kanban: kanban,
            }), {
                onSuccess: () => {
                    return Promise.all([
                        storeKanbanTaskForm.item.name = "",
                        storeKanbanTaskForm.item.description = "",
                        closeTaskModal()
                    ])
                }
            });
    }
};

const closeTaskModal = (isUpdate = false) => {
    isUpdate
        ? addingTask.value = false
        : createNewTask.value = false;
};
const updateKanbanTaskModal = (element) => {
    updateKanbanTaskForm.item = element;
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

    console.log(e);

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
            <li :class="{ 'not-draggable': !enabled }"
                class="group relative bg-white p-3 shadow rounded-md border-b border-gray-300 hover:bg-gray-50 cursor-pointer">
                <button
                    @click="destroyKanbanTask(element)"
                    class="hidden absolute top-1 right-1 w-8 h-8 bg-gray-50 group-hover:grid place-content-center rounded-md text-gray-600 hover:text-black hover:bg-gray-200">
                    <i-carbon-close class="w-5 h-5"/>
                </button>
                <div @click="updateKanbanTaskModal(element)">
                    {{ element.name }}
                </div>
            </li>
        </template>
    </draggable>
    <!--  Update Task-->
    <DialogModal :show="addingTask" @close="closeTaskModal(true)">
        <template #title>Modifier la tâche</template>

        <template #content>
            <Input
                v-model="updateKanbanTaskForm.item.name"
                required
                label="Nom"
                placeholder="Nom de la tâche"
                v-on:keyup.enter="storeKanbanTask(true)"
            />
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Description</label>

                <div class="flex relative">
          <textarea
              v-on:keyup.enter="storeKanbanTask(true)"
              class="border p-2.5 w-full text-sm bg-gray-50 rounded-lg
            border-gray-200 focus:ring-blue-500
            focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
            dark:placeholder-gray-400 dark:text-white
            dark:focus:ring-blue-500 dark:focus:border-blue-500"
              v-model="updateKanbanTaskForm.item.description"
              required
              placeholder="Description de la tâche"
          />
                </div>
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
    <DialogModal :show="createNewTask" @close="closeTaskModal(false)">
        <template #title>Créer une tâche</template>

        <template #content>
            <Input
                v-model="storeKanbanTaskForm.item.name"
                v-on:keyup.enter="storeKanbanTask()"
                required
                label="Nom"
                placeholder="Nom de la tâche"
            />
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Description</label>

                <div class="flex relative">
          <textarea
              class="border p-2.5 w-full text-sm bg-gray-50 rounded-lg
            border-gray-200 focus:ring-blue-500
            focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
            dark:placeholder-gray-400 dark:text-white
            dark:focus:ring-blue-500 dark:focus:border-blue-500"
              v-model="storeKanbanTaskForm.item.description"
              v-on:keyup.enter="storeKanbanTask()"
              required
              placeholder="Description de la tâche"
          />
                </div>
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
                class="flex items-center p-2 text-sm font-medium text-gray-600 hover:text-black hover:bg-gray-300 w-full rounded-md">
            <i-carbon-add class="h-5 w-5"></i-carbon-add>
            <span class="ml-1">Ajouter une tâche</span>
        </button>
    </div>
</template>
<style scoped>
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
