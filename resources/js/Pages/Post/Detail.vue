<template>
    <App>
        <div class="bg-white py-12 sm:py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-gray-900">{{ post.title }}</h3>
                </div>
                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ post.content }}
                            </dd>
                        </div>

                    </dl>
                </div>
            </div>
        </div>
    </App>
</template>

<script>
import App from "../../Layouts/App.vue";

export default {
    components: {App},
    props: {
        post: Object,
    },
}
</script>