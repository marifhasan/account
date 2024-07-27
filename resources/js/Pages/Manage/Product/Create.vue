<template>
    <Head title="Create Product" />

    <AppLayout>
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4"></div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="flex justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
                        <p class="max-w-2xl leading-10 text-gray-700 text-lg font-medium"> Product Create </p>
                        <div class="flex gap-4"></div>
                    </div>

                    <Alert :message="alertMessage" :errors="errors" />

                    <form @submit.prevent="submit">
                        <dl class="space-y-8 py-6">
                            <div class="max-w-5xl mx-auto">
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Name <span class="text-red-500">*</span> </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <input v-model="form.name" placeholder="Name" type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent sm:text-sm border-gray-300 rounded">
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Company <span class="text-red-500">*</span> </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <Combobox v-model="form.company_id" :items="companies" />
                                        <InputError :message="errors.company" />
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Generic Name <span class="text-red-500">*</span> </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <input v-model="form.generic_name" placeholder="Generic Name" type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent sm:text-sm border-gray-300 rounded">
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Icon </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <input v-model="form.icon" placeholder="Icon" type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent sm:text-sm border-gray-300 rounded">
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Href </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                        <input v-model="form.href" placeholder="Href" type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent sm:text-sm border-gray-300 rounded">
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Intro </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <textarea v-model="form.intro" placeholder="Intro Here" rows="2" type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent sm:text-sm border-gray-300 rounded"></textarea>
                                        <InputError :message="errors.intro" />
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm leading-10 font-semibold text-gray-700 tracking-wider text-right pr-8"> Description </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <textarea v-model="form.description" placeholder="Description Here" rows="4" type="text" class="block w-full px-4 focus:ring-primary-400 focus:border-primary-400 hover:bg-gray-100 focus:bg-transparent sm:text-sm border-gray-300 rounded"></textarea>
                                        <InputError :message="errors.description" />
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
                                        <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                        Create
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
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";

import AppLayout from "@/Layouts/App.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Alert from "@/Components/Alert.vue";
import InputError from "@/Components/InputError.vue";
import Combobox from "@/Components/Combobox.vue";

import { PlusIcon, EyeIcon, EyeOffIcon } from "@heroicons/vue/solid";

import { PencilAltIcon } from "@heroicons/vue/outline";

export default {
    layout: AppLayout,

    components: {
        Alert,
        Breadcrumb,
        Head,
        Combobox,
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
        companies: Array,
    },

    setup() {
        const breadcrumbs = [
            { name: "Products", href: route("product.index"), current: false },
            { name: "Create Page", href: "#", current: false },
        ];

        const form = reactive({
            name: null,
            icon: null,
            href: null,
            intro: null,
            company_id: null,
            description: null,
            generic_name: null,
        });

        function submit() {
            Inertia.post(route("product.store"), form);
        }

        return {
            breadcrumbs,
            form,
            submit,
        };
    },
};
</script>
