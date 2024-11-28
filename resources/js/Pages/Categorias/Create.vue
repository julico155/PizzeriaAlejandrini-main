<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: ''
});

const submit = () => {
    form.post(route('categorias.store'));
};
</script>

<template>
    <Head title="Crear Categoría" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Categoría</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-xl font-bold mb-4">Crear Nueva Categoría</h1>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label for="nombre" class="block font-bold">Nombre</label>
                                <input
                                    id="nombre"
                                    v-model="form.nombre"
                                    type="text"
                                    class="border rounded p-2 w-full"
                                    placeholder="Nombre de la categoría"
                                />
                                <div v-if="form.errors.nombre" class="text-red-500 text-sm">{{ form.errors.nombre }}</div>
                            </div>

                            <button
                                type="submit"
                                class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-500"
                                :disabled="form.processing"
                            >
                                Guardar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
