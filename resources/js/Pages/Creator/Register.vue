<template>
    <App>
        <div class="bg-white py-12 sm:py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <form @submit.prevent="register">
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Register Content Creator Profile</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">This information will display your profile and what kind of content you will make.</p>

                            <div v-if="error" class="mt-10 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2"
                                 role="alert">
                                <span class="block sm:inline">{{ error }}</span>
                            </div>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="col-span-full">
                                    <label for="about" class="block text-sm font-medium leading-6 text-gray-900">About</label>
                                    <div class="mt-2">
                                        <textarea v-model="about" id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about yourself.</p>
                                </div>
                            </div>

                            <div class="sm:col-span-3 mt-5">
                                <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Genre</label>
                                <div class="mt-2">
                                    <select v-model="content_genre" id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                        <option value="education">Education</option>
                                        <option value="news">News</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-4 mt-5">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Subscription Price</label>
                                <div class="mt-2">
                                    <input v-model="subscription_price" id="email" name="email" type="number" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="submit" class="flex justify-center items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <template v-if="loading">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Registering...
                            </template>
                            <template v-else>
                                Register
                            </template>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </App>
</template>

<script>
import App from '../../Layouts/App.vue';

export default {
    components: {App},
    data() {
        return {
            loading: false,
            about: null,
            content_genre: null,
            subscription_price: null,
            error: null,
        };
    },
    methods: {
        register() {
            this.loading = true;
            this.error = null;
            let payload = {
                about: this.about,
                content_genre: this.content_genre,
                subscription_price: this.subscription_price,
            };

            this.axios.post('/profiles/register', payload)
                .then(() => {
                    window.location.href = '/app/register-creator-success';
                })
                .catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message;
                });
        }
    },
}
</script>