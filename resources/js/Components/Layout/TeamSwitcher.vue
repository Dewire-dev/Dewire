<script setup lang="ts">
import route from "ziggy-js";

const switchToTeam = (team: App.Models.Team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};
</script>

<template>
    <Dropdown
        v-if="$page.props.jetstream.hasTeamFeatures"
        align="right"
        width="60"
    >
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                >
                    {{ $page.props.auth.user.current_team?.name }}

                    <svg
                        class="ml-2 -mr-0.5 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                        />
                    </svg>
                </button>
            </span>
        </template>

        <template #content>
            <div class="w-60">
                <!-- Team Management -->
                <template v-if="$page.props.jetstream.hasTeamFeatures">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Gestion d'équipe
                    </div>

                    <!-- Team Settings -->
                    <DropdownLink
                        v-if="$page.props.auth.user.current_team"
                        :href="
                            route(
                                'teams.show',
                                $page.props.auth.user.current_team
                            )
                        "
                    >
                        Paramètres de l'équipe
                    </DropdownLink>

                    <DropdownLink
                        v-if="$page.props.jetstream.canCreateTeams"
                        :href="route('teams.create')"
                    >
                        Créer une nouvelle équipe
                    </DropdownLink>

                    <div
                        class="border-t border-gray-200 dark:border-gray-600"
                    />

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Mes équipes
                    </div>

                    <template
                        v-for="team in $page.props.auth.user.all_teams"
                        :key="team.id"
                    >
                        <form @submit.prevent="switchToTeam(team)">
                            <DropdownLink as="button">
                                <div class="flex items-center">
                                    <svg
                                        v-if="
                                            team.id ==
                                            $page.props.auth.user
                                                .current_team_id
                                        "
                                        class="mr-2 h-5 w-5 text-green-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>

                                    <div>{{ team.name }}</div>
                                </div>
                            </DropdownLink>
                        </form>
                    </template>
                </template>
            </div>
        </template>
    </Dropdown>
</template>
