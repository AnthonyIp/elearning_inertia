<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
                    <div class="mb-4">
                        <label for="title" class="block text-sm text-gray-700 font-bold mb-2">
                            Course's title
                        </label>
                        <input id="title"
                               class="rounded shadow appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               v-model="form.title"/>
                        <div class="text-red-600" v-if="$page.errors.title">{{ $page.errors.title[0] }}</div>
                    </div>
                    <label for="description" class="block text-sm text-gray-700 font-bold mb-2">Description</label>
                    <textarea id="description"
                              class="rounded shadow appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              v-model="form.description"></textarea>
                    <div class="text-red-600" v-if="$page.errors.description">{{ $page.errors.description[0] }}</div>

                    <h3 class="mt-3 mb-5">Course's chapter</h3>

                    <div class="text-red-600" v-if="$page.errors.episodes">
                        {{ $page.errors.episodes[0] }}
                    </div>


                    <div v-for="(episode, index) in this.form.episodes" v-bind:key="index">

                        <label for="episode-title-1" class="block text-sm text-gray-700 font-bold mb-2">
                            Chapter's title {{ index + 1 }}
                        </label>
                        <input
                            class="rounded shadow appearance-none w-full py-2 px-3 mb-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :id="'episode-title-' + index" v-model="form.episodes[index].title"/>

                        <div class="text-red-600" v-if="$page.errors['episodes.' + index + '.title']">
                            {{ $page.errors['episodes.' + index + '.title'][0] }}
                        </div>

                        <label :for="'episode-description-' + index" class="block text-sm text-gray-700 font-bold mb-2">
                            Chapter's description {{ index + 1 }}
                        </label>

                        <input
                            class="rounded shadow appearance-none w-full py-2 px-3 mb-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :id="'episode-description-' + index" v-model="form.episodes[index].description"/>

                        <div class="text-red-600" v-if="$page.errors['episodes.' + index + '.description']">
                            {{ $page.errors['episodes.' + index + '.description'][0] }}
                        </div>

                        <label :for="'episode-description-' + index" class="block text-sm text-gray-700 font-bold mb-2">
                            Chapter's video link {{ index + 1 }}
                        </label>
                        <input
                            class="rounded shadow appearance-none w-full py-2 px-3 mb-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :id="'episode-description-' + index" v-model="form.episodes[index].video_url"/>

                        <div class="text-red-600 mb-4" v-if="$page.errors['episodes.' + index + '.video_url']">
                            {{ $page.errors['episodes.' + index + '.video_url'][0] }}
                        </div>

                    </div>
                    <div>
                        <button v-if="form.episodes.length < 15" @click.prevent="add"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold my-3 py-2 px-4 rounded">
                            +
                        </button>
                        <button v-if="form.episodes.length > 1" @click.prevent="remove"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold my-3 py-2 px-4 rounded">
                            -
                        </button>
                    </div>

                    <div>
                        <button type="submit"
                                class="rounded bg-indigo-800 py-2 px-3 mt-3 hover:bg-indigo-600 text-white w-1/5">
                            Save
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from './../Layouts/AppLayout'

export default {
    components: {
        AppLayout
    },

    data() {
        return {
            form: {
                title      : null,
                description: null,
                episodes   : [
                    {title: null, description: null, video_url: null}
                ]
            },
        }
    },

    methods: {
        submit() {
            this.$inertia.post('/courses', this.form);
        },

        add() {
            this.form.episodes.push({title: null, description: null, video_url: null});
        },

        remove() {
            this.form.episodes.pop();
        }
    },
}
</script>
