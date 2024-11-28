<script setup>
import Pizza from './Pizza.vue';
import { Link } from '@inertiajs/vue3';

// Recibir props desde el padre
defineProps({
    pizzas: {
        type: Array,
        required: true,
    },
    isAdmin: {
        type: Boolean,
        required: true, // Recibimos `isAdmin` desde el componente principal
    },
});
</script>

<template>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <div class="flex justify-between">
            <h1 class="mt-3 text-2xl font-medium text-gray-900">
                Menú de pizzas
            </h1>
            <!-- Mostrar botones solo si el usuario es admin -->
            <div v-if="isAdmin" class="flex gap-2">
                <Link
                    class="m-5 p-2 bg-red-800 hover:bg-red-700 rounded-lg"
                    :href="route('pizzas.create')"
                >
                    <p class="text-white">+ Nueva pizza</p>
                </Link>
                <Link
                    class="m-5 p-2 bg-blue-800 hover:bg-blue-700 rounded-lg"
                    :href="route('categorias.index')"
                >
                    <p class="text-white">Categorías</p>
                </Link>
                <Link
                    class="m-5 p-2 bg-green-800 hover:bg-green-700 rounded-lg"
                    :href="route('tamanos.index')"
                >
                    <p class="text-white">Tamaños</p>
                </Link>
            </div>
        </div>

        <div class="flex flex-col lg:grid lg:grid-cols-2 lg:grid-rows-5">
            <Pizza v-for="pizza in pizzas" :key="pizza.id" :pizza="pizza" :isAdmin="isAdmin" />
        </div>
    </div>
</template>
