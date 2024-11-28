<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VisitasFooter from '@/Components/VisitasFooter.vue';
import PizzaSearch from './Components/PizzaSearch.vue';
import Pizzas from './Components/Pizzas.vue';
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';

const currentTheme = ref(localStorage.getItem('theme') || 'light');

const props = defineProps({
    pizzas: {
        type: Array,
        required: true
    },
    visitas: {
        type: Object,
        required: true
    },
    isAdmin: {
        type: Boolean,
        required: true, // Recibimos `isAdmin` desde el componente principal
    },
});

const pizzaList = ref([]);

onMounted(() => {
    pizzaList.value = props.pizzas;
    document.documentElement.className = `theme-${currentTheme.value}`;
});

const searchPizzas = (search) => {
    pizzaList.value = props.pizzas.filter(pizza =>
        pizza.nombre.toLowerCase().includes(search.toLowerCase()) ||
        pizza.descripcion.toLowerCase().includes(search.toLowerCase()) ||
        pizza.tamano.toLowerCase().includes(search.toLowerCase()) ||
        pizza.categoria.toLowerCase().includes(search.toLowerCase())
    );
};

</script>

<template>
    <Head title="Pizzas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-primary bg-primary px-4 py-2 rounded">
                Pizzas
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-card-background shadow-sm sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-background border-b border-gray-200">
                        <h3 class="font-semibold text-lg text-primary bg-primary px-4 py-2 rounded">
                            Menú de pizzas
                        </h3>
                        <PizzaSearch @searchPizzas="searchPizzas" />
                        <Pizzas :pizzas="pizzas" :isAdmin="$page.props.auth.user.is_admin" />
                    </div>
                </div>
            </div>
        </div>

        <VisitasFooter :visitas="visitas.cant" />
    </AuthenticatedLayout>
</template>
