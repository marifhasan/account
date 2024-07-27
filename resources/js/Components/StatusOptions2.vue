<template>
    <Listbox as="div" v-model="selected">
        <ListboxLabel class="sr-only"> Change published status </ListboxLabel>
        <div class="relative">
            <div class="inline-flex shadow-sm rounded-md divide-x divide-indigo-600">
                <div class="relative z-0 inline-flex shadow-sm rounded-md divide-x divide-indigo-600">
                    <div class="relative inline-flex items-center bg-indigo-500 py-2 pl-3 pr-4 border border-transparent rounded-l-md shadow-sm text-white">
                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                        <p class="ml-2.5 text-sm font-medium capitalize">{{ selected }}</p>
                    </div>
                    <ListboxButton class="relative inline-flex items-center bg-indigo-500 p-2 rounded-l-none rounded-r-md text-sm font-medium text-white hover:bg-indigo-600 focus:outline-none focus:z-10 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
                        <span class="sr-only">Change published status</span>
                        <ChevronDownIcon class="h-5 w-5 text-white" aria-hidden="true" />
                    </ListboxButton>
                </div>
            </div>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <ListboxOptions class="origin-top-right absolute z-10 right-0 bottom-10 mb-2 w-32 rounded-md shadow-lg overflow-hidden bg-white divide-y divide-gray-200 ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <ListboxOption as="template" v-for="(capital, small) in model.statuses" :key="small" :value="small" v-slot="{ active, selected }">
                        <li :class="[active ? 'text-white bg-indigo-500' : 'text-gray-900', 'cursor-pointer select-none relative px-4 py-2 text-sm']">
                            <div class="flex flex-col">
                                <div class="flex justify-between">
                                    <p :class="[selected ? 'font-semibold' : 'font-normal', 'capitalize']"> {{ small }} </p>
                                    <span v-if="selected" :class="active ? 'text-white' : 'text-indigo-500'">
                                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script>
import {
  Listbox,
  ListboxLabel,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'

import {
    CheckIcon,
    ChevronDownIcon
} from '@heroicons/vue/solid'

export default {
    components: {
        Listbox,
        ListboxButton,
        ListboxLabel,
        ListboxOption,
        ListboxOptions,
        CheckIcon,
        ChevronDownIcon,
    },

    props: [
        'model',
    ],

    setup(props) {
        const selected = props.model.status

        return {
            selected,
        }
    },
}
</script>
