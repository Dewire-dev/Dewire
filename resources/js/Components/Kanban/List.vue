<script lang="ts">
import draggable from "vuedraggable";
import route from "ziggy-js";
import {Input} from "flowbite-vue";

export default {
  order: 0,
  name: "ListKanban",
  components: {
    Input,
    draggable
  },
  props: {
    kanban: Object,
    project: Object,
    lists: Object,
  },
  data() {
    return {
      enabled: true,
      dragging: false,
      deletingKanbanList: ref(false),
      updateName: false,
      id: 1,
      storeKanbanListForm: this.$inertia.form({
        name: "",
        kanban_id: this.kanban.id,
      }),
      destroyKanbanListForm: this.$inertia.form({
        id: undefined,
      }),
    };
  },


  methods: {
    add: function () {
      this.lists?.push({name: "Juan " + this.id, id: this.id++});
    },
    replace: function () {
      this.lists = [{name: "Edgard", id: this.id++}];
    },
    checkMove: function (e) {
      console.log("Future index: " + e.draggedContext.futureIndex);
    },
    storeKanban: function () {
      this.storeKanbanListForm.post(route('kanban_lists.store', {kanban: this.kanban, project: this.project}));
    },
    openDestroyKanbanListModal: function (id) {
      this.destroyKanbanListForm.id = id
      this.deletingKanbanList = true;
    },
    closeDestroyKanbanListModal: function () {
      this.destroyKanbanListForm.id = undefined;
      this.deletingKanbanList = false;

    },
    destroyKanbanList: function () {
      if (!this.destroyKanbanListForm.id) return;
      this.destroyKanbanListForm.delete(
          route("kanban_lists.destroy", {project: this.project, kanban_list: this.destroyKanbanListForm.id, kanban: this.kanban}),
          {
            onSuccess: this.closeDestroyKanbanListModal,
          }
      );
    },
  }
};
</script>

<template>
  <div
      v-for="item in lists"
      class="w-72 bg-gray-200 max-h-full flex flex-col rounded-md">
    <div class="flex items-center justify-between px-3 py-2">
      <Input
          v-if="updateName"
          v-model="item.name"
          required
          placeholder="Nom de la liste"
      />
      <h3 @click="updateName = true" v-else class="cursor-pointer text-sm font-semibold text-gray-700">{{ item.name }}a</h3>
      <button @click="openDestroyKanbanListModal(item.id)"
              class="hover:bg-gray-300 w-8 h-8 rounded-md grid place-content-center">
        <i-carbon-close class="w-5 h-5"/>
      </button>
    </div>
    <div class="pb-3 flex flex-col overflow-hidden">
      <div class="px-3 flex-1 overflow-y-auto">
        <ul class="space-y-3">
          <draggable
              :list="list"
              :disabled="!enabled"
              item-key="name"
              class="list-group"
              ghost-class="ghost"
              :move="checkMove"
              @start="dragging = true"
              @end="dragging = false"
          >
            <template #item="{ element }">
              <div class="list-group-item" :class="{ 'not-draggable': !enabled }">
                {{ element.name }}
              </div>
            </template>
          </draggable>

          <li class="group relative bg-white p-3 shadow rounded-md border-b border-gray-300 hover:bg-gray-50">
            <a href="#" class="text-sm">card item</a>
            <button
                class="hidden absolute top-1 right-1 w-8 h-8 bg-gray-50 group-hover:grid place-content-center rounded-md text-gray-600 hover:text-black hover:bg-gray-200">
              <i-carbon-close class="w-5 h-5"/>
            </button>
          </li>
        </ul>
      </div>

      <div class="px-3 mt-3">
        <button
            class="flex items-center p-2 text-sm font-medium text-gray-600 hover:text-black hover:bg-gray-300 w-full rounded-md">
          <i-carbon-add class="h-5 w-5"></i-carbon-add>
          <span class="ml-1">Add card</span>
        </button>
      </div>
    </div>
  </div>
  <div class="w-72">
    <button @click="storeKanban"
            class="flex items-center bg-white/10 w-full hover:bg-white/20 text-white p-2 text-sm font-medium rounded-md">
      <i-carbon-add class="w-5 h-5"/>
      <span class="ml-1">Add another list</span>
    </button>
  </div>
  <ConfirmationModal :show="deletingKanbanList" @close="closeDestroyKanbanListModal">
    <template #title>Supprimer le tableau Kanban</template>

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
