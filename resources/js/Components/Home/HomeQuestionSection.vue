<script setup lang="ts">
const questions = [
    [
        {
            text: 'Comment est né le projet ?',
            answer: "Le projet Dewire a été initié lors de notre 2ème année de master web afin de proposer un projet innovant à présenter",
        },
        {
            text: 'Quelles sont les évolutions futures du projet ?',
            answer: "Ce projet va continuer de grandir en intégrant de plus en plus de fonctionnalités, de modules et d'améliorations d'interface",
        },
    ],
    [
        {
            text: 'Comment contribuer au projet ?',
            answer: "Pour nous aider, n'hésitez pas à nous envoyer des messages si vous rencontrez des problèmes ou si vous avez des idées d'évolution",
        },
        {
            text: "Quelles sont les technologies derrière le projet ?",
            answer: "L'application a été réalisé avec les frameworks Laravel et Vue ainsi que la librairie Inertia pour connecter les deux",
        },
    ],
];
</script>

<template>
    <HomeSection>
        <template #title>Foire aux questions</template>
        <template #subtitle>
            Des questions types à propos du projet Dewire
        </template>
        <div
            class="grid pt-8 text-left border-t border-gray-200 md:gap-16 dark:border-gray-700 md:grid-cols-2"
        >
            <div v-for="group in questions">
                <div v-for="question in group" class="mb-10">
                    <h3
                        class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white"
                    >
                        <i-carbon-help-filled class="mr-2" />
                        {{ question.text }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ question.answer }}
                    </p>
                </div>
            </div>
        </div>
    </HomeSection>
</template>
