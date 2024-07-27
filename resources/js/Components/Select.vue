<template>
    <div>
        <Listbox v-model="selectedItem">
            <div class="relative">
                <input v-if="createItem" type="text" :placeholder="'New ' + creatable" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">

                <div v-else>
                    <ListboxButton class="relative w-full py-2 pl-3 pr-10 text-left bg-white border border-gray-300 rounded hover:bg-gray-100 cursor-default focus:outline-none focus-visible:ring-2 focus-visible:ring-opacity-75 focus-visible:ring-white focus-visible:ring-offset-orange-300 focus-visible:ring-offset-2 focus-visible:border-indigo-500 sm:text-sm">
                        <span class="block truncate h-5">{{ (selectedItem?.name ?? selectedItem?.number) ?? 'Select Item' }}</span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <SelectorIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                        </span>
                    </ListboxButton>

                    <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <ListboxOptions class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm z-10">
                            <input v-if="searchable" v-model="search" @keyup="filter" type="text" placeholder="Type here ..." class="mb-1 block w-full rounded border-gray-300 py-2 px-3 pl-10 focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm">

                            <ListboxOption v-slot="{ active, selected }" v-for="item in itemList" :key="item.id" :value="item" as="template">
                                <li :class="[ active ? 'text-primary-900 bg-primary-100' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-10 pr-4', ]">
                                    <span :class="[ selected ? 'font-medium' : 'font-normal', 'block truncate', ]">{{ item.name }} <span v-if="item.number"> - {{ item.number }}</span> <span v-if="item.branch"> - {{ item.branch }}</span></span>
                                    <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3 text-primary-600">
                                        <CheckIcon class="w-5 h-5" aria-hidden="true" />
                                    </span>
                                </li>
                            </ListboxOption>
                            <ListboxOption v-slot="{ active, selected }" as="template" v-if="creatable">
                                <li @click="addNew" :class="[ active ? 'text-primary-900 bg-primary-100' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-10 pr-4', ]">
                                    <span :class="[ selected ? 'font-medium' : 'font-normal', 'block truncate', ]">Add {{ creatable }}</span>
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-primary-600">
                                        <PlusIcon class="w-5 h-5" aria-hidden="true" />
                                    </span>
                                </li>
                            </ListboxOption>
                        </ListboxOptions>
                    </transition>
                </div>
            </div>
        </Listbox>
    </div>
</template>

<script>
import { ref, watch } from 'vue'
import {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'


import {
    CheckIcon,
    PlusIcon,
    RefreshIcon,
    SelectorIcon,
} from '@heroicons/vue/solid'

export default {
    components: {
        Listbox,
        ListboxLabel,
        ListboxButton,
        ListboxOptions,
        ListboxOption,
        CheckIcon,
        PlusIcon,
        RefreshIcon,
        SelectorIcon,
    },

    emits: ['update:modelValue'],

    props: [
        'items',
        'modelValue',
        'creatable',
        'searchable'
    ],

    data(props) {
        return {
            search: '',
            itemList: props.items,
        }
    },

    methods: {
        addNew() {
            this.createItem = true;
        },

        filter() {
            let key = this.search.toLowerCase();
            this.itemList = this.items.filter(function (item) {
                // console.log(JSON.stringify(item));
                return item.name.toLowerCase().search(key) > -1
            });
        },
    },
    setup(props, { emit }) {
        const item = props.items.find(item => item.id == props.modelValue)

        const selectedItem = ref(item)
        const createItem = false;

        watch(selectedItem, function() {
            emit('update:modelValue', selectedItem.value.id)
        })

        return {
            selectedItem,
            createItem,
        }
    },
}
</script>
