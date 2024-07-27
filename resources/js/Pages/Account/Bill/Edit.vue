<template>
    <Head title="Edit Bill" />

    <AppLayout>
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                        <Link :href="route('bill.create')" class="inline-flex items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary-400">
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
                    <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Bill Edit</p>

                    <div class="flex gap-4">
                        <ModelOptions :detailHref="route('bill.show', bill.id)" :editHref="null" :deleteHref="route('bill.destroy', bill.id)" deleteMessage="Do you really want to delete this order?" />
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

                            <div v-show="form.client.id" class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700"> Job <span class="text-rose-500">*</span> </label>
                                <Select v-model="form.job" :items="form.client.jobs" />
                                <InputError :message="errors.job" />
                            </div>

                            <div v-show="!(form.client.id)" class="col-span-6 sm:col-span-3"></div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="relative">
                                    <input id="amount" v-model="form.amount" type="number" v-on:keyup="calculation()" placeholder="Amount" autocomplete="bill-amount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.amount" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="number" class="block text-sm font-medium text-gray-700">Number</label>
                                <div class="relative">
                                    <input id="number" v-model="form.number" type="text" v-on:keyup="calculation()" placeholder="Number" autocomplete="bill-number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.number" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">VAT Type</label>
                                <div class="flex items-center py-2 gap-4">
                                    <label v-for="vat_type in vat_types" :key="vat_type.id" class="mr-4 inline-flex items-center">
                                        <input v-model="form.job.vat_type" :value="vat_type.id" disabled type="radio" class="form-radio w-5 h-5 border-primary-500 text-primary-500 cursor-pointer focus:ring-primary-500">
                                        <span class="ml-2 tracking-wide"> {{ vat_type.name }} </span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Vat Rate</label>
                                <div class="relative">
                                    <input v-model="form.job.vat_rate" readonly type="text" placeholder="Vat Rate" autocomplete="vat-rate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">%</span>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea id="description" v-model="form.remark" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                                <InputError :message="errors.remark" />
                            </div>

                            <div v-show="form.job.vat_type == 'excluding'" class="col-span-6 sm:col-span-2">
                                <label for="sub_total" class="block text-sm font-medium text-gray-700">Sub Total</label>
                                <div class="relative">
                                    <input id="sub_total" v-model="form.amount" readonly type="text" placeholder="Sub Total" autocomplete="sub-total" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.sub_total" />
                            </div>

                            <div v-show="form.job.vat_type == 'excluding'" class="col-span-6 sm:col-span-2">
                                <label for="vat" class="block text-sm font-medium text-gray-700">Vat</label>
                                <div class="relative">
                                    <input id="vat" v-model="form.vat" readonly type="text" placeholder="Vat" autocomplete="vat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.vat" />
                            </div>

                            <div v-show="form.job.vat_type != 'excluding'" class="col-span-6 sm:col-span-4"></div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                                <div class="relative">
                                    <input id="total" v-model="form.total" readonly type="text" placeholder="Total" autocomplete="total" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.total" />
                            </div>

                        </div>

                        <div class="flex justify-end pt-5">
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
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
        bill: Object,
        clients: Array,
        vat_types: Array,
    },

    methods: {
        calculation(){
            this.form.vat = this.form.job.vat_type == 'excluding'? ((this.form.amount || 0) * (this.form.job.vat_rate || 0) / 100) : 0;
            this.form.total = parseInt(this.form.vat || 0) + parseInt(this.form.amount || 0);
        }
    },

    setup (props) {
        const breadcrumbs = [
            { name: 'Bills', href: route('bill.index'), current: false },
            { name: 'Edit Page', href: '#', current: false },
        ]

        const form = reactive({
            client: props.bill.client?? { id: '', name: '', jobs: { id: '', name: '', vat_rate: '', vat_type: '' } },
            job: props.bill.job?? { id: '', name: '', vat_rate: '', vat_type: '' },
            date: props.bill.date,
            number: props.bill.number,
            remark: props.bill.remark,
            amount: props.bill.amount,
            vat: props.bill.vat,
            total: props.bill.total,
        })

        function submit() {
            Inertia.patch(route('bill.update', props.bill.id), form)
        }

        return {
            breadcrumbs,
            form,
            submit
        }
    }
}
</script>
