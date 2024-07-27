<template>
    <div :class="[row_position % 2 == 1 ? 'bg-white' : 'bg-gray-50', 'px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6']">
        <dt class="text-sm font-medium text-gray-500">Documents</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <ul role="list" :class="[ documents.length? 'border border-gray-200 rounded-md' : '','divide-y divide-gray-200']">
                <li v-for="document in documents" :key="document.id" class="px-3 py-2 flex items-center justify-between text-sm">
                    <div class="w-0 flex-1 flex items-center">
                        <PaperClipIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />
                        <span class="ml-2 flex-1 w-0 truncate"> {{ document.path.split('/').pop() }} </span>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <a :href="document.full_path" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500"> Download </a>
                        <button @click="deleteRecord(document.id)" class="ml-3 font-medium text-red-600 hover:text-red-500"> Remove </button>
                    </div>
                </li>
            </ul>

            <form @submit.prevent="submitDoc" class="mt-5">

                <div class="mt-1 relative w-full">
                    <div class="flex text-sm text-gray-700">
                        <input ref="document" type="file" multiple @input="form.document_files = $event.target.files" accept="*" />
                    </div>

                    <button type="submit" class="inline-flex justify-center mt-2 py-1.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <UploadIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                        Upload
                    </button>
                </div>
            </form>
        </dd>
    </div>
</template>

<script>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';

import InputError from '@/Components/InputError.vue';

import {
    PaperClipIcon,
} from '@heroicons/vue/solid'

import {
    UploadIcon,
} from '@heroicons/vue/outline'

export default {
    components: {
        Link,
        InputError,

        PaperClipIcon,
        UploadIcon,
    },

    props: ['documents','table','table_id','row_position'],

    methods: {
        deleteRecord(record_id) {
            if(confirm("Do you really want to delete this document?")) {
                Inertia.delete(route('document.destroy', record_id));
            }
        }
    },


    setup(props) {

        const form = reactive({
            id: props.table_id,
            model: props.table,
            document_files: null,
        })

        function submitDoc() {
            Inertia.post(route('document.upload'), form)
            form.document_files = null;
        }

        return {
            form,
            submitDoc
        }
    },
}
</script>
