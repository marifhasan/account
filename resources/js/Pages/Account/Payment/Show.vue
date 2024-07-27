<template>
    <Head title="Payment" />

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

        <div class="py-5">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                        <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            {{ payment.asset_name }}
                                            {{ payment.sector_name }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 mt-4 flex-shrink-0 flex">
                                <a v-show="payment.mobile && payment.id != auth.payment.id" :href="'tel:' + payment.phone" class="relative inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <PhoneIcon class="-ml-1 mr-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                                    <span>Phone</span>
                                </a>

                                <a v-show="payment.email && payment.id != auth.payment.id" :href="'mailto:' + payment.email" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <MailIcon class="-ml-1 mr-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                                    <span>Email</span>
                                </a>

                                <ModelOptions :detailHref="null" :editHref="route('payment.edit', payment.id)" :deleteHref="route('payment.destroy', payment.id)" deleteMessage="Do you really want to delete this payment?" />
                            </div>
                        </div>
                    </div>

                    <Alert :message="alertMessage" :errors="errors" />

                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div v-show="payment.sector_name" class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Sector
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ payment.sector_name }}
                                </dd>
                            </div>
                            <div v-show="payment.asset_name" class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Sector
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ payment.asset_name }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Account
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ payment.account_name }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Amount
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ payment.amount }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Discount
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ payment.discount }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Total
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ payment.total }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

import AppLayout from '@/Layouts/App.vue';
import Alert from '@/Components/Alert.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import ModelOptions from '@/Components/ModelOptions.vue';

import {
    ChevronDownIcon,
    MailIcon,
    PencilAltIcon,
    PhoneIcon,
    PlusIcon,
    TrashIcon,
} from '@heroicons/vue/solid'

export default {
    layout: AppLayout,

    components: {
        Alert,
        Breadcrumb,
        ModelOptions,
        Head,
        Link,
        ChevronDownIcon,
        MailIcon,
        PencilAltIcon,
        PhoneIcon,
        PlusIcon,
        TrashIcon,
    },
    props: {
        errors: Object,
        alertMessage: Object,
        payment: Object,
        auth: Object,
    },
    setup() {
        const breadcrumbs = [
            { name: 'Payments', href: route('payment.index'), current: false },
            { name: 'Detail Page', href: '#', current: false },
        ]

        return {
            breadcrumbs,
        }
    },
}
</script>
