<template>
    <div class="relative h-screen flex overflow-hidden bg-gray-100">
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
                </TransitionChild>

                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
                    <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-primary-700">
                        <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                            <div class="absolute top-0 right-0 -mr-12 pt-2">
                                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                                    <span class="sr-only">Close sidebar</span>
                                    <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </button>
                            </div>
                        </TransitionChild>
                        <Link :href="route('home')" class="flex-shrink-0 flex items-center px-4">
                            <img class="h-8 w-auto" src="" alt="logo" />
                        </Link>
                        <nav class="mt-5 flex-1 flex flex-col divide-y divide-primary-800 overflow-y-auto" aria-label="Sidebar">
                            <div v-for="(box, index) in navigation" :key="index" :class="{'mt-6 pt-6' : index > 0}">
                                <div class="px-2 space-y-1">
                                    <Menu as="div" v-slot="{ open }" class="ml-3 relative" v-for="(heading, key) in box" :key="key">
                                        <Link v-if="heading.items == null" :href="route(heading.route_name)" :class="[heading.current ? 'bg-primary-800 text-white' : 'text-primary-100 hover:text-white hover:bg-primary-600', 'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md']" aria-current="page">
                                            <component :is="heading.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-primary-200" aria-hidden="true" />
                                            {{ heading.name }}
                                        </Link>
                                        <div v-else>
                                            <MenuButton :class="[isMenuOpen(heading.items) ? 'bg-primary-800 text-white' : 'text-primary-100 hover:text-white hover:bg-primary-600', 'group flex items-start text-left w-full px-2 py-2 text-sm leading-6 font-medium rounded-md']">
                                                <component :is="heading.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-primary-200" aria-hidden="true" />
                                                <span class="flex-1">{{ heading.name }}</span>
                                                <ChevronDownIcon :class="[open || isMenuOpen(heading.items) ? 'rotate-0':'rotate-90', 'transform flex-shrink-0 ml-1 h-5 w-5']" aria-hidden="true" />
                                            </MenuButton>
                                            <transition
                                                enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95"
                                            >
                                                <MenuItems :static="isMenuOpen(heading.items)" class="py-1">
                                                    <MenuItem v-for="(item, sub_key) in heading.items" :key="sub_key">
                                                        <Link :href="route(item.route_name)" as="button" :class="[item.current ? 'bg-primary-800 text-white' : 'text-primary-100 hover:text-white hover:bg-primary-600', 'text-primary-100 hover:text-white hover:bg-primary-600  group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md']">
                                                            {{ item.name }}
                                                        </Link>
                                                    </MenuItem>
                                                </MenuItems>
                                            </transition>
                                        </div>
                                    </Menu>
                                </div>
                            </div>
                        </nav>
                    </div>
                </TransitionChild>

                <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64">
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex flex-col flex-grow bg-primary-700 pt-5 pb-4 overflow-y-auto">
                    <Link :href="route('home')" class="flex items-center flex-shrink-0 px-4">
                        <img class="h-8 w-auto" src="/img/logo.jpg" alt="logo" />
                    </Link>
                    <nav class="mt-5 flex-1 flex flex-col divide-y divide-primary-800 overflow-y-auto" aria-label="Sidebar">
                        <div v-for="(box, index) in navigation" :key="index" :class="{'mt-6 pt-6' : index > 0}">
                            <div class="px-2 space-y-1">
                                <Menu as="div" v-slot="{ open }" class="ml-3 relative" v-for="(heading, key) in box" :key="key">
                                    <Link v-if="heading.items == null" :href="route(heading.route_name)" :class="[heading.current ? 'bg-primary-800 text-white' : 'text-primary-100 hover:text-white hover:bg-primary-600', 'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md']" aria-current="page">
                                        <component :is="heading.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-primary-200" aria-hidden="true" />
                                        {{ heading.name }}
                                    </Link>
                                    <div v-else>
                                        <MenuButton :class="[isMenuOpen(heading.items) ? 'bg-primary-800 text-white' : 'text-primary-100 hover:text-white hover:bg-primary-600', 'group flex items-start text-left w-full px-2 py-2 text-sm leading-6 font-medium rounded-md']">
                                            <component :is="heading.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-primary-200" aria-hidden="true" />
                                            <span class="flex-1">{{ heading.name }}</span>
                                            <ChevronDownIcon :class="[open || isMenuOpen(heading.items) ? 'rotate-0':'rotate-90', 'transition duration-150 ease-out transform flex-shrink-0 ml-1 h-5 w-5']" aria-hidden="true" />
                                        </MenuButton>
                                        <transition
                                            enter-active-class="transition ease-out duration-100"
                                            enter-from-class="transform opacity-0 scale-95"
                                            enter-to-class="transform opacity-100 scale-100"
                                            leave-active-class="transition ease-in duration-75"
                                            leave-from-class="transform opacity-100 scale-100"
                                            leave-to-class="transform opacity-0 scale-95"
                                        >
                                            <MenuItems :static="isMenuOpen(heading.items)" class="py-1">
                                                <MenuItem v-for="(item, sub_key) in heading.items" :key="sub_key">
                                                    <Link :href="route(item.route_name)" as="button" :class="[item.current ? 'bg-primary-800 text-white' : 'text-primary-100 hover:text-white hover:bg-primary-600', 'group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md']">
                                                        {{ item.name }}
                                                    </Link>
                                                </MenuItem>
                                            </MenuItems>
                                        </transition>
                                    </div>
                                </Menu>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-auto focus:outline-none">
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:border-none">
                <button type="button" class="px-4 border-r border-gray-200 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <MenuAlt1Icon class="h-6 w-6" aria-hidden="true" />
                </button>
                <!-- Search bar -->
                <div class="flex-1 px-4 flex justify-between sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                    <div class="flex-1 flex">
                        <form class="w-full flex md:ml-0" action="#" method="GET">
                            <label for="search-field" class="sr-only">Search</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none" aria-hidden="true">
                                <SearchIcon class="h-5 w-5" aria-hidden="true" />
                                </div>
                                <input id="search-field" name="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm" placeholder="Search transactions" type="search" />
                            </div>
                        </form>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <button type="button" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>

                        <!-- Profile dropdown -->
                        <Menu as="div" class="ml-3 relative">
                            <div>
                                <MenuButton class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 lg:p-2 lg:rounded-md lg:hover:bg-gray-50">
                                    <img class="object-cover h-8 w-8 rounded-full" :src="$page.props.default.photo" alt="Photo path" />
                                    <span class="hidden ml-3 text-gray-700 text-sm font-medium lg:block"><span class="sr-only">Open user menu for </span>{{ $page.props.auth.user.name }}</span>
                                    <ChevronDownIcon class="hidden flex-shrink-0 ml-1 h-5 w-5 text-gray-400 lg:block" aria-hidden="true" />
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-slot="{ active }">
                                        <Link :href="route('profile.index')" as="button" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700 w-full text-left']">
                                            Your Account
                                        </Link>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <Link :href="route('profile.password')" as="button" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700 w-full text-left']">
                                            Change Password
                                        </Link>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <Link :href="route('logout')" method="post" as="button" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700 w-full text-left']">
                                            Logout
                                        </Link>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
            <main class="flex-1 relative pb-8 z-0 overflow-y-auto">
                <slot />
            </main>
        </div>
    </div>
