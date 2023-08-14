<template>
    <App>
        <div class="bg-white py-12 sm:py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-gray-900">Content Creator Profile</h3>
                </div>
                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div v-if="user.id !== profile.user_id"
                             class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt>
                                <button type="submit" @click="follow" :disabled="followLoading"
                                        :class="{'opacity-50': followLoading}"
                                        class="flex justify-center items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <template v-if="followLoading">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                             xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </template>
                                    <template v-else>
                                        <template v-if="profile.followed">
                                            Unfollow
                                        </template>
                                        <template v-else>
                                            Follow
                                        </template>
                                    </template>
                                </button>
                            </dt>
                            <dd>
                                <button type="submit" @click="subscribe" :disabled="subscribeLoading || profile.subscribed"
                                        :class="{'opacity-50': subscribeLoading || profile.subscribed}"
                                        class="flex justify-center items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <template v-if="subscribeLoading">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                             xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </template>
                                    <template v-else>
                                        <template v-if="profile.subscribed">
                                            Subscribed
                                        </template>
                                        <template v-else>
                                            Subscribe
                                        </template>
                                    </template>
                                </button>
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Name</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                    profile.name
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Content Genre</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                <span
                                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                    {{ titleize(profile.content_genre) }}
                                </span>
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Email</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ profile.email }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Private Content Price</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">IDR
                                {{ formatPrice(profile.subscription_price) }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">About</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                    profile.about
                                }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </App>
</template>

<script>
import App from '../../Layouts/App.vue';

export default {
    components: {App},
    props: {
        profile: Object,
        user: Object,
    },
    data() {
        return {
            followLoading: false,
            subscribeLoading: false,
        };
    },
    methods: {
        titleize(value) {
            return value.replace(/(?:^|\s|-)\S/g, x => x.toUpperCase());
        },
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        follow() {
            this.followLoading = true;

            this.axios.patch('/profiles/' + this.profile.id + '/follow')
                .then(() => {
                    this.profile.followed = !this.profile.followed;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.followLoading = false;
                });
        },
        subscribe() {
            this.subscribeLoading = true;

            this.axios.post('/profiles/' + this.profile.id + '/subscribe')
                .then(response => {
                    window.location.href = response.data.payment_url;
                });
        },
    },
}

</script>