<template>
    <Head title="Create Asset" />

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
                        <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Asset Create</p>
                        <div class="flex gap-4">
                        </div>
                    </div>

                    <Alert :message="alertMessage" :errors="errors" />

                    <form @submit.prevent="submit">
                        <dl class="py-6 max-w-5xl mx-auto">

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider sm:text-right pr-8">
                                    Type <span class="text-rose-500">*</span>
                                </dt>
                                <dd class="mt-1 text-sm text-gray-700 sm:mt-0 sm:col-span-1">
                                    <select data-placeholder="Select Type" class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" v-model="form.type">
                                        <option value="null">Select Type</option>
                                        <option v-for="item in types" :key="item.id" :value="item.id">{{ item.name }}</option>
                                    </select>
                                    <InputError :message="errors.type" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Name <span class="text-rose-500">*</span>
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <input class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" v-model="form.name" placeholder="Name" label="Name">
                                    <InputError :message="errors.name" />
                                </dd>

                                <dd class="mt-1 text-sm text-gray-700 sm:mt-0 sm:col-span-1">
                                    <div class="inline-flex items-center py-2 text-sm font-medium rounded text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600">
                                        <input class="group-checkbox form-checkbox w-5 h-5 focus:ring-primary-600 focus:border-primary-600 text-primary-600 transition duration-150 ease-in-out rounded cursor-pointer" type="checkbox" v-model="form.is_fixed" :checked="form.is_fixed" placeholder="isFixed" label="isFixed">
                                        <label for="is_fixed" @click="form.is_fixed = !(form.is_fixed)" class="ml-5 block leading-5 cursor-pointer">Fixed Asset</label>
                                    </div>
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Value
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <input class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" v-model="form.value" placeholder="Value" label="Value">
                                    <InputError :message="errors.contact_name" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Address
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <textarea class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" autocomplete="off" v-model="form.address" placeholder="Address Here" rows="4" label="Address"></textarea>
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
        types: Array,
    },

    setup () {
        const breadcrumbs = [
            { name: 'Assets', href: route('asset.index'), current: false },
            { name: 'Create Page', href: '#', current: false },
        ]

        const form = reactive({
            name: null,
            is_fixed: false,
            value: null,
            type: null,
            address: null,
            remark: null,
        })

        function submit() {
            Inertia.post(route('asset.store'), form);

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
