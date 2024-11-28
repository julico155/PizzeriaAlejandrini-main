<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    tamanos: Array,
});
</script>

<template>
    <Head title="Tamaños" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Tamaños</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-100 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Listado de Tamaños</h3>
                            <Link
                                :href="route('tamanos.create')" 
                                class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-500">
                                + Nuevo Tamaño
                            </Link>

                        </div>

                        <table class="table-auto w-full text-left bg-white shadow-lg rounded-lg">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Nombre</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="tamano in tamanos"
                                    :key="tamano.id"
                                    class="border-t border-gray-200 hover:bg-gray-50"
                                >
                                    <td class="px-4 py-2">{{ tamano.id }}</td>
                                    <td class="px-4 py-2">{{ tamano.nombre }}</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <Link
                                            :href="route('tamanos.edit', tamano)"
                                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-500"
                                        >
                                            Editar
                                        </Link>
                                        <Link
                                            :href="route('tamanos.destroy', tamano)"
                                            method="delete"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500"
                                        >
                                            Eliminar
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