</template>

<script>

import {
    Dialog,
    DialogOverlay,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'

import {
    AdjustmentsIcon,
    BadgeCheckIcon,
    BellIcon,
    ClockIcon,
    ColorSwatchIcon,
    CogIcon,
    CreditCardIcon,
    CubeIcon,
    CurrencyBangladeshiIcon,
    DocumentReportIcon,
    FilmIcon,
    HomeIcon,
    LibraryIcon,
    MenuAlt1Icon,
    QuestionMarkCircleIcon,
    ScaleIcon,
    ShieldCheckIcon,
    SpeakerphoneIcon,
    StarIcon,
    TemplateIcon,
    UsersIcon,
    UserGroupIcon,
    ViewGridIcon,
    XIcon,
} from '@heroicons/vue/outline'

import {
    CashIcon,
    CheckCircleIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    OfficeBuildingIcon,
    SearchIcon,
} from '@heroicons/vue/solid'

import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

export default {
    components: {
        Link,
        Dialog,
        DialogOverlay,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        TransitionChild,
        TransitionRoot,
        BadgeCheckIcon,
        BellIcon,
        CashIcon,
        CheckCircleIcon,
        ChevronDownIcon,
        ChevronRightIcon,
        ColorSwatchIcon,
        CubeIcon,
        CurrencyBangladeshiIcon,
        FilmIcon,
        HomeIcon,
        LibraryIcon,
        MenuAlt1Icon,
        OfficeBuildingIcon,
        SearchIcon,
        SpeakerphoneIcon,
        AdjustmentsIcon,
        StarIcon,
        TemplateIcon,
        ViewGridIcon,
        XIcon,
    },

    methods:{
        isMenuOpen(items) {
            const found = items.find(item => (item.current == true));
            // console.log(found);
            return found;
        },
    },

    props: {
        navigation: Array,
    },

    data() {
        return {
        }
    },

    setup () {
        const sidebarOpen = ref(false)

        return {
            sidebarOpen,
        }
    },
}
</script>
