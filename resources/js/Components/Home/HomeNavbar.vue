<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import route from "ziggy-js";
import {useDark} from "@vueuse/core";

const isDark = useDark();
</script>

<template>
    <header>
        <nav
            class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800"
        >
            <div
                class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl"
            >
                <a href="https://flowbite.com" class="flex items-center mr-40">
                    <img
                        src="/img/logo/logo_light.png"
                        class="h-6 sm:h-9 hidden dark:inline"
                        alt="Dewire Logo"
                    />
                    <img
                        src="/img/logo/logo_dark.png"
                        class="h-6 sm:h-9 inline dark:hidden"
                        alt="Dewire Logo"
                    />
                </a>
                <div class="flex items-center lg:order-2">
                    <div class="flex items-center mr-2">
                        <i-carbon-moon class="mr-2 text-white" v-if="isDark" />
                        <i-carbon-sun class="mr-2" v-else />
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input @click="isDark = !isDark" type="checkbox" value=""
                                   class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <template v-if="$page.props.auth.user">
                        <Link
                            :href="route('dashboard')"
                            class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-slate-600 dark:hover:bg-slate-700 focus:outline-none dark:focus:ring-slate-800"
                            >Dashboard</Link
                        >
                    </template>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800"
                            >Connexion</Link
                        >
                        <Link
                            :href="route('register')"
                            class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-slate-600 dark:hover:bg-slate-700 focus:outline-none dark:focus:ring-slate-800"
                            >Inscription</Link
                        >
                    </template>

                    <button
                        data-collapse-toggle="mobile-menu-2"
                        type="button"
                        class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="mobile-menu-2"
                        aria-expanded="false"
                    >
                        <span class="sr-only">Ouvrir le menu</span>
                        <svg
                            class="w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <svg
                            class="hidden w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                </div>
                <div
                    class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1"
                    id="mobile-menu-2"
                >
                    <ul
                        class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0"
                    >
                        <li>
                            <a
                                href="#"
                                class="block py-2 pr-4 pl-3 text-white rounded bg-slate-700 lg:bg-transparent lg:text-slate-700 lg:p-0 dark:text-white"
                                aria-current="page"
                                >Accueil</a
                            >
                        </li>
                        <li>
                            <a
                                href="#feature"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-slate-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                                >Fonctionnalités</a
                            >
                        </li>
                        <!-- <li>
                            <a
                                href="#pricing"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-slate-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                                >Tarifs</a
                            >
                        </li> -->
                        <li>
                            <a
                                href="#question"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-slate-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                                >Questions</a
                            >
                        </li>
                        <li>
                            <a
                                href="#team"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-slate-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                                >Membres</a
                            >
                        </li>
                        <!-- <li>
                            <a
                                href="#contact"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-slate-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                                >Contact</a
                            >
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>
