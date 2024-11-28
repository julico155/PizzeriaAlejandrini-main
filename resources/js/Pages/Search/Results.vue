<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const currentTheme = ref(localStorage.getItem('theme') || 'light');
</script>

<template>
    <AuthenticatedLayout>
        <!-- Encabezado de la Página -->
        <template #header>
            <h2 
                class="text-xl font-semibold leading-tight"
                :class="currentTheme === 'dark' ? 'text-white' : 'text-gray-800'"
            >
                Resultados de búsqueda: "{{ $page.props.query }}"
            </h2>
        </template>

        <!-- Contenido Principal -->
        <div :class="`py-12 ${currentTheme === 'dark' ? 'bg-gray-800 text-white' : 'bg-white text-gray-800'}`">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-background shadow-sm sm:rounded-lg p-6">
                    
                    <!-- Usuarios -->
                    <h3 class="font-semibold text-lg mb-4" :class="currentTheme === 'dark' ? 'text-primary' : 'text-gray-800'">
                        Usuarios
                    </h3>
                    <div v-if="$page.props.users.length">
                        <ul>
                            <li 
                                v-for="user in $page.props.users" 
                                :key="user.id"
                                class="p-2 border rounded mb-2"
                                :class="currentTheme === 'dark' ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                            >
                                <span class="font-bold">{{ user.name }}</span> - {{ user.email }}
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <p>No se encontraron usuarios.</p>
                    </div>

                    <!-- Pizzas -->
                    <h3 class="font-semibold text-lg mt-6 mb-4" :class="currentTheme === 'dark' ? 'text-primary' : 'text-gray-800'">
                        Pizzas
                    </h3>
                    <div v-if="$page.props.pizzas.length">
                        <ul>
                            <li 
                                v-for="pizza in $page.props.pizzas" 
                                :key="pizza.id"
                                class="p-2 border rounded mb-2"
                                :class="currentTheme === 'dark' ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                            >
                                <span class="font-bold">{{ pizza.nombre }}</span> - {{ pizza.precio }} Bs.
                                <p>{{ pizza.descripcion }}</p>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <p>No se encontraron pizzas.</p>
                    </div>

                    <!-- Categorías -->
                    <h3 class="font-semibold text-lg mt-6 mb-4" :class="currentTheme === 'dark' ? 'text-primary' : 'text-gray-800'">
                        Categorías
                    </h3>
                    <div v-if="$page.props.categorias.length">
                        <ul>
                            <li 
                                v-for="categoria in $page.props.categorias" 
                                :key="categoria.id"
                                class="p-2 border rounded mb-2"
                                :class="currentTheme === 'dark' ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                            >
                                <span class="font-bold">{{ categoria.nombre }}</span>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <p>No se encontraron categorías.</p>
                    </div>

                    <!-- Métodos de Pago -->
                    <h3 class="font-semibold text-lg mt-6 mb-4" :class="currentTheme === 'dark' ? 'text-primary' : 'text-gray-800'">
                        Métodos de Pago
                    </h3>
                    <div v-if="$page.props.metodosPago.length">
                        <ul>
                            <li 
                                v-for="metodo in $page.props.metodosPago" 
                                :key="metodo.id"
                                class="p-2 border rounded mb-2"
                                :class="currentTheme === 'dark' ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                            >
                                <span class="font-bold">{{ metodo.nombre }}</span>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <p>No se encontraron métodos de pago.</p>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
