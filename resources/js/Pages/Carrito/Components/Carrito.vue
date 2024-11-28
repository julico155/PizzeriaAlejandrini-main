<script setup>
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    pedido: {
        type: Object,
        required: false,
        default: null,
    },
    detalles: {
        type: Array,
        required: false,
        default: () => [],
    },
    total: {
        type: Number,
        required: false,
        default: 0,
    },
});

// Temas dinámicos
const themes = [
    { label: 'Claro', value: 'light' },
    { label: 'Oscuro', value: 'dark' },
    { label: 'Niños', value: 'children' },
    { label: 'Jóvenes', value: 'youth' },
    { label: 'Adultos', value: 'adults' },
];

const currentTheme = ref(localStorage.getItem('theme') || 'light');

const setTheme = (theme) => {
    currentTheme.value = theme;
    document.documentElement.className = `theme-${theme}`;
    localStorage.setItem('theme', theme);
};

onMounted(() => {
    setTheme(currentTheme.value);
});

// Checkout y verificación de transacciones
const qr = ref([]);
const nroTransaccion = ref(null);
const estadoPago = ref(null);
let checkInterval = null;

const checkout = async () => {
    try {
        const url = `/carrito/${props.pedido.id}/checkout`;
        const response = await axios.get(url);
        qr.value = response.data.qrText;
        nroTransaccion.value = response.data.nroTransaccion;
        iniciarConsultaEstado();
    } catch (error) {
        console.error('Error en checkout:', error.message);
    }
};

const actualizarEstadoPedido = async () => {
    try {
        await axios.post('/actualizarEstadoPedido', {
            pedido_id: props.pedido.id,
            pedido_estado_id: 4,
            pago_estado_id: 2,
        });
        window.location.href = route('carrito.pagado');
    } catch (error) {
        console.error('Error al actualizar el estado del pedido:', error.message);
    }
};

const consultarEstadoTransaccion = async () => {
    if (!nroTransaccion.value) return;

    try {
        const response = await axios.post('/api/consultartransaccion', {
            tnTransaccion: nroTransaccion.value,
        });
        estadoPago.value = response.data.message.values.EstadoTransaccion;

        if (estadoPago.value === 2) {
            detenerConsultaEstado();
            await actualizarEstadoPedido();
        } else if (estadoPago.value === 4) {
            detenerConsultaEstado();
            alert('La transacción ha vencido. Intenta nuevamente.');
        }
    } catch (error) {
        console.error('Error al consultar el estado de la transacción:', error.message);
    }
};

const iniciarConsultaEstado = () => {
    detenerConsultaEstado();
    checkInterval = setInterval(consultarEstadoTransaccion, 10000);
};

const detenerConsultaEstado = () => {
    if (checkInterval) {
        clearInterval(checkInterval);
        checkInterval = null;
    }
};

onBeforeUnmount(() => {
    detenerConsultaEstado();
});

const del = (detalle) => {
    const form = useForm({ detalle });
    form.delete(route('carrito.destroy', detalle));
};
</script>

<template>
    <div class="p-6 lg:p-8 bg-background border-b border-gray-200 text-text-primary">
        <!-- Selección de tema -->

        <!-- Si no hay pedido -->
        <div v-if="!pedido">
            <h2 class="text-center text-primary">Tu carrito está vacío</h2>
            <p class="text-center mt-4">
                <a href="/pizzas" class="text-blue-500 hover:underline">Explorar productos</a>
            </p>
        </div>

        <!-- Si hay pedido -->
        <div v-else>
            <div class="bg-card-background rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr class="text-primary">
                            <th class="px-3 py-3">Pizza</th>
                            <th class="px-3 py-3">Cantidad</th>
                            <th class="px-3 py-3">Precio Unitario</th>
                            <th class="px-3 py-3">Subtotal</th>
                            <th class="px-3 py-3">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="border-t border-gray-200 text-text-primary"
                            v-for="detalle in detalles"
                            :key="detalle.id"
                        >
                            <td class="px-6 py-4 text-center">{{ detalle.pizza.nombre }}</td>
                            <td class="px-6 py-4 text-center">{{ detalle.cantidad }}</td>
                            <td class="px-6 py-4 text-center">{{ detalle.pizza.precio }} Bs.</td>
                            <td class="px-6 py-4 text-center">{{ detalle.subtotal }} Bs.</td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    @click="del(detalle)"
                                    class="bg-danger hover:bg-danger-hover text-white font-bold py-2 px-4 rounded-full"
                                >
                                    X
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <div class="bg-card-background p-3 rounded-lg">
                    <p>
                        <span class="font-bold">Total:</span>
                        <span>{{ total }} Bs.</span>
                    </p>
                    <div class="p-3" v-if="detalles.length > 0">
                        <button
                            @click="checkout"
                            class="bg-special hover:bg-special-hover p-2 text-white font-bold rounded-lg"
                        >
                            Realizar pedido
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-center" v-if="qr.length > 0">
                <img :src="qr" alt="QR generado">
            </div>
        </div>
    </div>
</template>

<style>
.theme-light .bg-special {
    background-color: #6c63ff;
}

.theme-light .hover\:bg-special-hover:hover {
    background-color: #5a52d4;
}

.theme-dark .bg-special {
    background-color: #4caf50;
}

.theme-dark .hover\:bg-special-hover:hover {
    background-color: #388e3c;
}

/* Colores para otros temas */
.theme-children .bg-special {
    background-color: #ff9800;
}

.theme-children .hover\:bg-special-hover:hover {
    background-color: #f57c00;
}

.theme-youth .bg-special {
    background-color: #ff5722;
}

.theme-youth .hover\:bg-special-hover:hover {
    background-color: #e64a19;
}

.theme-adults .bg-special {
    background-color: #9c27b0;
}

.theme-adults .hover\:bg-special-hover:hover {
    background-color: #7b1fa2;
}
</style>
