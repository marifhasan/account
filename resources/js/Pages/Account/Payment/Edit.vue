<template>
    <Head title="Edit Payment" />

    <AppLayout>
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                        <Link :href="route('payment.create')" class="inline-flex items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary-400">
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
                    <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Payment Edit</p>

                    <div class="flex gap-4">
                        <ModelOptions :detailHref="route('payment.show', payment.id)" :editHref="null" :deleteHref="route('payment.destroy', payment.id)" deleteMessage="Do you really want to delete this payment?" />
                    </div>
                </div>

                <Alert :message="alertMessage" :errors="errors" />

                <form @submit.prevent="submit">
                    <dl class="space-y-8 divide-y divide-gray-200 py-6 max-w-3xl mx-auto">

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="payment_type" class="block text-sm font-medium text-gray-700">Set Type</label>
                                <div class="flex items-center py-2 gap-4">
                                    <label class="mr-4 inline-flex items-center cursor-pointer">
                                        <input type="radio" class="form-radio w-5 h-5 border-primary-500 text-primary-500 cursor-pointer focus:ring-primary-500" v-model="form.payment_type" value="asset">
                                        <span class="ml-2 tracking-wide">Asset</span>
                                    </label>
                                    <label class="mr-4 inline-flex items-center cursor-pointer">
                                        <input type="radio" class="form-radio w-5 h-5 border-primary-500 text-primary-500 cursor-pointer focus:ring-primary-500" v-model="form.payment_type" value="sector">
                                        <span class="ml-2 tracking-wide">Sector</span>
                                    </label>
                                </div>
                                <InputError :message="errors.payment_type" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="date" class="block text-sm font-medium text-gray-700">Date <span class="text-rose-500">*</span></label>
                                <input id="date" type="date" v-model="form.date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                <InputError :message="errors.date" />
                            </div>

                            <div v-show="form.payment_type == 'asset'" class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700"> Asset <span class="text-rose-500">*</span> </label>
                                <Select v-model="form.asset" :items="assets" />
                                <InputError :message="errors.asset" />
                            </div>

                            <div v-show="form.payment_type == 'sector'" class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700"> Sector <span class="text-rose-500">*</span> </label>
                                <Select v-model="form.sector" :items="sectors" />
                                <InputError :message="errors.sector" />
                            </div>

                            <div class="col-span-6 sm:col-span-3"></div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700"> Account <span class="text-rose-500">*</span> </label>
                                <Select v-model="form.account" :items="accounts" />
                                <InputError :message="errors.account" />
                            </div>

                            <div class="col-span-6 sm:col-span-3"></div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="relative">
                                    <input id="amount" type="text" v-model="form.amount" v-on:keyup="form.total = parseInt(form.amount || 0) + parseInt(form.discount || 0)" placeholder="Amount" autocomplete="payment-amount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.amount" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="discount" class="block text-sm font-medium text-gray-700">Discount</label>
                                <div class="relative">
                                    <input id="discount" type="text" v-model="form.discount" v-on:keyup="form.total = parseInt(form.amount || 0) + parseInt(form.discount || 0)" placeholder="Discount" autocomplete="payment-discount" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <span class="absolute py-2 top-0 right-0 m-px px-4 rounded-r-md border-l border-gray-300 bg-gray-100 sm:text-sm">&#2547;</span>
                                </div>
                                <InputError :message="errors.discount" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                                <div class="relative">
                                    <input id="total" type="text" v-model="form.total" placeholder="Total" readonly autocomplete="payment-total" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 pr-14 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
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
import ModelOptions from '@/Components/ModelOptions.vue';
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
        ModelOptions,
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
        payment: Object,
        assets: Array,
        accounts: Array,
        sectors: Array,
    },

    setup (props) {
        const breadcrumbs = [
            { name: 'Payments', href: route('payment.index'), current: false },
            { name: 'Edit Page', href: '#', current: false },
        ]

        const form = reactive({
            payment_type: props.payment.payment_type,
            asset: props.payment.asset,
            account: props.payment.account,
            sector: props.payment.sector,
            amount: props.payment.amount,
            discount: props.payment.discount,
            total: props.payment.total,
            date: props.payment.read_date,
            remark: props.payment.remark,
        })

        function submit() {
            Inertia.patch(route('payment.update', props.payment.id), form)
        }

        return {
            breadcrumbs,
            form,
            submit
        }
    },
}
</script>
