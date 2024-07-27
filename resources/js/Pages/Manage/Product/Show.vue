<template>
    <Head title="Product" />

    <AppLayout>
        <div class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
                    <div class="flex-1 min-w-0">
                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="mt-6 h-9 flex space-x-3 md:mt-0 md:ml-4">
                        <Link :href="route('product.create')" class="inline-flex items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary-400">
                            <PlusIcon class="-ml-1 mr-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                            Create
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">

                <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                        <div class="ml-4 mt-4">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        {{ product.name }}
                                    </h3>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        Product details and information.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex-shrink-0 flex">
                            <ModelOptions :detailHref="null" :editHref="route('product.edit', product.id)" :deleteHref="route('product.destroy', product.id)" deleteMessage="Do you really want to delete this product?" />
                        </div>
                    </div>
                </div>

                <Alert :message="alertMessage" :errors="errors" />

                <div class="mb-6 px-4 py-5 sm:px-6">
                    <dl>
                        <div class="max-w-6xl mx-auto">
                            <div v-for="item, index in data" :key="index" :class="[index % 2 == 1 ? 'bg-white' : 'bg-gray-50', 'px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6']">
                                <dt class="text-sm font-medium text-gray-500">{{ item.name }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ item.value }}
                                </dd>
                            </div>

                            <div :class="[data.length % 2 == 1 ? 'bg-white' : 'bg-gray-50', 'px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6']">
                                <dt class="text-sm font-medium text-gray-500">Testimonials</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <ul role="list" :class="[ product.testimonials.length? 'border border-gray-200 rounded-md' : '','divide-y divide-gray-200 mb-5']">
                                        <li v-for="testimonial in product.testimonials" :key="testimonial.id" class="px-3 py-2 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <ArrowRightIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />
                                                <span class="ml-2 flex-1 w-0 truncate"> {{ testimonial.description }} </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <button @click="selected_testimonial = testimonial" class="font-medium text-indigo-600 hover:text-indigo-500"> Edit </button>
                                                <button @click="deleteRecord(testimonial.id)" class="ml-3 font-medium text-red-600 hover:text-red-500"> Remove </button>
                                            </div>
                                        </li>
                                    </ul>

                                    <Testimonial :object="product" :testimonial="selected_testimonial" />
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';

import Alert from '@/Components/Alert.vue';
import AppLayout from '@/Layouts/App.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import ModelOptions from '@/Components/ModelOptions.vue';
import StatusOptions from '@/Components/StatusOptions.vue';
import Testimonial from '@/Components/Testimonial.vue';

import {
    ChevronDownIcon,
    MailIcon,
    ArrowRightIcon,
    PencilAltIcon,
    PhoneIcon,
    PlusIcon,
    TrashIcon,
} from '@heroicons/vue/solid'

import {
    ThumbUpIcon,
} from '@heroicons/vue/outline'

export default {
    layout: AppLayout,

    components: {
        Alert,
        Breadcrumb,
        Head,
        Link,
        StatusOptions,
        ModelOptions,
        Testimonial,

        ChevronDownIcon,
        MailIcon,
        ArrowRightIcon,
        PencilAltIcon,
        PhoneIcon,
        PlusIcon,
        TrashIcon,
        ThumbUpIcon,
    },

    props: {
        errors: Object,
        alertMessage: Object,
        product: Object,
        auth: Object,
    },

    methods: {
        deleteRecord(record_id) {
            if(confirm("Do you really want to delete this testimonial?")) {
                Inertia.delete(route('testimonial.destroy', record_id));
            }
        }
    },

    setup(props) {
        const breadcrumbs = [
            { name: 'Products', href: route('product.index'), current: false },
            { name: 'Detail Page', href: '#', current: false },
        ]

        const data = [
            { name: 'Name', value: props.product.name },
            { name: 'Generic Name', value: props.product.generic_name },
            { name: 'Intro', value: props.product.intro },
            { name: 'Description', value: props.product.description },
            { name: 'Href', value: props.product.href },
            { name: 'Icon', value: props.product.icon },
            { name: 'Branding', value: props.product.branding != 0? (props.product.branding != 0? 'Top Position' : 'Bottom Position') : null},
        ]

        const selected_testimonial = null

        return {
            breadcrumbs,
            data,
            selected_testimonial,
        }
    },
}
</script>
