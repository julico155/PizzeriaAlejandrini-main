<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const searchQuery = ref('');

const performSearch = () => {
    if (searchQuery.value) {
        router.get('/search', { q: searchQuery.value });
    }
};
</script>

<template>
    <div class="flex items-center">
        <input
            v-model="searchQuery"
            type="text"
            placeholder="Buscar..."
            class="border px-4 py-2 rounded-lg"
        />
        <button
            @click="performSearch"
            class="ml-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500"
        >
            Buscar
        </button>
    </div>
</template>
