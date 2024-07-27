<template>
    <Head title="Profile" />

    <AppLayout>
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                        <Link :href="route('profile.password')" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <LockOpenIcon class="-ml-1 mr-2 h-5 w-5 text-gray-400" />
                            Change Password
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                        <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                            <div class="ml-4 mt-4">
                                <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium">Profile</p>
                            </div>
                            <div class="ml-4 mt-4 flex-shrink-0 flex">
                            </div>
                        </div>
                    </div>

                    <Alert :message="alertMessage" :errors="errors" />

                    <form @submit.prevent="submit">
                        <dl class="space-y-8 py-6">
                            <div class="max-w-5xl mx-auto">
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider sm:text-right pr-8"> Photo </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <div class="relative h-32 w-32">
                                            <div class="flex text-sm text-gray-700 border border-gray-400 rounded-md bg-gray-50">
                                                <img class="object-cover h-32 w-32" :src="form.photo?? form.photo_default" title="Click to upload photo">
                                                <div class="absolute bottom-0 bg-gray-50 w-full text-center opacity-60 cursor-pointer" @click="$refs.photo.click()"><span class="text-xs text-black">Click to upload</span></div>
                                                <input ref="photo" type="file" class="hidden" @input="form.photo_file = $event.target.files[0]" @change="form.photo = onFileInput($event.target.files[0]);" accept=".png, .jpg, .jpeg" />
                                            </div>
                                            <div v-show="form.photo != form.photo_default" class="absolute top-0 right-0 px-0 py-0 bg-gray-50 opacity-60" title="Remove Photo">
                                                <XIcon class="w-5 h-5 text-red-500 hover:text-red-700 cursor-pointer" aria-hidden="true" @click="form.photo = form.photo_default; $refs.photo.value = ''; form.photo_removed = true" />
                                            </div>
                                            <div v-show="form.photo != profile.photo" class="absolute top-0 left-0 px-0 py-0 bg-gray-50 opacity-60" title="Refresh Photo">
                                                <RefreshIcon class="w-5 h-5 text-primary-500 hover:text-primary-700 cursor-pointer" aria-hidden="true" @click="form.photo = profile.photo; $refs.photo.value = ''; form.photo_removed = false" />
                                            </div>
                                        </div>
                                        <InputError :message="errors.photo" />
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Name <span class="text-red-500">*</span> </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <input v-model="form.name" placeholder="Name" type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent sm:text-sm border-gray-300 rounded">
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Email </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <input v-model="form.email" placeholder="Email" readonly type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 bg-gray-100 sm:text-sm border-gray-300 rounded">
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Mobile </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <div class="relative">
                                            <span class="absolute py-2 top-0 left-0 m-px px-4 rounded-l-md border-r border-gray-300 bg-gray-100 sm:text-sm">+88</span>
                                            <input v-model="form.mobile" placeholder="Mobile" type="text" class="block w-full px-4 pl-16 focus:outline-none focus:ring-primary-400 focus:border-primary-400 focus:bg-transparent hover:bg-gray-100 sm:text-sm border-gray-300 rounded">
                                        </div>
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Address </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <textarea v-model="form.address" placeholder="Address Here" rows="4" type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent sm:text-sm border-gray-300 rounded"></textarea>
                                        <InputError :message="errors.address" />
                                    </dd>
                                </div>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300" />
                                </div>
                                <div class="relative flex justify-center ml-4">
                                    <span class="px-3 bg-white text-lg font-medium text-gray-900"></span>
                                </div>
                            </div>

                            <div class="max-w-5xl mx-auto">
                                <div class="flex justify-end">
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        <PencilAltIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                        Update
                                    </button>
                                </div>
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
import Alert from '@/Components/Alert.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import InputError from '@/Components/InputError.vue';

import { UploadIcon } from '@heroicons/vue/outline'

import {
    LockOpenIcon,
    PhoneIcon,
    PencilAltIcon,
    MailIcon,
    RefreshIcon,
    XIcon,
} from '@heroicons/vue/solid'

export default {
    layout: AppLayout,

    components: {
        Head,
        Link,
        Alert,
        Breadcrumb,
        InputError,
        LockOpenIcon,
        RefreshIcon,
        XIcon,
        PhoneIcon,
        PencilAltIcon,
        MailIcon,
        UploadIcon,
    },

    props: {
        profile: Object,
        errors: Object,
        alertMessage: Object,
    },

    methods: {
        onFileInput(file) {
            return URL.createObjectURL(file);
        },
    },

    setup (props) {
        const breadcrumbs = [
            { name: 'Account', href: route('profile.index'), current: false },
            { name: 'Profile', href: '#', current: true },
        ]

        const form = reactive({
            name: props.profile.name,
            email: props.profile.email,
            mobile: props.profile.mobile,
            address: props.profile.address,

            photo: props.profile.photo,
            photo_default: props.profile.photo_default,
            photo_removed: false,
        })

        function submit() {
            Inertia.post(route('profile.update'), form)
        }

        return {
            breadcrumbs,
            form,
            submit,
        }
    },
}
</script>
