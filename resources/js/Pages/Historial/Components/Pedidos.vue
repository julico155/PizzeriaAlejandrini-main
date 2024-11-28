<script setup>
defineProps({
    pedidos: {
        type: Array,
        required: true
    }
});
</script>
<template>
    <div class="p-6 lg:p-8 bg-background border-b border-gray-200 text-text-primary">
        <div class="bg-card-background rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="text-primary bg-header-background">
                        <th class="px-3 py-3">#</th>
                        <th class="px-3 py-3">Fecha</th>
                        <th class="px-3 py-3">Total</th>
                        <th class="px-3 py-3">Método de pago</th>
                        <th class="px-3 py-3">Estado</th>
                        <th class="px-3 py-3">Estado del pago</th>
                        <th class="px-3 py-3">Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="border-t border-gray-200 hover:bg-hover-background transition duration-200 text-row-text"
                        v-for="pedido in pedidos"
                        :key="pedido.id"
                    >
                        <td class="px-6 py-4 text-center">{{ pedido.id }}</td>
                        <td class="px-6 py-4 text-center">{{ pedido.fecha_literal }}</td>
                        <td class="px-6 py-4 text-center">{{ pedido.total }}</td>
                        <td class="px-6 py-4 text-center">{{ pedido.pago_metodo.nombre }}</td>
                        <td class="px-6 py-4 text-center">{{ pedido.pedido_estado.nombre }}</td>
                        <td class="px-6 py-4 text-center">{{ pedido.pago_estado.nombre }}</td>
                        <td class="px-6 py-4 text-center">
                            <button
                                class="bg-primary hover:bg-primary-hover text-white font-bold py-2 px-4 rounded-full"
                                @click="$emit('showDetalles', {
                                    detalles: pedido.detalles,
                                    total: pedido.total
                                })"
                            >
                                Ver
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style>
/* Estilos para temas claros */
.theme-light .bg-background {
    background-color: #ffffff;
}

.theme-light .bg-card-background {
    background-color: #f9f9f9;
}

.theme-light .text-primary {
    color: #333333;
}

.theme-light .bg-header-background {
    background-color: #e5e5e5;
}

.theme-light .text-row-text {
    color: #333333;
}

.theme-light .hover\:bg-hover-background:hover {
    background-color: #f1f1f1;
}

.theme-light .bg-primary {
    background-color: #007bff;
}

.theme-light .hover\:bg-primary-hover:hover {
    background-color: #0056b3;
}

/* Estilos para temas oscuros */
.theme-dark .bg-background {
    background-color: #121212;
}

.theme-dark .bg-card-background {
    background-color: #1f1f1f;
}

.theme-dark .text-primary {
    color: #e0e0e0;
}

.theme-dark .bg-header-background {
    background-color: #292929;
}

.theme-dark .text-row-text {
    color: #e0e0e0;
}

.theme-dark .hover\:bg-hover-background:hover {
    background-color: #333333;
}

.theme-dark .bg-primary {
    background-color: #4caf50;
}

.theme-dark .hover\:bg-primary-hover:hover {
    background-color: #388e3c;
}

/* Estilos adicionales para otros temas */
.theme-children .bg-primary {
    background-color: #ff9800;
}

.theme-children .hover\:bg-primary-hover:hover {
    background-color: #f57c00;
}

.theme-youth .bg-primary {
    background-color: #ff5722;
}

.theme-youth .hover\:bg-primary-hover:hover {
    background-color: #e64a19;
}

.theme-adults .bg-primary {
    background-color: #9c27b0;
}

.theme-adults .hover\:bg-primary-hover:hover {
    background-color: #7b1fa2;
}
</style>
