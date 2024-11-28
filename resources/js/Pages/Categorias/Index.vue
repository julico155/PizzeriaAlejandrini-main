<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    categorias: Array
});
</script>

<template>
    <Head title="Categorías" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Categorías</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center">
                            <h1 class="text-xl font-bold">Lista de Categorías</h1>
                            <Link :href="route('categorias.create')" class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-500">
                                + Nueva Categoría
                            </Link>
                        </div>

                        <table class="w-full mt-4 border-collapse">
                            <thead>
                                <tr>
                                    <th class="border p-2">ID</th>
                                    <th class="border p-2">Nombre</th>
                                    <th class="border p-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in categorias" :key="categoria.id">
                                    <td class="border p-2">{{ categoria.id }}</td>
                                    <td class="border p-2">{{ categoria.nombre }}</td>
                                    <td class="border p-2">
                                        <Link :href="route('categorias.edit', categoria)" class="text-blue-500 hover:underline">Editar</Link>
                                        <Link :href="route('categorias.destroy', categoria)" method="delete" class="text-red-500 hover:underline ml-2">
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
