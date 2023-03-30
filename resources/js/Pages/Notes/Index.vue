<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";

const { project } = defineProps<{
    project: any;
    notes: any[];
}>();

const form = useForm({
    name: "Note test",
    content: "Lorem ipsum",
});

const storeNote = () => {
    form.post(route("projects.notes.store", project));
};

const destroyNote = (note: any) => {
    router.delete(route("projects.notes.destroy", { project, note }));
};
</script>

<template>
    <AppLayout title="Notes">
        <div class="grid grid-cols-2 gap-10">
            <div class="flex flex-col gap-6">
                <div>
                    <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Titre</label
                    >
                    <input
                        v-model="form.name"
                        id="name"
                        type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Ma note..."
                        required
                    />
                </div>

                <div>
                    <label
                        for="content"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Contenu</label
                    >
                    <textarea
                        v-model="form.content"
                        id="content"
                        rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Lorem ipsum..."
                    ></textarea>
                </div>

                <button
                    @click="storeNote"
                    type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    Ajouter
                </button>
            </div>

            <div>
                <h2
                    class="mb-2 text-lg font-semibold text-gray-900 dark:text-white"
                >
                    Mes notes
                </h2>
                <ul
                    v-if="notes.length"
                    class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400"
                >
                    <li v-for="note in notes" class="flex justify-between">
                        <Link
                            :href="
                                route('projects.notes.show', { project, note })
                            "
                        >
                            {{ note.name }}
                        </Link>
                        <button
                            @click="destroyNote(note.id)"
                            class="text-red-500"
                        >
                            X
                        </button>
                    </li>
                </ul>
                <p v-else class="text-gray-900 dark:text-white">
                    Aucune note...
                </p>
            </div>
        </div>
    </AppLayout>
</template>
