<template>
    <Menu as="div" class="relative inline-block">
        <div>
            <MenuButton :class="[statusStyles[model.status], as == 'button' ? 'shadow-sm text-sm px-4 py-2 focus:ring-2 focus:ring-offset-2': 'text-sm px-2 py-1 focus:ring-1 focus:ring-offset-1', 'capitalize inline-flex justify-center w-full rounded-md border font-medium focus:outline-none']">
                {{ model.status }}
                <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
            </MenuButton>
        </div>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white z-10 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                <div class="py-1">
                    <MenuItem v-for="(title, name) in model.statuses" :key="name">
                        <Link :href="href+ '/' + name" method="patch" v-show="name != model.status" class="capitalize text-gray-700 group flex items-center w-full px-4 py-2 text-sm hover:bg-gray-100">
                            {{ name }}
                        </Link>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue'

import {
    ChevronDownIcon,
} from '@heroicons/vue/solid'

export default {
    components: {
        Link,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        ChevronDownIcon,
    },

    props: ['as', 'model', 'href', 'description'],

    setup() {

        const statusStyles = {
            inactive: 'text-white bg-gray-500 border-gray-500 hover:bg-gray-600 focus:ring-gray-400',
            draft: 'text-white bg-gray-500 border-gray-500 hover:bg-gray-600 focus:ring-gray-400',
            pending: 'text-white bg-yellow-500 border-yellow-500 hover:bg-yellow-600 focus:ring-yellow-400',
            ready: 'text-white bg-primary-500 border-primary-500 hover:bg-primary-600 focus:ring-primary-400',
            active: 'text-white bg-green-500 border-green-500 hover:bg-green-600 focus:ring-green-400',
            received: 'text-white bg-primary-500 border-primary-500 hover:bg-primary-600 focus:ring-primary-400',
            sent: 'text-white bg-red-500 border-red-500 hover:bg-red-600 focus:ring-red-400',
            approved: 'text-white bg-green-500 border-green-500 hover:bg-green-600 focus:ring-green-400',
        };
        return {
            statusStyles,
        }
    },
}
</script>
