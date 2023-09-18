<script setup lang="ts">
const members = [
    {
        image: "https://avatars.githubusercontent.com/u/77669819?v=4",
        firstName: "Mathieu",
        lastName: "NEYRET",
        role: "Développeur full-stack",
        description: "...",
        linkedin: "https://www.linkedin.com/in/mathieu-neyret-a638901a2",
        github: "https://github.com/mathieuneyret",
    },
    {
        image: "https://avatars.githubusercontent.com/u/71386173?v=4",
        firstName: "Anaël",
        lastName: "BONNAFOUS",
        role: "Développeur full-stack",
        description: "...",
        linkedin: "https://www.linkedin.com/in/anaelbonnafous",
        github: "https://github.com/AnaelBonnafous",
    },
    {
        image: "https://avatars.githubusercontent.com/u/27288985?v=4",
        firstName: "Logan",
        lastName: "LE SAUX",
        role: "Développeur full-stack",
        description: "...",
        linkedin: "https://www.linkedin.com/in/logan-le-saux-652492150",
        github: "https://github.com/LoganLS",
    },
    {
        image: "https://avatars.githubusercontent.com/u/48953932?v=4",
        firstName: "Théo",
        lastName: "NICOLAS",
        role: "Développeur full-stack",
        description: "...",
        linkedin: "https://www.linkedin.com/in/th%C3%A9o-nicolas-8ba0b7194",
        github: "https://github.com/OtterTheo",
    },
];
</script>

<template>
    <HomeSection>
        <template #title>Notre équipe</template>
        <template #subtitle>
            L'équipe de développeurs derrière Dewire
        </template>
        <div
            class="grid gap-8 lg:gap-16 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <div
                v-for="member in members"
                class="text-center text-gray-500 dark:text-gray-400"
            >
                <img
                    class="mx-auto mb-4 w-36 h-36 rounded-full"
                    :src="member.image"
                    :alt="member.firstName + ' ' + member.lastName"
                />
                <h3
                    class="mb-1 text-xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ member.firstName }} {{ member.lastName }}
                </h3>
                <p>{{ member.role }}</p>
                <ul class="flex justify-center mt-4 space-x-4">
                    <li>
                        <a
                            :href="member.linkedin"
                            target="_blank"
                            class="text-[#39569c] hover:text-gray-900 dark:hover:text-white"
                        >
                            <i-carbon-logo-linkedin class="h-6 w-6" />
                        </a>
                    </li>

                    <li>
                        <a
                            :href="member.github"
                            target="_blank"
                            class="text-gray-900 hover:text-gray-900 dark:hover:text-white dark:text-gray-300"
                        >
                            <i-carbon-logo-github class="h-6 w-6" />
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </HomeSection>
</template>
