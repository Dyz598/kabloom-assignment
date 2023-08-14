<template>
    <App>
        <div v-if="creators.length > 0" class="bg-white py-12 sm:py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <ul role="list" class="divide-y divide-gray-100">
                    <li v-for="creator in creators" :key="creator.email" class="flex justify-between gap-x-6 py-5">
                        <a :href="'/app/creators/' + creator.id">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">{{ creator.name }}</p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ creator.email }}</p>
                                </div>
                            </div>
                        </a>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm leading-6 text-gray-900">
                                <span
                                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                    {{ titleize(creator.content_genre) }}
                                </span>

                                <span v-if="creator.followed"
                                    class="inline-flex ml-2 items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-600 ring-1 ring-inset ring-blue-500/10">
                                    Followed
                                </span>
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div v-else class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
            <div class="text-center">
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-400 sm:text-5xl">No Creators Found</h1>
            </div>
        </div>
    </App>
</template>

<script>
import App from '../../Layouts/App.vue';

export default {
    components: {App},
    props: {
        creators: Array,
    },
    methods: {
        titleize(value){
            return value.replace(/(?:^|\s|-)\S/g, x => x.toUpperCase());
        }
    },
}
</script>