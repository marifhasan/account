<template>
    <Head title="Role Permission" />

    <AppLayout :navigation="navigation">
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="flex justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
                        <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">{{ role.name }}'s User Role Permission</p>

                        <div class="flex gap-4">
                            <button type="submit" @click="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600">
                                <PencilAltIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Update
                            </button>

                            <div class="flex items-center">
                                <label :for="`permissions`" class="mr-3 block select-none cursor-pointer">All</label>
                                <input :id="`permissions`" ref="all" type="checkbox" class="all-checkbox form-checkbox w-5 h-5 focus:ring-primary-600 focus:border-primary-600 text-primary-600 rounded transition duration-150 ease-in-out cursor-pointer" v-on:change="checkAll(event)">
                            </div>
                        </div>
                    </div>

                    <Alert :message="alertMessage" :errors="errors" />

                    <form @submit.prevent="submit">

                        <dl class="py-6 px-6">
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div v-for="(options, name) in items" :key="name" class="group px-4 py-4">
                                    <dt class="px-4 my-3 text-lg leading-10 font-medium text-gray-700 border-b border-indigo-500">
                                        <div class="flex items-center">
                                            <input type="checkbox" :id="`permissions[${name}]`" class="group-checkbox form-checkbox w-5 h-5 focus:ring-primary-600 focus:border-primary-600 text-primary-600 rounded transition duration-150 ease-in-out cursor-pointer" v-on:change="checkModify(event)">
                                            <label :for="`permissions[${name}]`" class="ml-2 block select-none cursor-pointer">
                                                {{ dressUp(name) }}
                                            </label>
                                        </div>
                                    </dt>
                                    <dd v-for="(value, title) in options" :key="title" class="px-4 mt-2 text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <input :id="`permissions[${name}][${title}]`" :name="`permissions[${name}][${title}]`" type="checkbox" class="form-checkbox w-5 h-5 focus:ring-primary-600 focus:border-primary-600 text-primary-600 rounded transition duration-150 ease-in-out cursor-pointer" v-on:change="groupCheckModify(event)">
                                            <label :for="`permissions[${name}][${title}]`" class="ml-2 block leading-5 select-none cursor-pointer">
                                                {{ dressUp(title) }}
                                            </label>
                                        </div>
                                    </dd>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-5 font-semibold text-gray-500"></dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="mt-6 flex space-x-3 md:mt-0">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600">
                                            <PencilAltIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                            Update
                                        </button>
                                    </div>
                                </dd>
                            </div>
                        </dl>
                    </form>

                </div>
            </div>
        </div>
    </AppLayout>

</template>

<script>
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';

import AppLayout from '@/Layouts/App.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Alert from '@/Components/Alert.vue';

import {
    PlusIcon,
    XIcon,
    RefreshIcon,
} from '@heroicons/vue/solid'

import {
    PencilAltIcon,
} from '@heroicons/vue/outline'

export default {
    layout: AppLayout,

    components: {
        Alert,
        Breadcrumb,
        Head,
        Link,
        ref,
        PlusIcon,
        PencilAltIcon,
        XIcon,
        RefreshIcon,
    },

    props: {
        errors: Object,
        alertMessage: Object,
        role: Object,
        items: Array,
    },

    methods: {
        dressUp(strings) {
            strings = strings.split('_');
            for(let i = 0; i < strings.length && strings[i].length > 1; i++){
                strings[i] = strings[i].charAt(0).toUpperCase() + strings[i].slice(1);
            }
            return strings.join(' ');
        },

        checkAll(e) {
            console.log(this.$refs);
        },

        checkModify(e) {
            let item = e.target;
            let checkBoxes = document.querySelectorAll(".group-checkbox");
            checkBoxes.forEach(checkbox => {
                checkbox.checked = item.checked;
            });
        },

        groupCheckModify(e) {
            let item = e.target;
            let group = item.closest(".group");
            let checkBoxes = group.querySelectorAll(".form-checkbox");
            checkBoxes.forEach(checkbox => {
                checkbox.checked = item.checked;
            });
        }
    },

    setup (props) {
        const breadcrumbs = [
            { name: 'Roles (User)', href: route('role.index'), current: false },
            { name: 'Role (User) Permission Page', href: '#', current: false },
        ]

        const form = reactive({
            permissions: props.role.permissions,
        })

        function submit() {
            Inertia.patch(route('role.permission.update', props.role.id), form)
        }

        return {
            breadcrumbs,
            form,
            submit
        }
    },
}
</script>
