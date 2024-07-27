<template>
    <Head title="Users" />

    <AppLayout>
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                        <Link :href="route('user.create')" class="inline-flex items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary-400">
                            <PlusIcon class="-ml-1 mr-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                            Create
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="flex justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
                        <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Users</p>
                        <div class="flex gap-4">
                            <Link :href="route('user.history')" class="inline-flex items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary-400">
                                <AnnotationIcon class="-ml-1 mr-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                                History
                            </Link>
                        </div>
                    </div>

                    <Alert :message="alertMessage" :errors="{}" />

                    <table class="table-fixed min-w-full w-full" id="table">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b bg-gray-100 text-xs font-bold uppercase tracking-wider text-left w-10">S.No</th>
                                <th class="px-5 py-3 border-b bg-gray-100 text-xs font-bold uppercase tracking-wider text-left">Name</th>
                                <th class="px-5 py-3 border-b bg-gray-100 text-xs font-bold uppercase tracking-wider text-left">Role</th>
                                <th class="px-5 py-3 border-b bg-gray-100 text-xs font-bold uppercase tracking-wider text-left w-28">Status</th>
                                <th class="px-5 py-3 border-b bg-gray-100 text-xs font-bold uppercase tracking-wider text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr v-for="(user, index) in users" :key="user.id" :class="[index % 2 == 0 ? 'bg-white' : 'bg-gray-50', 'border-b']">
                                <td class="px-5 py-2 whitespace-no-wrap">
                                    <div class="text-sm leading-5 text-gray-700">{{ (index + 1) }}</div>
                                </td>
                                <td class="px-5 py-2 whitespace-no-wrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" :src="user.photo?? user.photo_default" alt="" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm leading-5 font-semibold text-gray-700">{{ user.name }}</div>
                                            <div class="text-sm leading-5 text-gray-600">{{ user.email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-2 whitespace-no-wrap text-sm leading-5 text-gray-600">
                                    <div class="text-sm leading-5 text-gray-700">{{ user.role_name }}</div>
                                </td>
                                <td class="px-5 py-2 whitespace-no-wrap">
                                    <Status :status="user.status" color="green" />
                                    <!-- <StatusOptions :model="user" :href="route('user.status.update', user.id)" /> -->
                                </td>
                                <td class="px-5 py-2 whitespace-no-wrap">
                                    <div class="flex justify-end">
                                        <Link :href="route('user.show', user.id)" class="text-primary-600 hover:text-primary-800 ml-3" title="detail">
                                            <ExternalLinkIcon class="w-6 h-6" aria-hidden="true" />
                                        </Link>
                                        <Link :href="route('user.edit', user.id)" class="text-indigo-600 hover:text-indigo-800 ml-3" title="edit">
                                            <PencilAltIcon class="w-6 h-6" aria-hidden="true" />
                                        </Link>
                                        <button @click="deleteRecord(user.id)" class="text-rose-600 hover:text-rose-800 ml-3" title="delete">
                                            <TrashIcon class="w-6 h-6" aria-hidden="true" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';

import AppLayout from '@/Layouts/App.vue';
import StatusOptions from '@/Components/StatusOptions.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Alert from '@/Components/Alert.vue';
import ModelOptions from '@/Components/ModelOptions.vue';

import Status from '@/Components/Status.vue';

import {
    PlusIcon,
    // ExternalLinkIcon,
    // PencilAltIcon,
    // TrashIcon,
} from '@heroicons/vue/solid'

import {
    AnnotationIcon,
    ExternalLinkIcon,
    PencilAltIcon,
    TrashIcon,
} from '@heroicons/vue/outline'

const breadcrumbs = [
    { name: 'Users', href: route('user.index'), current: false },
    { name: 'List Page', href: '#', current: false },
];

export default {
    layout: AppLayout,

    components: {
        Alert,
        Status,
        StatusOptions,
        ModelOptions,
        Breadcrumb,
        Head,
        Link,
        AnnotationIcon,
        PlusIcon,
        ExternalLinkIcon,
        PencilAltIcon,
        TrashIcon,
    },

    props:{
        users: Array,
        alertMessage: Object,
    },

    mounted() {
        $('#table').DataTable({
            lengthMenu: [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
            length: 10,
            dom: "<'flex justify-center sm:justify-end mb-3'B><'flex flex-col sm:flex-row justify-between'lf><'block overflow-auto'rt><'flex flex-col sm:flex-row justify-between'ip>",
            buttons: [
                'copy', 'excel'
            ],
        });
    },

    methods: {
        deleteRecord(record_id) {
            if(confirm("Do you really want to delete this user?")) {
                Inertia.delete(route('user.destroy', record_id));
            }
        }
    },

    setup() {
        return {
            breadcrumbs,
        }
    },

}
</script>
