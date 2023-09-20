<script setup lang="ts">
import draggable from "vuedraggable";
import route from "ziggy-js";
import axios from "axios";

const {project, kanban, lists} = defineProps<{
    project: App.Models.Project;
    kanban: Object;
    lists: any;
    members: any;
}>();

const storeKanbanListForm = useForm({
    name: "",
    kanban_id: kanban.id,
    position: "",
})
const indexListForm = useForm({
    list: lists,
})

const destroyKanbanListForm = useForm<{
    id?: number;
}>({
    id: undefined,
});
let enabled = true;
let dragging = false;
let deletingKanbanList = ref(false);
const storeKanbanList = () => {
    storeKanbanListForm
        .post(route('kanban_lists.store', {
            kanban: kanban,
            project: project
        }));
};
const openDestroyKanbanListModal = (id) => {
    destroyKanbanListForm.id = id
    deletingKanbanList.value = true;
};
const closeDestroyKanbanListModal = () => {
    destroyKanbanListForm.id = undefined
    deletingKanbanList.value = false;
};
const destroyKanbanList = () => {
    if (!destroyKanbanListForm.id) return;
    destroyKanbanListForm.delete(
        route("kanban_lists.destroy", {
            project: project,
            kanban_list: destroyKanbanListForm.id,
            kanban: kanban
        }), {onSuccess: closeDestroyKanbanListModal,}
    );
};
async function storePosition() {
    const response = await axios.post(
        route('kanban-lists-update-position', {
            project: project,
            kanban: kanban,
        }), {
            list: indexListForm.list,
        },
    )
}
const dragOptions = () => {
    return {
        animation: 200,
        group: "description",
        disabled: !enabled,
        ghostClass: "ghost",
    };
};
</script>

<template>
    <draggable
        :list="lists"
        :disabled="!enabled"
        item-key="id"
        ghost-class="ghost"
        v-bind="dragOptions"
        class="inline-flex h-full items-start space-x-4"
        @start="dragging = true"
        @end="dragging = false;"
        @change="storePosition"
    >
        <template #item="{ element, index }">
            <div class="w-80 bg-gray-200 dark:bg-gray-500 max-h-full flex flex-col rounded-md cursor-grab">
                <div :class="{ 'not-draggable': !enabled }">
                    <div class="flex items-center justify-between px-3 py-2">
                        <InputName :item="element" :project="project"></InputName>
                        <button @click="openDestroyKanbanListModal(element.id)"
                                class="hover:bg-gray-300 w-8 h-8 rounded-md grid place-content-center">
                            <i-carbon-close class="w-5 h-5"/>
                        </button>
                    </div>
                    <div class="pb-3 flex flex-col overflow-hidden">
                        <Tasks :project="project"
                               :kanban_list="element"
                               :kanban="kanban"
                               :members="members"
                        ></Tasks>
                    </div>
                </div>
            </div>
        </template>
    </draggable>
    <div class="w-72">
        <button @click="storeKanbanList"
                class="flex items-center bg-gray-200 hover:bg-gray-300 dark:bg-white/10 w-full dark:hover:bg-white/20 dark:text-white p-2 text-sm font-medium rounded-md">
            <i-carbon-add class="w-5 h-5"/>
            <span class="ml-1">Ajouter une liste</span>
        </button>
    </div>
    <ConfirmationModal :show="deletingKanbanList" @close="closeDestroyKanbanListModal">
        <template #title>Supprimer la liste</template>

        <template #content>
            Êtes-vous sûr de vouloir supprimer la liste "{{
                lists.find((kanbanList) => kanbanList.id === destroyKanbanListForm.id)?.name
            }}" ?
        </template>

        <template #footer>
            <SecondaryButton @click="closeDestroyKanbanListModal">
                Annuler
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': destroyKanbanListForm.processing }"
                :disabled="destroyKanbanListForm.processing"
                @click="destroyKanbanList()"
            >
                Supprimer la liste
            </DangerButton>
        </template>
    </ConfirmationModal>
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
.sortable-chosen {
  cursor: grabbing;
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
