<script>
import route from "ziggy-js";

export default {
    props: {
        project: Object,
        kanban: Object,
        lists: Object,
        members: Object,
    },
    data() {
        return {
            breadcrumb: [
                {
                    label: "Mes projets",
                    route: route("projects.index"),
                },
                {
                    label: this.project.title,
                    route: route("projects.show", this.project),
                },
                {
                    label: "Tableaux Kanban",
                    route: route("kanbans.index", this.project),
                },
                {
                    label: this.kanban.name,
                    route: route("kanbans.show", {project: this.project, kanban: this.kanban}),
                },
            ],
        };
    },
    methods: {

    }
};
</script>

<template>
    <AppLayout :title="kanban.name">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb"/>
            <div class="">
                <h2
                    class="text-xl font-semibold text-center text-gray-800 dark:text-gray-200"
                >
                    {{ kanban.name }}
                </h2>
            </div>
        </template>

        <div class="flex flex-col h-screen">

            <div class="flex flex-col h-full">
                <div class="shrink-0 flex justify-between items-center p-4">
                    <h1 class="text-2xl text-white font-bold">Board title</h1>
                    <div>
                        <button
                            class="inline-flex items-center bg-white/10 hover:bg-white/20 px-3 py-2 font-medium text-sm text-white rounded-md">
                            <BeakerIcon class="w-5 h-5"/>
                            <span class="ml-1">Settings</span>
                        </button>
                    </div>
                </div>
                <div class="flex-1 overflow-x-auto">
                    <div class="inline-flex h-full items-start px-4 pb-4 space-x-4">
                        <List :lists="lists"
                              :kanban="kanban"
                              :project="project"
                              :members="members"
                        ></List>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style scoped>
.buttons {
    margin-top: 35px;
}

.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}

.not-draggable {
    cursor: no-drop;
}
</style>
