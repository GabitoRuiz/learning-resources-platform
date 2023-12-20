<script setup>
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, defineProps, ref, watch } from "vue";

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },

    resources: {
        type: Array,
    },

    categories: {
        type: Array,
    },
});

let filteredCategories = ref(null)
let search = ref('');
let filteredResources = ref([]);

watch(filteredCategories, (value => {
    axios.get('/api/resources?category=' + value).then((response) => {
        filteredCategories.value = response.data;
    });
}));

watch(search, (value => {
    axios.get('/api/resources?search=' + value).then((response) => {
        filteredResources.value = response.data;
    });
}));

onMounted(() => {
    filteredResources.value = props.resources;
});

function Votar(ResourceId){
    axios.get("/api/vote/" +  resourceId).then((response) => {

    })
}
</script>

<template>
    <Head title="Hi" />


    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">

            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            Dashboard</Link>

            <template v-else>
                <Link :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Register</Link>


            </template>
        </div>
        <div class="flex justify-center absolute top-10">
            <input type="text" placeholder="Buscar...." v-model="search">
            <select class="w-full px-3 py-2 border rounded-md" v-model="filteredCategories">
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>

        </div>
        <div class="container mx-auto mt-20 p-20 gap-8 grid grid-cols-4">
            <div class="max-w-lg  rounded overflow-hidden shadow-lg bg-white" v-for="resource in filteredResources"
                :key="resource.id">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ resource.title }}</div>
                    <p class="text-gray-700 text-base">
                        {{ resource.link }}
                    </p>
                </div>
                <div class="px-6 py-4">
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{
                            resource.category.name }}</span>
                </div>
                <div class="px-6 py-4">
                    <button @click="Votar(resourceId)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Votar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
