<script setup lang="ts">
const features = [
    {
        icon: "group",
        name: "Équipes",
        description:
            "Gérer vos équipes facilement, inviter de nouveaux membres par mail, gérer leurs permissions et basculer entre vos équipes en un clic",
    },
    {
        icon: "idea",
        name: "Projets",
        description:
            "Initiez rapidement de nouveaux projets avec votre équipe, ajoutez ensuite des modules parmi ceux disponibles pour débloquer des fonctionnalités",
    },
    {
        icon: "chat",
        name: "Chats",
        description:
            "Envoyez des messages à vos collaborateurs par groupe de deux ou plus, recevez des notifications à la réception de messages et marquez les comme lus",
    },
    {
        icon: "document",
        name: "Notes",
        description:
            "Éditez des documents avec d'autres membres, voyez ceux qui sont connectés avec vous et envoyez/recevez les modifications en temps réel",
    },
    {
        icon: "timer",
        name: "Times",
        description:
            "Gardez une trace de vos temps de travail à travers tous vos projets, observez le temps passé et les tâches terminés de vos collaborateurs",
    },
    {
        icon: "data-table",
        name: "Kanban",
        description:
            "Suivez l'évolution de vos tâches et leur statut actuel, déplacez des cartes dans un tableau de type kanban pour les mettre à jour",
    },
];
</script>

<template>
    <HomeSection>
        <template #title>Fonctionnalités</template>
        <template #subtitle>
            Les différentes possibilités offertes par Dewire
        </template>
        <div
            class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0"
        >
            <div v-for="feature in features">
                <div
                    class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-slate-100 lg:h-12 lg:w-12 dark:bg-slate-900 dark:text-white"
                >
                    <template v-if="feature.icon === 'group'">
                        <i-carbon-group />
                    </template>
                    <template v-if="feature.icon === 'idea'">
                        <i-carbon-idea />
                    </template>
                    <template v-if="feature.icon === 'chat'">
                        <i-carbon-chat />
                    </template>
                    <template v-if="feature.icon === 'document'">
                        <i-carbon-document />
                    </template>
                    <template v-if="feature.icon === 'timer'">
                        <i-carbon-timer />
                    </template>
                    <template v-if="feature.icon === 'data-table'">
                        <i-carbon-data-table />
                    </template>
                </div>
                <h3 class="mb-2 text-xl font-bold dark:text-white">
                    {{ feature.name }}
                </h3>
                <p class="text-gray-500 dark:text-gray-400">
                    {{ feature.description }}
                </p>
            </div>
        </div>
    </HomeSection>
</template>
