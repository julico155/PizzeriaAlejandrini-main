<script setup>
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    pedido: {
        type: Object,
        required: false, // No obligatorio
        default: null, // Valor predeterminado
    },
    detalles: {
        type: Array,
        required: false,
        default: () => [], // Valor predeterminado vacío
    },
    total: {
        type: Number,
        required: false,
        default: 0, // Total inicial como 0
    },
});


const qr = ref([]); // Texto del QR
const nroTransaccion = ref(null); // Número de la transacción
const estadoPago = ref(null); // Estado del pago
let checkInterval = null; // Intervalo de consulta

const checkout = async () => {
    try {
        const url = `/carrito/${props.pedido.id}/checkout`;
        const response = await axios.get(url);

        // Guardar QR y número de transacción
        qr.value = response.data.qrText;
        nroTransaccion.value = response.data.nroTransaccion;

        console.log('QR generado:', qr.value);
        console.log('Número de Transacción:', nroTransaccion.value);

        // Iniciar el polling para verificar estado
        iniciarConsultaEstado();
    } catch (error) {
        console.error('Error en checkout:', error.message);
    }
};

const actualizarEstadoPedido = async () => {
    try {
        const response = await axios.post('/actualizarEstadoPedido', {
            pedido_id: props.pedido.id, // ID del pedido
            pedido_estado_id: 4, // Pedido completado
            pago_estado_id: 2   // Pago realizado
        });

        console.log('Estado del pedido actualizado:', response.data);

        // Redirigir a la página de "Pagado"
        window.location.href = route('carrito.pagado');
    } catch (error) {
        console.error('Error al actualizar el estado del pedido:', error.message);
    }
};

const consultarEstadoTransaccion = async () => {
    if (!nroTransaccion.value) {
        console.warn('No hay transacción para consultar');
        return;
    }

    try {
        const response = await axios.post('/api/consultartransaccion', {
            tnTransaccion: nroTransaccion.value
        });

        const estado = response.data.message.values.EstadoTransaccion;
        console.log('Estado de la transacción:', estado);

        estadoPago.value = estado;

        // Verificar si el pago está completado
        if (estadoPago.value === 2) {
            console.log('Pago completado. Actualizando estado del pedido...');
            detenerConsultaEstado();
            await actualizarEstadoPedido();
        } else if (estadoPago.value === 4) {
            console.log('La transacción ha vencido.');
            detenerConsultaEstado();
            alert('La transacción ha vencido. Intenta nuevamente.');
        }
    } catch (error) {
        console.error('Error al consultar el estado de la transacción:', error.message);
        detenerConsultaEstado(); // Evitar más solicitudes en caso de error
    }
};


const iniciarConsultaEstado = () => {
    detenerConsultaEstado(); // Detener cualquier intervalo previo
    checkInterval = setInterval(consultarEstadoTransaccion, 10000); // Consultar cada 10 segundos
};

const detenerConsultaEstado = () => {
    if (checkInterval) {
        clearInterval(checkInterval);
        checkInterval = null;
    }
};

// Asegurar limpieza del intervalo al desmontar el componente
onBeforeUnmount(() => {
    detenerConsultaEstado();
});

const del = (detalle) => {
    const form = useForm({
        detalle: detalle
    });

    form.delete(route('carrito.destroy', detalle));
};
</script>

<template>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <!-- Si no hay pedido -->
        <div v-if="!pedido">
            <h2 class="text-center text-gray-700">Tu carrito está vacío</h2>
            <p class="text-center mt-4">
                <a href="/pizzas" class="text-blue-500 hover:underline">Explorar productos</a>
            </p>
        </div>

        <!-- Si hay pedido -->
        <div v-else>
            <div class="bg-gray-200 rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 ">Pizza</th>
                            <th class="px-3 py-3 ">Cantidad</th>
                            <th class="px-3 py-3 ">Precio Unitario</th>
                            <th class="px-3 py-3 ">Subtotal</th>
                            <th class="px-3 py-3 ">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-gray-200" v-for="detalle in detalles" :key="detalle.id">
                            <td class=" px-6 py-4 text-center">{{ detalle.pizza.nombre }}</td>
                            <td class=" px-6 py-4 text-center">{{ detalle.cantidad }}</td>
                            <td class=" px-6 py-4 text-center">{{ detalle.pizza.precio }} Bs.</td>
                            <td class=" px-6 py-4 text-center">{{ detalle.subtotal }} Bs.</td>
                            <td class=" px-6 py-4 text-center">
                                <button
                                    @click="del(detalle)"
                                    class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full"
                                >
                                    X
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <div class="bg-gray-200 p-3 rounded-lg">
                    <p>
                        <span class="font-bold ">Total: </span>
                        <span class="">{{ total }} Bs.</span>
                    </p>
                    <div class="p-3" v-if="detalles.length > 0">
                        <button @click="checkout" class="bg-green-800 p-2 text-white rounded-lg hover:bg-green-600">
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
