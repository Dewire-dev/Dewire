<script setup lang="ts">
import route from "ziggy-js";

const { project, note } = defineProps<{
    project: any;
    note: any;
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

const content = useDebouncedRef(JSON.parse(note.content), 1000);

const roomUsers = ref<object[]>([]);

const channel = Echo.join(`note.${note.id}`)
    .here((users: object[]) => {
        roomUsers.value = users;
    })
    .joining((user: object) => {
        roomUsers.value.push(user);
    })
    .leaving((user: object) => {
        roomUsers.value = roomUsers.value.filter(({ id }) => id !== user.id);
    })
    .listenForWhisper("editing", (e) => {
        content.value = e.content;
    });

onUnmounted(() => {
    Echo.leave(`note.${note.id}`);
});

const editingNote = () => {
    setTimeout(() => {
        channel.whisper("editing", {
            content: content.value,
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
    // TODO Anaël : empêcher le scroll au sommet de la page à chaque modification
    <AppLayout :title="note.name">
        <template #header>
            <BreadCrumb :breadcrumb="breadcrumb" />
            <div class="">
                <h2
                    class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center"
                >
                    {{ note.name }}
                </h2>
            </div>
        </template>

        <EditorRoomUsers :users="roomUsers" class="my-4" />

        <NoteEditor v-model="content" @update:modelValue="editingNote" />
    </AppLayout>
</template>
