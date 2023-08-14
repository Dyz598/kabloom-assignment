<template>
    <header class="bg-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="/app" class="-m-1.5 p-1.5">
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                         alt=""/>
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                        @click="mobileMenuOpen = true">
                    <Bars3Icon class="h-6 w-6" aria-hidden="true"/>
                </button>
            </div>

            <PopoverGroup class="hidden lg:flex lg:gap-x-12">
                <a href="/app/posts" class="text-sm font-semibold leading-6 text-gray-900">Posts</a>
                <a href="/app/creators" class="text-sm font-semibold leading-6 text-gray-900">Creators</a>
            </PopoverGroup>

            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <PopoverGroup class="hidden lg:flex lg:gap-x-12">
                    <Popover class="relative">
                        <PopoverButton class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900">
                            Account
                            <ChevronDownIcon class="h-5 w-5 flex-none text-gray-400" aria-hidden="true"/>
                        </PopoverButton>

                        <transition enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 translate-y-1"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 translate-y-1">
                            <PopoverPanel
                                class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-xs overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                <div>
                                    <template v-if="null !== this.user?.profile">
                                        <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                            <div class="flex-auto">
                                                <a href="/app/create-post" class="block font-semibold text-gray-900">
                                                    Post
                                                    <span class="absolute inset-0"/>
                                                </a>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                            <div class="flex-auto">
                                                <a href="/app/register-creator" class="block font-semibold text-gray-900">
                                                    Register as Content Creator
                                                    <span class="absolute inset-0"/>
                                                </a>
                                            </div>
                                        </div>
                                    </template>
                                    <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                        <div class="flex-auto">
                                            <a href="/logout" class="block font-semibold text-gray-900">
                                                Sign Out
                                                <span class="absolute inset-0"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </PopoverPanel>
                        </transition>
                    </Popover>
                </PopoverGroup>
            </div>
        </nav>
        <Dialog as="div" class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
            <div class="fixed inset-0 z-10"/>
            <DialogPanel
                class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="/app" class="-m-1.5 p-1.5">
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                             alt=""/>
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = false">
                        <XMarkIcon class="h-6 w-6" aria-hidden="true"/>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="#"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Posts</a>
                            <a href="#"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Creators</a>
                            <template v-if="null !== this.user?.profile">
                                <a href="/app/create-post"
                                   class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Post</a>
                            </template>
                            <template v-else>
                                <a href="/app/register-creator"
                                   class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Register as Content Creator</a>
                            </template>
                        </div>
                        <div class="py-6">
                            <a href="/logout"
                               class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Sign Out</a>
                        </div>
                    </div>
                </div>
            </DialogPanel>
        </Dialog>
    </header>
    <main>
        <slot></slot>
    </main>
</template>

<script>
import {
    Dialog,
    DialogPanel,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue';
import {
    Bars3Icon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import {ChevronDownIcon} from '@heroicons/vue/20/solid';

export default {
    components: {
        Dialog,
        DialogPanel,
        Popover,
        PopoverButton,
        PopoverGroup,
        PopoverPanel,
        Bars3Icon,
        XMarkIcon,
        ChevronDownIcon
    },
    data() {
        return {
            user: null,
            mobileMenuOpen: false,
        };
    },
    mounted() {
        this.axios.get('/auth/me')
            .then(response => {
                this.user = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
}
</script>