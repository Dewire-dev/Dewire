<script setup>
import {ref} from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';

const isDark = useDark();
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {useDark} from "@vueuse/core";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title"/>

        <Banner/>

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav
                class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="px-3 py-3 lg:px-5 lg:pl-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-start">
                            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                                    aria-controls="logo-sidebar" type="button"
                                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                                <span class="sr-only">Open sidebar</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                          d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                                </svg>
                            </button>
                            <Link :href="route('dashboard')">
                                <ApplicationMark class="block h-9 w-auto"/>
                            </Link>
                        </div>
                        <div class="flex items-center">
                            <div class="flex items-center ml-3">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center">
                                        <i :class="isDark ? 'pi pi-sun text-white' : 'pi pi-moon'" class="mr-2"></i>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input @click="isDark = !isDark" type="checkbox" value=""
                                                   class="sr-only peer">
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                    <button type="button"
                                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="w-8 h-8 rounded-full"
                                             src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                             alt="user photo">
                                    </button>
                                </div>
                                <div
                                    class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                                    id="dropdown-user">
                                    <div class="px-4 py-3" role="none">
                                        <p class="text-sm text-gray-900 dark:text-white" role="none">
                                            Neil Sims
                                        </p>
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                                           role="none">
                                            neil.sims@flowbite.com
                                        </p>
                                    </div>
                                    <ul class="py-1" role="none">
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                               role="menuitem">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                               role="menuitem">Settings</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                               role="menuitem">Earnings</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                               role="menuitem">Sign out</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <aside id="logo-sidebar"
                   class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
                   aria-label="Sidebar">
                <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
                    <ul class="space-y-2 font-medium">
                        <li>
                            <a :class="route('dashboard') ? 'dark:nav-item-active nav-item-active' : ''" :href="route('dashboard')"
                               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg
                                    class="icon-home flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    id="Calque_2" data-name="Calque 2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 22.04 18.91">
                                    <path id="Tracé_15" data-name="Tracé 15"
                                          d="M228-47.9,218-56.14a.94.94,0,0,0-1.33,0l0,0-2.38,2s-.07.1-.15.06V-55c0-.43-.15-.58-.58-.58h-2.2c-.48,0-.63.15-.63.62v3.55a.32.32,0,0,1-.14.29l-2.83,2.32a12,12,0,0,0-1.43,1.22v.3c.31.36.48.37.87.06l1.9-1.56s.07-.1.15-.06V-38a.42.42,0,0,0,.38.47h5v0h5.35v0H225a.41.41,0,0,0,.36-.37,2.17,2.17,0,0,0,0-.26v-10.5a.37.37,0,0,1,0-.23l.86.7,1.29,1.05a.42.42,0,0,0,.61,0,.37.37,0,0,0,.12-.2C228.33-47.61,228.19-47.76,228-47.9ZM211.7-54.74c.45,0,.89,0,1.33,0,.12,0,.17,0,.16.15,0,.37,0,.74,0,1.11a.23.23,0,0,1-.1.22L211.54-52v-2.57c0-.13,0-.18.16-.18Zm7.46,16.33h-3.78v-4.91a.58.58,0,0,1,.58-.58h2.62a.58.58,0,0,1,.58.58Zm5.13,0H220v-4.91a1.36,1.36,0,0,0-1.37-1.36H216a1.36,1.36,0,0,0-1.37,1.36v4.92h-4.34c-.18,0-.22,0-.22-.22,0-3.61,0-7.21,0-10.82a.39.39,0,0,1,.15-.33l6.62-5.4a.62.62,0,0,1,.89,0l.05,0,6.6,5.39a.39.39,0,0,1,.16.34v10.82c0,.19,0,.22-.22.22Z"
                                          transform="translate(-206.25 56.42)"/>
                                </svg>
                                <span class="ml-3">Accueil</span>
                            </a>
                        </li>
                        <li>
                            <a :class="route('dashboard') ? 'dark:nav-item-active nav-item-active' : ''" href="#"
                               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="icon-projects flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" id="Calque_2" data-name="Calque 2" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 17.79 34.56">
                                    <g id="Composant_2_1" data-name="Composant 2 1">
                                        <path id="Tracé_47" data-name="Tracé 47" class="cls-1"
                                              d="M163.88-44H158a.45.45,0,0,1-.44-.45.5.5,0,0,1,0-.12l4.48-15.63a.45.45,0,0,0-.3-.56.44.44,0,0,0-.46.13L147.65-44.73a.46.46,0,0,0,0,.64A.44.44,0,0,0,148-44h5.87a.46.46,0,0,1,.44.46.5.5,0,0,1,0,.12L149.8-27.77a.44.44,0,0,0,.3.55.42.42,0,0,0,.46-.13l13.66-15.88a.46.46,0,0,0-.05-.64A.49.49,0,0,0,163.88-44Z"
                                              transform="translate(-147.04 61.26)"/>
                                    </g>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Mes projets</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg aria-hidden="true"
                                     class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                     fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path>
                                    <path
                                        d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Mon compte</span>
                                <span
                                    class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span>
                            </a>
                        </li>
                        <li>
                            <form @submit.prevent="logout">
                                <button
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <svg aria-hidden="true"
                                         class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Déconnexion</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <div class="p-4 sm:ml-64">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
                    <!-- Page Content -->
                    <main>
                        <slot/>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
