<template>
    <Head title="Create Collection" />

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
                    <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Collection Create</p>

                    <div class="flex gap-4">
                    </div>
                </div>

                <Alert :message="alertMessage" :errors="errors" />

                <form @submit.prevent="submit">
                    <dl class="space-y-8 divide-y divide-gray-200 py-6 max-w-3xl mx-auto">

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="date" class="block text-sm font-medium text-gray-700">Date <span class="text-rose-500">*</span></label>
                                <input id="date" type="date" v-model="form.date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.date" />
                            </div>

                            <div class="col-span-6 sm:col-span-3"></div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700"> Client <span class="text-rose-500">*</span> </label>
                                <Select v-model="form.client" :items="clients" />
                                <InputError :message="errors.client" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700"> Account <span class="text-rose-500">*</span> </label>
                                <Select v-model="form.account" :items="accounts" />
                                <InputError :message="errors.account" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="relative">
                                    <input id="amount" type="text" v-model="form.amount" v-on:keyup="calculation()" placeholder="Amount" autocomplete="collection-amount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.amount" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="discount" class="block text-sm font-medium text-gray-700">Discount</label>
                                <div class="relative">
                                    <input id="discount" type="text" v-model="form.discount" v-on:keyup="calculation()" placeholder="Discount" autocomplete="collection-discount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.discount" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                                <div class="relative">
                                    <input id="total" type="text" v-model="form.total" readonly placeholder="Total" autocomplete="collection-total" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.total" />
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
        accounts: Array,
    },

    methods: {
        calculation(){
            this.form.total = parseInt(this.form.amount || 0) - parseInt(this.form.discount || 0);
        }
    },

    setup () {
        const breadcrumbs = [
            { name: 'Collections', href: route('collection.index'), current: false },
            { name: 'Create Page', href: '#', current: false },
        ]

        const form = reactive({
            date: null,
            amount: null,
            discount: null,
            total: null,
            client: { id: '', name: '' },
            account: null,
        })

        function submit() {
            Inertia.post(route('collection.store'), form);

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
