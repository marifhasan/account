<template>
    <Head title="Dashboard" />

    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
            <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                <div class="flex-1 min-w-0">
                    <!-- Profile -->
                    <div class="flex items-center">
                        <img class="hidden h-16 w-16 rounded-full sm:block" :src="$page.props.default.photo" alt="" />

                        <div>
                            <div class="flex items-center">
                                <img class="h-16 w-16 rounded-full sm:hidden" :src="$page.props.default.photo" alt="" />
                                <h1 class="ml-3 text-2xl font-bold leading-7 text-gray-900 sm:leading-9 sm:truncate">
                                    {{ $page.props.greeting }}, {{ $page.props.auth.user.name }}
                                </h1>
                            </div>

                            <dl class="mt-6 flex flex-col sm:ml-3 sm:mt-1 sm:flex-row sm:flex-wrap">
                                <dt class="sr-only">Company</dt>
                                <dd class="flex items-center text-sm text-gray-500 font-medium capitalize sm:mr-6">
                                    <OfficeBuildingIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                    {{ $page.props.auth.user.address }}
                                </dd>
                                <dt class="sr-only" v-if="$page.props.auth.user.email_verified_at">Account status</dt>
                                <dd v-if="$page.props.auth.user.email_verified_at" class="mt-3 flex items-center text-sm text-gray-500 font-medium sm:mr-6 sm:mt-0 capitalize" title="verified account">
                                    <CheckCircleIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" aria-hidden="true" />
                                    <!-- Verified account -->
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Add money
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Send money
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Overview</h2>
            <div class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card -->
            <div v-for="card in cards" :key="card.name" class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                    <component :is="card.icon" class="h-6 w-6 text-gray-400" aria-hidden="true" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                        {{ card.name }}
                        </dt>
                        <dd>
                        <div class="text-lg font-medium text-gray-900">
                            {{ card.amount }}
                        </div>
                        </dd>
                    </dl>
                    </div>
                </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a :href="card.href" class="font-medium text-primary-700 hover:text-primary-900">
                    View all
                    </a>
                </div>
                </div>
            </div>
            </div>
        </div>

    </div>
</template>

<script>
import AppLayout from '@/Layouts/App.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

import { ref } from 'vue'
import { ScaleIcon } from '@heroicons/vue/outline'

import {
    CashIcon,
    CheckCircleIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    OfficeBuildingIcon,
    SearchIcon,
} from '@heroicons/vue/solid'

const cards = [
    // { name: 'Account balance', href: '#', icon: ScaleIcon, amount: '0' },
    // More items...
]

const transactions = [
    {
        id: 1,
        name: 'Payment to Molly Sanders',
        href: '#',
        amount: '$20,000',
        currency: 'USD',
        status: 'success',
        date: 'July 11, 2020',
        datetime: '2020-07-11',
    },
    // More transactions...
]

const statusStyles = {
    success: 'bg-green-100 text-green-800',
    processing: 'bg-yellow-100 text-yellow-800',
    failed: 'bg-gray-100 text-gray-800',
}

export default {
    layout: AppLayout,

    components: {
        Head,
        Link,
        ScaleIcon,
        CashIcon,
        CheckCircleIcon,
        ChevronDownIcon,
        ChevronRightIcon,
        OfficeBuildingIcon,
        SearchIcon,
    },

    setup() {
        const sidebarOpen = ref(false)

        return {
            cards,
            transactions,
            statusStyles,
            sidebarOpen,
        }
    },
}
</script>
