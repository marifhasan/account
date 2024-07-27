<template>
    <Head title="Create Job" />

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

        <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="flex justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
                    <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Job Create</p>

                    <div class="flex gap-4">
                    </div>
                </div>

                <Alert :message="alertMessage" :errors="errors" />

                <form @submit.prevent="submit">
                    <dl class="space-y-8 divide-y divide-gray-200 py-6 max-w-3xl mx-auto">

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Client
                                    <span class="text-rose-500">*</span>
                                </label>
                                <Select v-model="form.client" :items="clients" creatable="Client" />
                                <InputError :message="errors.client" />
                            </div>

                            <div class="col-span-6 sm:col-span-3"></div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-rose-500">*</span></label>
                                <input id="name" type="text" v-model="form.name" placeholder="Job Name" autocomplete="job-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.name" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="relative">
                                    <input id="amount" type="text" v-model="form.amount" placeholder="Amount" autocomplete="job-amount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.amount" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date <span class="text-rose-500">*</span></label>
                                <input id="start_date" type="date" v-model="form.start_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.start_date" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="expected_date" class="block text-sm font-medium text-gray-700">Expected Delivery Date</label>
                                <input id="expected_date" type="date" v-model="form.expected_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.expected_date" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="vat_rate" class="block text-sm font-medium text-gray-700">VAT</label>
                                <div class="relative">
                                    <input id="vat_rate" type="text" v-model="form.vat_rate" placeholder="VAT" autocomplete="vat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">%</span>
                                </div>
                                <InputError :message="errors.vat_rate" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">VAT Type</label>
                                <div class="flex items-center py-2 gap-4">
                                    <label v-for="vat_type in vat_types" :key="vat_type.id" class="mr-4 inline-flex items-center cursor-pointer">
                                        <input v-model="form.vat_type" :value="vat_type.id" type="radio" class="form-radio w-5 h-5 border-primary-500 text-primary-500 cursor-pointer focus:ring-primary-500">
                                        <span class="ml-2 tracking-wide"> {{ vat_type.name }} </span>
                                    </label>
                                </div>
                                <InputError :message="errors.vat_type" />
                            </div>

                            <div class="col-span-6 sm:col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea id="description" v-model="form.remark" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                                <InputError :message="errors.remark" />
                            </div>
                        </div>

                        <div class="flex justify-end pt-5">
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Create
                            </button>
                        </div>
                    </dl>
                </form>

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
import Select from '@/Components/Select.vue';

import {
    PlusIcon,
    EyeIcon,
    EyeOffIcon,
} from '@heroicons/vue/solid'

import {
    PencilAltIcon,
    XIcon,
} from '@heroicons/vue/outline'

export default {
    layout: AppLayout,

    components: {
        Alert,
        Breadcrumb,
        Head,
        InputError,
        Select,
        Link,
        PlusIcon,
        PencilAltIcon,
        EyeIcon,
        EyeOffIcon,
        XIcon,
    },
    props: {
        errors: Object,
        alertMessage: Object,
        clients: Array,
        vat_types: Array,
    },

    setup () {
        const breadcrumbs = [
            { name: 'Jobs', href: route('job.index'), current: false },
            { name: 'Create Page', href: '#', current: false },
        ]

        const form = reactive({
            client: null,
            name: null,
            amount: null,
            start_date: null,
            expected_date: null,
            vat_type: 'including',
            vat_rate: null,
            remark: null,
        })

        function submit() {
            Inertia.post(route('job.store'), form);

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
