<template>
    <Head title="Settings" />

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
                        <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Settings</p>
                    </div>

                    <Alert :message="alertMessage" :errors="errors" />

                    <dl class="py-6 max-w-5xl mx-auto">
                        <form @submit.prevent="submit">

                            <div v-for="setting in settings" :key="setting.id" class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8" v-html="setting.title"></dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <input class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" :name="setting.name" placeholder="Name" v-model="setting.value">
                                    <!-- <InputError :message="errors[setting.name]" /> -->
                                </dd>
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
                        </form>
                    </dl>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';

import Alert from '@/Components/Alert.vue';
import AppLayout from '@/Layouts/App.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';

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
        PencilAltIcon,
    },

    props: {
        errors: Object,
        alertMessage: Object,
        settings: Object,
    },
    setup (props) {
        const breadcrumbs = [
            { name: 'Setting', href: route('setting.edit'), current: false },
        ]

        const form = reactive({
            settings: props.settings
        })

        function submit() {
            Inertia.patch(route('setting.update'), form)
        }

        return {
            breadcrumbs,
            form,
            submit
        }
    },
}
</script>
