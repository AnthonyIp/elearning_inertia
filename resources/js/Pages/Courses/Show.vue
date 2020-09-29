<template>
    <app-layout>
        <template #header>
            {{ course.title }}
        </template>
        <div class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8">
            <div class="text-3xl mb-3">{{ this.courseShow.episodes[this.currentKey].title }}</div>
            <iframe class="w-full h-screen" :src="this.courseShow.episodes[this.currentKey].video_url" frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            <div class="text-sm text-gray-500 my-3">{{ this.courseShow.episodes[this.currentKey].description }}</div>
            <div class="py-6">
                <progress-bar :watched-episodes="watched" :episodes="course.episodes"/>
            </div>
            <div class="mt-6">
                <ul v-for="(episode, index) in course.episodes" v-bind:key="episode.id">
                    <li class="mt-3 flex justify-between items-center">
                        <div>
                            Chapter n°{{ index + 1 }} - {{ episode.title }}
                            <button class="text-gray-500 focus:text-indigo-500 focus:outline-none"
                                    @click="switchEpisode(index)">
                                Click to see
                            </button>
                        </div>
                        <progress-button :episode-id="episode.id" :watched-episodes="watched"/>
                    </li>
                </ul>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout      from "../../Layouts/AppLayout";
import ProgressBar    from "./ProgressBar";
import ProgressButton from "./ProgressButton";

export default {
    name      : "show",
    components: {
        AppLayout,
        ProgressButton,
        ProgressBar
    },
    props     : ['course', 'watched'],
    data() {
        return {
            courseShow: this.course,
            currentKey: 0,
        }
    },
    methods   : {
        switchEpisode(index) {
            this.currentKey = index;
            window.scrollTo({
                top     : 0,
                left    : 0,
                behavior: 'smooth'
            })
        }
    },
    mounted() {
        // console.log(this.course)
    }

}
</script>

<style scoped>

</style>
