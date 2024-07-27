<template>
    <!-- Global notification live region, render this permanently at the end of the document -->
    <div v-if="showSuccess" aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
            <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
            <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <CheckCircleIcon class="h-6 w-6 text-green-400" aria-hidden="true" />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-green-900"> Successful! </p>
                                <p class="mt-1 text-sm text-green-500"> {{ message.success }} </p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="close" class="bg-transparent rounded-md inline-flex text-red-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <span class="sr-only">Close</span>
                                    <XIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>

    <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
    <div v-if="showFail" aria-live="assertive" class="fixed z-10 inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
            <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <XIcon class="h-6 w-6 text-red-400" aria-hidden="true" />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-red-900"> Failed! </p>
                                <p class="mt-1 text-sm text-red-500"> {{ message.fail }} </p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="close" class="bg-transparent rounded-md inline-flex text-red-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <span class="sr-only">Close</span>
                                <XIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>

</template>
<script>
import { ref, watch } from 'vue'

import {
    CheckCircleIcon,
    XCircleIcon,
    XIcon,
} from '@heroicons/vue/solid'

export default {
    components: {
        CheckCircleIcon,
        XCircleIcon,
        XIcon,
    },
    props: {
        message: Object,
        errors: Object,
    },
    methods: {
        close() {
            this.showSuccess = false
            this.showFail = false
        }
    },
    watch: {
        message: function(newVal, oldVal) {
            this.showSuccess = newVal.success ? true : false
            this.showFail = newVal.fail ? true : false

            if(this.showSuccess) {
                setTimeout(() => this.close(), 5000);
            }
        },
        errors: function(newVal, oldVal) {
            this.showFail = Object.keys(newVal).length ? true : false
        }
    },
    data(props) {
        let showSuccess = props.message.success ? true : false
        let showFail = Object.keys(props.errors).length || props.message.fail ? true : false

        return {
            showSuccess,
            showFail,
        }
    }
}
</script>
