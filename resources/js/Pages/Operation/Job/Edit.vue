<template>
    <Head title="Edit Job" />

    <AppLayout>
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                        <Link :href="route('job.create')" class="inline-flex items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary-400">
                            <PlusIcon class="-ml-1 mr-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                            Create
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="flex justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
                    <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Job Edit</p>

                    <div class="flex gap-4">
                        <ModelOptions :detailHref="route('job.show', job.id)" :editHref="null" :deleteHref="route('job.destroy', job.id)" deleteMessage="Do you really want to delete this order?" />
                    </div>
                </div>

                <Alert :message="alertMessage" :errors="errors" />

                <form @submit.prevent="submit">
                    <dl class="space-y-8 divide-y divide-gray-200 py-6 max-w-3xl mx-auto">

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Client<span class="text-rose-500">*</span></label>
                                <Select v-model="form.client" :items="clients" />
                                <InputError :message="errors.client" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date <span class="text-rose-500">*</span></label>
                                <input id="start_date" v-model="form.start_date" type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.start_date" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="expected_date" class="block text-sm font-medium text-gray-700">Expected Delivery Date <span class="text-rose-500">*</span></label>
                                <input id="expected_date" v-model="form.expected_date" type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.expected_date" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="delivery_date" class="block text-sm font-medium text-gray-700">Delivery Date</label>
                                <input id="delivery_date" v-model="form.delivery_date" type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.delivery_date" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-rose-500">*</span></label>
                                <input id="name" v-model="form.name" type="text" placeholder="Project Name" autocomplete="job-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.name" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="amount" class="block text-sm font-medium text-gray-700">amount</label>
                                <div class="relative">
                                    <input id="amount" v-model="form.amount" type="text" placeholder="amount" autocomplete="job-amount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.amount" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="vat_rate" class="block text-sm font-medium text-gray-700">Vat</label>
                                <div class="relative">
                                    <input id="vat_rate" v-model="form.vat_rate" type="text" placeholder="Vat" autocomplete="vat-amount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">%</span>
                                </div>
                                <InputError :message="errors.vat_rate" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="vat_type" class="block text-sm font-medium text-gray-700">VAT Type</label>
                                <div class="flex items-center py-2 gap-4">
                                    <label v-for="(vat_type, index) in vat_types" :key="index" class="mr-4 inline-flex items-center cursor-pointer">
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
                                <PencilAltIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                Edit
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
import ModelOptions from '@/Components/ModelOptions.vue';

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
        ModelOptions,
        PlusIcon,
        PencilAltIcon,
        EyeIcon,
        EyeOffIcon,
        XIcon,
    },
    props: {
        errors: Object,
        alertMessage: Object,
        job: Object,
        clients: Array,
        vat_types: Array,
    },

    setup (props) {
        const breadcrumbs = [
            { name: 'Jobs', href: route('job.index'), current: false },
            { name: 'Edit Page', href: '#', current: false },
        ]

        const form = reactive({
            client: props.clients.find(client => client.id == props.job.client_id),
            name: props.job.name,
            amount: props.job.amount,
            start_date: props.job.start_date,
            expected_date: props.job.expected_date,
            delivery_date: props.job.delivery_date,
            vat_type: props.job.vat_type,
            vat_rate: props.job.vat_rate,
            remark: props.job.remark,
        })

        function submit() {
            Inertia.patch(route('job.update', props.job.id), form)
        }

        return {
            breadcrumbs,
            form,
            submit
        }
    }
}
</script>
