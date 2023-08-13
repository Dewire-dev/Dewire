<script setup lang="ts">
import {Head, Link, router} from '@inertiajs/vue3';
import route from 'ziggy-js';
import {useDark} from "@vueuse/core";
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';

const isDark = useDark();

defineProps({
    title: String,
});

const projects = computed(() => usePage().props.layout?.projects)

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};

const collapseToggle = (event) => {
    var element = document.getElementById(event.currentTarget.dataset.target);
    if(element.classList.contains('hidden')) {
        element.classList.remove('hidden');
    } else {
        element.classList.add('hidden');
    }
}
</script>

<template>
    <div>
        <Head :title="title"/>

        <Banner/>

        <div class="min-h-screen bg-gray-100 dark:bg-body">
            <nav
                class="fixed top-0 z-50 w-full border-b border-gray-200 dark:bg-sidebar bg-white dark:border-white-018">
                <div class="px-3 py-3 lg:px-5 lg:pl-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-start">
                            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                                    aria-controls="logo-sidebar" type="button"
                                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                                <span class="sr-only">Ouvrir le menu</span>
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
                                    <div class="ml-3 relative">
                                        <TeamSwitcher />
                                    </div>
                                    <button type="button"
                                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
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
                                            {{ $page.props.auth.user.firstname }} {{ $page.props.auth.user.lastname }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                                           role="none">
                                            {{ $page.props.auth.user.email }}
                                        </p>
                                    </div>
                                    <ul class="py-1" role="none">
                                        <li>
                                            <Link :href="route('profile.show')"
                                                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                                  role="menuitem">Profil
                                            </Link>
                                        </li>
                                        <li v-if="$page.props.jetstream.hasApiFeatures">
                                            <Link :href="route('api-tokens.index')"
                                                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                                  role="menuitem">API Tokens
                                            </Link>
                                        </li>
                                        <li>
                                            <form @submit.prevent="logout">
                                                <button
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                                    role="menuitem">Déconnexion
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <aside id="logo-sidebar"
                   class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-sidebar dark:border-white-018"
                   aria-label="Sidebar">
                <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-sidebar">
                    <ul class="space-y-2 font-medium">
                        <li>
                            <Link :class="route().current('dashboard') ? 'dark:nav-item-active nav-item-active' : ''"
                                  :href="route('dashboard')"
                                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 tab-projects">
                                <i-carbon-home
                                    class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i-carbon-home>
                                <span class="flex-1 ml-3 whitespace-nowrap">Accueil</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :class="route().current('projects.index') ? 'dark:nav-item-active nav-item-active' : ''"
                                :href="route('projects.index')"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 tab-projects">
                                <svg
                                    class="icon-projects flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    id="Calque_2" data-name="Calque 2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 17.79 34.56">
                                    <g id="Composant_2_1" data-name="Composant 2 1">
                                        <path id="Tracé_47" data-name="Tracé 47" class="cls-1"
                                              d="M163.88-44H158a.45.45,0,0,1-.44-.45.5.5,0,0,1,0-.12l4.48-15.63a.45.45,0,0,0-.3-.56.44.44,0,0,0-.46.13L147.65-44.73a.46.46,0,0,0,0,.64A.44.44,0,0,0,148-44h5.87a.46.46,0,0,1,.44.46.5.5,0,0,1,0,.12L149.8-27.77a.44.44,0,0,0,.3.55.42.42,0,0,0,.46-.13l13.66-15.88a.46.46,0,0,0-.05-.64A.49.49,0,0,0,163.88-44Z"
                                              transform="translate(-147.04 61.26)"/>
                                    </g>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Mes projets</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                :class="route().current('profile.show') ? 'dark:nav-item-active nav-item-active' : ''"
                                :href="route('profile.show')"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i-carbon-user
                                    class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    fill="currentColor"></i-carbon-user>
                                <span class="flex-1 ml-3 whitespace-nowrap">Mon compte</span>
                            </Link>
                        </li>
                        <li>
                            <form @submit.prevent="logout">
                                <button type="submit"
                                        class="w-100 flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i-carbon-logout
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                        fill="currentColor"></i-carbon-logout>
                                    <span class="flex-1 ml-3 whitespace-nowrap text-left">Déconnexion</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                    <hr class="h-px my-8 bg-gray-200 border-0 dark:border-white-018">
                    <ul class="space-y-2 font-medium mt-5">
                        <li v-for="(project,index) in projects">
                            <div
                                :class="route().current('projects.show', { project }) ? 'dark:nav-item-active nav-item-active' : ''"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 tab-projects">
                                <Link class="flex" :href="route('projects.show', { project })">
                                    <i-carbon-circle-solid :style='"color:" + project.color +";"'
                                                           class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i-carbon-circle-solid>
                                    <span class="flex-1 ml-3 whitespace-nowrap">{{ project.title }}</span>
                                </Link>
                                <button @click="collapseToggle($event)" :data-target="'collapse-'+index">
                                    <i-carbon-chevron-down
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i-carbon-chevron-down>
                                </button>
                            </div>
                            <ul class="hidden p-5" :id="'collapse-'+index" data-te-collapse-item>
                                <li v-for="module in project.modules">
                                    <span class="text-gray-900 dark:text-white">{{ module.name }}</span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow dark:bg-body">
                <div class="sm:ml-64 py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <div class="p-4 sm:ml-64 dark:bg-body">
                <div class="p-4">
                    <!-- Page Content -->
                    <main>
                        <slot/>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.dark .dark\:bg-sidebar {
    background-color: #2E2E30;
}

.dark .dark\:nav-item-active {
    --tw-bg-opacity: 0.18;
    background-color: rgb(255 255 255 / var(--tw-bg-opacity));
}

.nav-item-active {
    --tw-bg-opacity: 1;
    background-color: rgb(243 244 246 / var(--tw-bg-opacity));
}

.toggler-theme.pi {
    position: absolute;
    right: 20px;
    bottom: 20px;
    font-size: 30px;
}

.icon-projects path {
    fill: none;
    stroke: currentColor;
    stroke-miterlimit: 10;
}

.tab-projects:hover .icon-projects path {
    stroke: #FFC107;
    fill: #FFC107;
}

.nav-item-active.tab-projects .icon-projects path {
    stroke: #FFC107;
    fill: #FFC107;
}

header {
    margin-top: 3.8rem;
}
</style>
