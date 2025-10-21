<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">📦 Pedido #{{ pedido.id_pedido }}</h1>
              <p class="mt-1 text-sm text-gray-500">
                Creado el {{ formatFecha(pedido.fecha_hora) }}
              </p>
            </div>
            <div class="flex space-x-3">
              <Link href="/pedidos" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Volver a Pedidos
              </Link>
              <button v-if="pedido.estado === 'pendiente'"
                      @click="completarPedido"
                      class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ✅ Completar Pedido
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información del pedido -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Información del cliente -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">👤 Información del Cliente</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ pedido.cliente.nombre }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ pedido.cliente.telefono }}</dd>
                </div>
                <div v-if="pedido.cliente.correo">
                  <dt class="text-sm font-medium text-gray-500">Correo</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ pedido.cliente.correo }}</dd>
                </div>
              </dl>
            </div>
          </div>

          <!-- Productos del pedido -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">🍔 Productos del Pedido</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <div class="flow-root">
                <ul class="-my-5 divide-y divide-gray-200">
                  <li v-for="detalle in pedido.detalle_pedidos" :key="detalle.id_detalle" 
                      class="py-5">
                    <div class="flex items-center space-x-4">
                      <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                          <span class="text-lg">{{ getCategoriaIcon(detalle.producto.categoria) }}</span>
                        </div>
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                          {{ detalle.producto.nombre }}
                        </p>
                        <p class="text-sm text-gray-500">
                          {{ detalle.producto.categoria }}
                        </p>
                        <p class="text-xs text-gray-400">
                          ${{ detalle.precio_unitario }} × {{ detalle.cantidad }} unidades
                        </p>
                      </div>
                      <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">
                          ${{ detalle.subtotal }}
                        </p>
                        <p class="text-xs text-gray-500">
                          {{ detalle.cantidad }} ud.
                        </p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Resumen y estado -->
        <div class="lg:col-span-1 space-y-6">
          <!-- Estado del pedido -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">📊 Estado del Pedido</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <div class="text-center">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                      :class="getEstadoClass(pedido.estado)">
                  {{ getEstadoText(pedido.estado) }}
                </span>
                <div class="mt-4">
                  <div v-if="pedido.estado === 'pendiente'" class="space-y-2">
                    <button @click="completarPedido"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">
                      ✅ Marcar como Completado
                    </button>
                    <button @click="cancelarPedido"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md font-medium">
                      ❌ Cancelar Pedido
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Resumen financiero -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">💰 Resumen</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <dl class="space-y-3">
                <div class="flex justify-between">
                  <dt class="text-sm text-gray-500">Subtotal:</dt>
                  <dd class="text-sm font-medium text-gray-900">${{ calcularSubtotal() }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-gray-500">Items:</dt>
                  <dd class="text-sm font-medium text-gray-900">{{ pedido.detalle_pedidos.length }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-gray-500">Cantidad total:</dt>
                  <dd class="text-sm font-medium text-gray-900">{{ calcularCantidadTotal() }} unidades</dd>
                </div>
                <div class="border-t border-gray-200 pt-3">
                  <div class="flex justify-between">
                    <dt class="text-base font-medium text-gray-900">Total:</dt>
                    <dd class="text-base font-bold text-green-600">${{ pedido.total }}</dd>
                  </div>
                </div>
              </dl>
            </div>
          </div>

          <!-- Timeline del pedido -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">⏱️ Timeline</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <div class="flow-root">
                <ul class="-mb-8">
                  <li>
                    <div class="relative pb-8">
                      <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                          <span class="text-white text-xs">📝</span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5">
                          <div>
                            <p class="text-sm text-gray-500">
                              Pedido creado el <span class="font-medium text-gray-900">{{ formatFecha(pedido.fecha_hora) }}</span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  
                  <li v-if="pedido.estado === 'completado'">
                    <div class="relative pb-8">
                      <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                          <span class="text-white text-xs">✅</span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5">
                          <div>
                            <p class="text-sm text-gray-500">
                              Pedido <span class="font-medium text-green-600">completado</span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li v-if="pedido.estado === 'cancelado'">
                    <div class="relative">
                      <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                          <span class="text-white text-xs">❌</span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5">
                          <div>
                            <p class="text-sm text-gray-500">
                              Pedido <span class="font-medium text-red-600">cancelado</span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Confirmación -->
    <Teleport to="body">
      <div v-if="mostrarModal" 
           class="fixed inset-0 z-[9999] overflow-y-auto"
           style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
           aria-labelledby="modal-title" 
           role="dialog" 
           aria-modal="true">
        
        <!-- Overlay con backdrop blur mejorado -->
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
          <div @click="cerrarModal"
               class="fixed inset-0 transition-opacity duration-300"
               style="background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
               aria-hidden="true"></div>

          <!-- Modal Panel con mejor posicionamiento -->
          <div class="relative inline-block bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 scale-100 max-w-lg w-full mx-4"
               style="animation: modalSlideIn 0.3s ease-out;">
            
            <!-- Contenido del Modal -->
            <div class="bg-white px-6 pt-6 pb-4">
              <!-- Icono y Título -->
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                  <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    Completar Pedido
                  </h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-700 leading-5">
                      ¿Estás seguro que deseas marcar como <span class="font-semibold text-green-600">completado</span> el pedido 
                      <span class="font-semibold text-gray-900">#{{ pedido.id_pedido }}</span>?
                    </p>
                    
                    <!-- Detalles del pedido con mejor spacing -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg border">
                      <div class="space-y-2 text-sm text-gray-800">
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Cliente:</span>
                          <span class="font-semibold">{{ pedido.cliente?.nombre || 'Sin cliente' }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Total:</span>
                          <span class="font-semibold text-green-600">${{ pedido.total }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Items:</span>
                          <span class="font-semibold">{{ pedido.detalle_pedidos?.length || 0 }} productos</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Cantidad:</span>
                          <span class="font-semibold">{{ calcularCantidadTotal() }} unidades</span>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="mt-4 p-3 bg-green-50 border-l-4 border-green-400 rounded-r-lg">
                      <p class="text-sm text-green-800">
                        ✅ Una vez completado, el pedido será marcado como entregado y aparecerá en el historial.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Botones del Modal -->
            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
              <button @click="confirmarCompletar"
                      type="button" 
                      class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-3 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105">
                ✅ Sí, Completar Pedido
              </button>
              <button @click="cerrarModal"
                      type="button" 
                      class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105">
                ❌ Cancelar
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- Modal de Cancelación -->
    <Teleport to="body">
      <div v-if="mostrarModalCancelar" 
           class="fixed inset-0 z-[9999] overflow-y-auto"
           style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
           aria-labelledby="modal-title-cancel" 
           role="dialog" 
           aria-modal="true">
        
        <!-- Overlay con backdrop blur mejorado -->
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
          <div @click="cerrarModalCancelar"
               class="fixed inset-0 transition-opacity duration-300"
               style="background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
               aria-hidden="true"></div>

          <!-- Modal Panel con mejor posicionamiento -->
          <div class="relative inline-block bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 scale-100 max-w-lg w-full mx-4"
               style="animation: modalSlideIn 0.3s ease-out;">
            
            <!-- Contenido del Modal -->
            <div class="bg-white px-6 pt-6 pb-4">
              <!-- Icono y Título -->
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title-cancel">
                    Cancelar Pedido
                  </h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-700 leading-5">
                      ¿Estás seguro que deseas <span class="font-semibold text-red-600">cancelar</span> el pedido 
                      <span class="font-semibold text-gray-900">#{{ pedido.id_pedido }}</span>?
                    </p>
                    
                    <!-- Detalles del pedido con mejor spacing -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg border">
                      <div class="space-y-2 text-sm text-gray-800">
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Cliente:</span>
                          <span class="font-semibold">{{ pedido.cliente?.nombre || 'Sin cliente' }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Total:</span>
                          <span class="font-semibold text-red-600">${{ pedido.total }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Items:</span>
                          <span class="font-semibold">{{ pedido.detalle_pedidos?.length || 0 }} productos</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Cantidad:</span>
                          <span class="font-semibold">{{ calcularCantidadTotal() }} unidades</span>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Información adicional sobre la cancelación -->
                    <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
                      <p class="text-sm text-red-800">
                        ⚠️ Al cancelar este pedido, se restaurará automáticamente el stock de todos los productos.
                      </p>
                    </div>
                    
                    <div class="mt-3 p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
                      <p class="text-sm text-yellow-800">
                        💡 Esta acción no se puede deshacer. El pedido aparecerá marcado como cancelado en el historial.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Botones del Modal -->
            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
              <button @click="confirmarCancelar"
                      type="button" 
                      class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-3 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105">
                ❌ Sí, Cancelar Pedido
              </button>
              <button @click="cerrarModalCancelar"
                      type="button" 
                      class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105">
                🔄 Mantener Pedido
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>

  </AppLayout>
</template>

<script setup>
import { ref, Teleport } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

const props = defineProps({
  pedido: Object
});

// Modal de confirmación
const mostrarModal = ref(false);

// Modal de cancelación
const mostrarModalCancelar = ref(false);

const formatFecha = (fecha) => {
  return new Date(fecha).toLocaleString('es-AR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const getCategoriaIcon = (categoria) => {
  const icons = {
    'Comidas': '🍔',
    'Bebidas': '🥤',
    'Postres': '🍰',
    'Snacks': '🍿'
  };
  return icons[categoria] || '📦';
};

const getEstadoClass = (estado) => {
  const classes = {
    'pendiente': 'bg-yellow-100 text-yellow-800',
    'completado': 'bg-green-100 text-green-800',
    'cancelado': 'bg-red-100 text-red-800'
  };
  return classes[estado] || 'bg-gray-100 text-gray-800';
};

const getEstadoText = (estado) => {
  const textos = {
    'pendiente': '⏳ Pendiente',
    'completado': '✅ Completado',
    'cancelado': '❌ Cancelado'
  };
  return textos[estado] || estado;
};

const calcularSubtotal = () => {
  return props.pedido.detalle_pedidos.reduce((sum, detalle) => 
    sum + parseFloat(detalle.subtotal), 0
  ).toFixed(2);
};

const calcularCantidadTotal = () => {
  return props.pedido.detalle_pedidos.reduce((sum, detalle) => 
    sum + parseInt(detalle.cantidad), 0
  );
};

const completarPedido = () => {
  mostrarModal.value = true;
};

const confirmarCompletar = () => {
  router.put(`/pedidos/${props.pedido.id_pedido}`, { estado: 'completado' });
  cerrarModal();
};

const cerrarModal = () => {
  mostrarModal.value = false;
};

const cancelarPedido = () => {
  mostrarModalCancelar.value = true;
};

const confirmarCancelar = () => {
  router.put(`/pedidos/${props.pedido.id_pedido}`, { estado: 'cancelado' });
  cerrarModalCancelar();
};

const cerrarModalCancelar = () => {
  mostrarModalCancelar.value = false;
};
</script>

<style scoped>
@keyframes modalSlideIn {
  from {
    opacity: 0;
    transform: scale(0.95) translateY(-10px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

/* Mejoras para el backdrop blur */
.backdrop-blur {
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
}

/* Animaciones adicionales */
button {
  transition: all 0.2s ease-in-out;
}

button:hover {
  transform: translateY(-1px);
}

button:active {
  transform: translateY(0);
}
</style>