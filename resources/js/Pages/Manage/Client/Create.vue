<template>
    <Head title="Create Client" />

    <AppLayout>
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
                        <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Client Create</p>
                        <div class="flex gap-4">
                        </div>
                    </div>

                    <Alert :message="alertMessage" :errors="errors" />

                    <form @submit.prevent="submit">
                        <dl class="py-6 max-w-5xl mx-auto">

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Name <span class="text-rose-500">*</span>
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <input class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" placeholder="Full Name" v-model="form.name" label="Name">
                                    <InputError :message="errors.name" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Short
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <input class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" placeholder="Short" v-model="form.short" label="Short">
                                    <InputError :message="errors.short" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Contact Name
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <input class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" placeholder="Full Contact Name" v-model="form.contact_name" label="Contact Name">
                                    <InputError :message="errors.contact_name" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Contact Number
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <div class="flex rounded shadow-sm">
                                        <span class="inline-flex items-center justify-center px-4 rounded-l border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">+88</span>
                                        <input class="focus-within:z-10 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded-r" type="text" placeholder="Contact Number" v-model="form.contact_number" label="Contact Number">
                                    </div>
                                    <InputError :message="errors.contact_number" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Address
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <textarea class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" autocomplete="off" v-model="form.address" placeholder="Address Here" rows="2" label="Address"></textarea>
                                    <InputError :message="errors.address" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Description
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <textarea class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" autocomplete="off" v-model="form.remark" placeholder="Description Here" rows="4" label="Description"></textarea>
                                    <InputError :message="errors.remark" />
                                </dd>
                            </div>

                            <hr class="my-4">

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-5 font-semibold text-gray-500"></dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="mt-6 flex space-x-3 md:mt-0">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600">
                                            <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                            Create
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
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';

import AppLayout from '@/Layouts/App.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Alert from '@/Components/Alert.vue';
import InputError from '@/Components/InputError.vue';

import {
    PlusIcon,
    EyeIcon,
    EyeOffIcon,
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
        InputError,
        Link,
        PlusIcon,
        PencilAltIcon,
        EyeIcon,
        EyeOffIcon,
    },
    props: {
        errors: Object,
        alertMessage: Object,
    },

    setup () {
        const breadcrumbs = [
            { name: 'Clients', href: route('client.index'), current: false },
            { name: 'Create Page', href: '#', current: false },
        ]

        const form = reactive({
            name: null,
            short: null,
            address: null,
            remark: null,
            contact_name: null,
            contact_number: null,
        })

        function submit() {
            Inertia.post(route('client.store'), form);

            // let obj = this.form;
            // Object.getOwnPropertyNames(obj).forEach(function (prop) {
            //     obj[prop] = null;
            // });
        }

        return {
            breadcrumbs,
            form,
            submit
        }
    }
}
</script>
