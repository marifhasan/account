<template>
    <Head title="Edit User" />

    <AppLayout>
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                        <Link :href="route('user.create')" class="inline-flex items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary-400">
                            <PlusIcon class="-ml-1 mr-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                            Create
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="flex justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
                        <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">User Edit</p>
                        <div class="flex gap-4">
                            <ModelOptions :detailHref="route('user.show', user.id)" :editHref="null" :deleteHref="route('user.destroy', user.id)" deleteMessage="Do you really want to delete this user?" />
                        </div>
                    </div>

                    <Alert :message="alertMessage" :errors="errors" />

                    <form @submit.prevent="submit">
                        <dl class="py-6 max-w-5xl mx-auto">

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider sm:text-right pr-8">
                                    Role <!-- <span class="text-rose-500">*</span> -->
                                </dt>
                                <dd class="mt-1 text-sm text-gray-700 sm:mt-0 sm:col-span-1">
                                    <select data-placeholder="Select Role" class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" v-model="form.role">
                                        <option value="null">Select Role</option>
                                        <option v-for="item in roles" :key="item.id" :value="item.id">{{ item.name }}</option>
                                    </select>
                                    <InputError :message="errors.role" />
                                </dd>
                            </div>

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
                                    E-mail <span class="text-rose-500">*</span>
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <input class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="email" autocomplete="off" placeholder="name@example.com" v-model="form.email" label="Email">
                                    <InputError :message="errors.email" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Password
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <div class="flex rounded shadow-sm">
                                        <input class="focus-within:z-10 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded-l" :type="password_status ? 'password' : 'text'" placeholder="Password" v-model="form.password" label="Password">
                                        <span class="inline-flex items-center justify-center px-4 rounded-r border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                            <svg v-show="password_status" v-on:click="password_status = !(password_status)" class="w-5 h-5 cursor-pointer text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                            <svg v-show="!password_status" v-on:click="password_status = !(password_status)" class="w-5 h-5 cursor-pointer text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </span>
                                    </div>
                                    <InputError :message="errors.password" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Mobile
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                    <div class="flex rounded shadow-sm">
                                        <span class="inline-flex items-center justify-center px-4 rounded-l border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">+88</span>
                                        <input class="focus-within:z-10 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded-r" type="text" placeholder="Mobile" v-model="form.mobile" label="Mobile">
                                    </div>
                                    <InputError :message="errors.mobile" />
                                </dd>
                            </div>

                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8">
                                    Address
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <textarea class="focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent block w-full px-4 sm:text-sm border-gray-300 rounded" type="text" autocomplete="off" placeholder="Address Here" rows="4" v-model="form.address" label="Address"></textarea>
                                    <InputError :message="errors.address" />
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
import ModelOptions from '@/Components/ModelOptions.vue';
import Alert from '@/Components/Alert.vue';
import InputError from '@/Components/InputError.vue';

import {
    PlusIcon,
    XIcon,
    RefreshIcon,
} from '@heroicons/vue/solid'

import {
    PencilAltIcon,
} from '@heroicons/vue/outline'

export default {
    layout: AppLayout,

    components: {
        Alert,
        Breadcrumb,
        ModelOptions,
        Head,
        InputError,
        Link,
        PlusIcon,
        PencilAltIcon,
        XIcon,
        RefreshIcon,
    },
    props: {
        errors: Object,
        alertMessage: Object,
        roles: Array,
        user: Object,
    },
    data() {
        return {
            password_status: true,
        }
    },
    setup (props) {
        const breadcrumbs = [
            { name: 'Users', href: route('user.index'), current: false },
            { name: 'Edit Page', href: '#', current: false },
        ]

        const form = reactive({
            role: props.user.role_id,
            name: props.user.name,
            email: props.user.email,
            password: props.user.password,
            mobile: props.user.mobile,
            address: props.user.address,
        })

        function submit() {
            Inertia.patch(route('user.update', props.user.id), form)
        }

        return {
            breadcrumbs,
            form,
            submit
        }
    },
}
</script>
