<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
});

const submit = () => {
    form.post(route('tamanos.store'));
};
</script>

<template>
    <Head title="Crear Tamaño" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Tamaño</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Nuevo Tamaño</h3>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="nombre" class="block text-sm font-medium text-gray-700">
                                    Nombre del Tamaño
                                </label>
                                <input
                                    id="nombre"
                                    type="text"
                                    v-model="form.nombre"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                    required
                                />
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-500"
                                >
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
