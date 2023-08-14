<template>
    <App>
        <TransitionRoot as="template" :show="open">
            <Dialog as="div" class="relative z-10" @close="open = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                                 leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300"
                                         enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                         leave-from="opacity-100 translate-y-0 sm:scale-100"
                                         leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel
                                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true"/>
                                        </div>
                                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                            <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">
                                                Forbidden
                                            </DialogTitle>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">You have to subscribe to content creator to view content.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                            @click="open = false" ref="cancelButtonRef">Close
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
        <div v-if="posts.length > 0" class="bg-white py-12 sm:py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div
                    class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-gray-200 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    <article @click="detail(post)" v-for="post in posts" class="flex max-w-xl flex-col items-start justify-between">
                        <div class="flex items-center gap-x-4 text-xs">
                            <time datetime="2020-03-16" class="text-gray-500">{{ post.created_at }}</time>
                            <span class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600">{{
                                    titleize(post.content_genre)
                                }}</span>
                            <span v-if="!post.public"
                                  class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600">Private</span>
                        </div>
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                <a href="#">
                                    <span class="absolute inset-0"></span>
                                    {{ post.title }}
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">{{
                                    truncate(post.content, 200)
                                }}</p>
                        </div>
                        <div class="relative mt-8 flex items-center gap-x-4">
                            <div class="text-sm leading-6">
                                <p class="font-semibold text-gray-900">
                                    <a href="#">
                                        <span class="absolute inset-0"></span>
                                        {{ post.profile_name }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <div v-else class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
            <div class="text-center">
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-400 sm:text-5xl">No Posts Found</h1>
            </div>
        </div>
    </App>
</template>

<script>
import App from '../../Layouts/App.vue';
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'

export default {
    components: {
        App,
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationTriangleIcon,
    },
    props: {
        posts: Array,
    },
    data() {
        return {
            open: false,
        }
    },
    methods: {
        detail(post) {
            if (!post.public && !post.subscription_paid) {
                this.open = true;
            } else {
                window.location.href = '/app/posts/' + post.id;
            }
        },
        titleize(value) {
            return value.replace(/(?:^|\s|-)\S/g, x => x.toUpperCase());
        },
        truncate(text, length) {
            return text.length > length ? text.slice(0, length) + '...' : text;
        },
    }
}
</script>