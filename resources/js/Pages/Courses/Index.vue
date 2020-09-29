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
                <div class="py-3" v-for="course in this.courseList" :key="course.id">
                    <div class="bg-white rounded shadow p-4">
                        <div class="text-sm text-gray-500 flex justify-between items-center">
                            <div>
                                Uploaded by <strong>{{ course.user.name }}</strong> (
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
                        <div class="text-sm text-gray-500 mt-2">{{ course.description }}</div>
                        <a :href="'course/' + course.id"
                           class="bg-indigo-700 text-white px-3 py-2 text-sm mt-3 inline-block rounded hover:bg-indigo-500">
                            View more ...
                        </a>
                    </div>
                </div>
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
    }
}
</script>

<style scoped>

</style>
