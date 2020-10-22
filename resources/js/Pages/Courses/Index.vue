<template>
    <app-layout>
        <template #header>
            Courses list
        </template>
        <section class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.flash.success" class="bg-green-200 text-green-600 p-4">
                    {{ $page.flash.success }}
                </div>
                <div class="py-3" v-for="course in this.courseList.data" :key="course.id">
                    <div class="bg-white rounded shadow p-4">
                        <div class="text-sm text-gray-500 flex justify-between items-center">
                            <div>
                                Created by <strong>{{ course.user.name }}</strong> (
                                <span class="text-gray-500 text-sm">
                            {{ course.participants }} student<span
                                    v-if="parseInt(course.participants) > 1 ">s</span>
                            enrolled)
                        </span>
                            </div>
                            <span class="block text-sm text-gray-400">
                        {{ course.episodes_count }} chapter<span v-if="course.episodes_count > 1">s</span>
                    </span>
                        </div>
                        <h1 class="text-3xl">{{ course.title }}</h1>
                        <span class="font-semibold text-gray-500">{{ convert(course.total_duration) }}</span>
                        <div class="text-sm text-gray-500 mt-2">{{ course.description }}</div>
                        <div class="flex items-center justify-between">
                            <a :href="'course/' + course.id"
                               class="bg-indigo-700 text-white px-3 py-2 text-sm mt-3 inline-block rounded hover:bg-indigo-500">
                                View more ...
                            </a>
                            <a :href="'courses/edit/' + course.id" v-if="course.update"
                               class="bg-green-700 text-white px-3 py-2 text-sm mt-3 inline-block rounded hover:bg-indigo-500">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                <inertia-link :href="link.url" class="text-indigo-700 border-gray-500 p-5 text-center"
                              v-for="link in courses.links" v-bind:key="link.label">
                    <span v-bind:class="{'text-red-700' : link.active}">{{ link.label }}</span>
                </inertia-link>
            </div>
        </section>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";

export default {
    components: {
        AppLayout
    },
    props     : ['courses'],
    data() {
        return {
            courseList: this.courses
        }
    },
    methods   : {
        convert(timestamps) {
            let hours = Math.floor(timestamps / 3600);
            let minutes = Math.floor(timestamps / 60) - (hours * 60);
            let seconds = timestamps % 60;
            return hours.toString().padStart(2, 0) + ':' + minutes.toString().padStart(2, 0) + ':' + seconds.toString().padStart(2, 0);
        }
    }
}
</script>

<style scoped>

</style>
