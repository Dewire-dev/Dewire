<script setup lang="ts">
import route from "ziggy-js";

const { project, note } = defineProps<{
    project: App.Models.Project;
    note: App.Models.Note;
}>();

const breadcrumb = [
    {
        label: "Mes projets",
        route: route("projects.index"),
    },
    {
        label: project.title,
        route: route("projects.show", { project }),
    },
    {
        label: "Notes",
        route: route("projects.notes.index", { project }),
    },
    {
        label: note.name,
        route: route("projects.notes.show", { project, note }),
    },
];

const content = useDebouncedRef(note.content, 1000);

const roomUsers = ref<Array<App.Models.User>>([]);

const channel = Echo.join(`note.${note.id}`)
    .here((users: Array<App.Models.User>) => {
        roomUsers.value = users;
    })
    .joining((user: App.Models.User) => {
        roomUsers.value.push(user);
    })
    .leaving((user: App.Models.User) => {
        roomUsers.value = roomUsers.value.filter(({ id }) => id !== user.id);
    })
    .listenForWhisper("editing", (e: any) => {
        console.log("e");
        console.log(e);

        content.value = e.content;
    });

onUnmounted(() => {
    Echo.leave(`note.${note.id}`);
});

const editingNote = (html?: string) => {
    if (!html) return;
    setTimeout(() => {
        channel.whisper("editing", {
            content: html,
        });
    }, 1000);
};

watch(content, (value) => {
    // TODO Anaël : optimiser la sauvegarde pour ne pas envoyer une requête par utilisateur
    router.patch(route("notes.save", { project, note }), {
        content: value,
    });
});
</script>

<template>
    <!-- TODO Anaël : empêcher le scroll au sommet de la page à chaque modification -->
    <AppLayout :title="note.name">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
            <div class="">
                <h2
                    class="text-xl font-semibold text-center text-gray-800 dark:text-gray-200"
                >
                    {{ note.name }}
                </h2>
            </div>
        </template>

        <EditorRoomUsers :users="roomUsers" class="my-4" />

        <NoteEditor v-model="content" @update:modelValue="editingNote" />
    </AppLayout>
</template>
