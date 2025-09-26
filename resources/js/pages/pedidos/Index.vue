<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">📦 Gestión de Pedidos</h1>
              <p class="mt-1 text-sm text-gray-500">
                Administra todos los pedidos del carrito
              </p>
            </div>
            <Link href="/pedidos/create" 
                  class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
              ➕ Nuevo Pedido
            </Link>
          </div>
        </div>
      </div>

      <!-- Filtros -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Cliente</label>
            <input type="text" 
                   v-model="filtros.cliente"
                   placeholder="Nombre del cliente..."
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <select v-model="filtros.estado" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
              <option value="">Todos los estados</option>
              <option value="pendiente">⏳ Pendiente</option>
              <option value="completado">✅ Completado</option>
              <option value="cancelado">❌ Cancelado</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Fecha desde</label>
            <input type="date" 
                   v-model="filtros.fechaDesde"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Fecha hasta</label>
            <input type="date" 
                   v-model="filtros.fechaHasta"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
        </div>
      </div>

      <!-- Estadísticas rápidas -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">⏳</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Pendientes</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ pedidosPendientes }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">✅</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Completados</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ pedidosCompletados }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">📊</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Hoy</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ pedidosHoy }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">💰</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Ventas Hoy</dt>
                  <dd class="text-lg font-medium text-gray-900">${{ ventasHoy }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla de pedidos -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Pedido
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Cliente
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Fecha/Hora
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Estado
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="pedido in pedidosFiltrados" :key="pedido.id_pedido">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                  #{{ pedido.id_pedido }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ pedido.detalle_pedidos?.length || 0 }} items
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                  {{ pedido.cliente?.nombre }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ pedido.cliente?.telefono }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ formatFecha(pedido.fecha_hora) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                ${{ pedido.total }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getEstadoClass(pedido.estado)">
                  {{ getEstadoText(pedido.estado) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <DropdownMenu 
                  :trigger-text="`📋 Gestionar`" 
                  button-class="text-xs"
                  :class="getDropdownColorClass(pedido.estado)"
                >
                  <template #items>
                    <DropdownItem
                      :href="`/pedidos/${pedido.id_pedido}`"
                      icon="👁️"
                      label="Ver Detalles"
                      description="Información completa del pedido"
                    />
                    <DropdownItem
                      :href="`/pedidos/${pedido.id_pedido}/edit`"
                      icon="✏️"
                      label="Editar"
                      description="Modificar productos del pedido"
                      :disabled="pedido.estado !== 'pendiente'"
                    />
                    
                    <DropdownSeparator v-if="pedido.estado === 'pendiente'" />
                    
                    <DropdownItem
                      v-if="pedido.estado === 'pendiente'"
                      @confirm="confirmarCompletar(pedido)"
                      icon="✅"
                      label="Completar Pedido"
                      description="Marcar como completado y facturar"
                      variant="success"
                      :needs-confirmation="true"
                      confirmation-title="¿Completar pedido?"
                      :confirmation-message="`Pedido #${pedido.id_pedido} será marcado como completado. Esta acción genera la facturación.`"
                      confirm-button-text="✅ Completar"
                    />
                    <DropdownItem
                      v-if="pedido.estado === 'pendiente'"
                      @confirm="confirmarCancelar(pedido)"
                      icon="❌"
                      label="Cancelar Pedido"
                      description="Cancelar y restaurar stock"
                      variant="danger"
                      :needs-confirmation="true"
                      confirmation-title="¿Cancelar pedido?"
                      :confirmation-message="`⚠️ El pedido #${pedido.id_pedido} se cancelará y se restaurará el stock automáticamente.`"
                      confirm-button-text="❌ Cancelar"
                    />
                    
                    <DropdownSeparator />
                    
                    <!-- Opciones de PDF -->
                    <DropdownItem
                      @click="descargarTicketPedido(pedido)"
                      icon="🎫"
                      label="Ticket del Pedido"
                      description="Generar ticket para el cliente"
                      variant="default"
                    />
                    <DropdownItem
                      @click="descargarTicketCocina(pedido)"
                      icon="👨‍🍳"
                      label="Ticket de Cocina"
                      description="Orden de preparación para cocina"
                      variant="info"
                    />
                    <DropdownItem
                      v-if="pedido.estado === 'completado'"
                      @click="descargarReciboPago(pedido)"
                      icon="🧾"
                      label="Recibo de Pago"
                      description="Comprobante fiscal del pago"
                      variant="success"
                    />
                  </template>
                </DropdownMenu>
              </td>
            </tr>
          </tbody>
        </table>
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
                      <span class="font-semibold text-gray-900">#{{ pedidoSeleccionado?.id_pedido }}</span>?
                    </p>
                    
                    <!-- Detalles del pedido con mejor spacing -->
                    <div v-if="pedidoSeleccionado" class="mt-4 p-4 bg-gray-50 rounded-lg border">
                      <div class="space-y-2 text-sm text-gray-800">
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Cliente:</span>
                          <span class="font-semibold">{{ pedidoSeleccionado.cliente?.nombre || 'Sin cliente' }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Total:</span>
                          <span class="font-semibold text-green-600">${{ pedidoSeleccionado.total }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Items:</span>
                          <span class="font-semibold">{{ pedidoSeleccionado.detalle_pedidos?.length || 0 }} productos</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Fecha:</span>
                          <span class="font-semibold">{{ formatFecha(pedidoSeleccionado.fecha_hora) }}</span>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="mt-4 p-3 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg">
                      <p class="text-sm text-blue-800">
                        ℹ️ Una vez completado, el pedido será marcado como entregado y aparecerá en el historial.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Botones del Modal -->
            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
              <button @click="confirmarCompletarModal"
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
                      <span class="font-semibold text-gray-900">#{{ pedidoCancelar?.id_pedido }}</span>?
                    </p>
                    
                    <!-- Detalles del pedido con mejor spacing -->
                    <div v-if="pedidoCancelar" class="mt-4 p-4 bg-gray-50 rounded-lg border">
                      <div class="space-y-2 text-sm text-gray-800">
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Cliente:</span>
                          <span class="font-semibold">{{ pedidoCancelar.cliente?.nombre || 'Sin cliente' }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Total:</span>
                          <span class="font-semibold text-red-600">${{ pedidoCancelar.total }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Items:</span>
                          <span class="font-semibold">{{ pedidoCancelar.detalle_pedidos?.length || 0 }} productos</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-medium text-gray-600">Fecha:</span>
                          <span class="font-semibold">{{ formatFecha(pedidoCancelar.fecha_hora) }}</span>
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
              <button @click="confirmarCancelarModal"
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
import { Link, router } from '@inertiajs/vue3';
import { ref, computed, Teleport } from 'vue';
import AppLayout from '../../layouts/AppLayout.vue';
import DropdownMenu from '../../components/DropdownMenu.vue';
import DropdownItem from '../../components/DropdownItem.vue';
import DropdownSeparator from '../../components/DropdownSeparator.vue';

const props = defineProps({
  pedidos: {
    type: Array,
    default: () => []
  }
});

// Filtros reactivos
const filtros = ref({
  cliente: '',
  estado: '',
  fechaDesde: '',
  fechaHasta: ''
});

// Modal de confirmación
const mostrarModal = ref(false);
const pedidoSeleccionado = ref(null);

// Modal de cancelación
const mostrarModalCancelar = ref(false);
const pedidoCancelar = ref(null);

// Pedidos filtrados
const pedidosFiltrados = computed(() => {
  let pedidos = props.pedidos;

  if (filtros.value.cliente) {
    pedidos = pedidos.filter(p => 
      p.cliente?.nombre.toLowerCase().includes(filtros.value.cliente.toLowerCase())
    );
  }

  if (filtros.value.estado) {
    pedidos = pedidos.filter(p => p.estado === filtros.value.estado);
  }

  if (filtros.value.fechaDesde) {
    pedidos = pedidos.filter(p => 
      new Date(p.fecha_hora) >= new Date(filtros.value.fechaDesde)
    );
  }

  if (filtros.value.fechaHasta) {
    pedidos = pedidos.filter(p => 
      new Date(p.fecha_hora) <= new Date(filtros.value.fechaHasta + ' 23:59:59')
    );
  }

  return pedidos;
});

// Estadísticas calculadas
const pedidosPendientes = computed(() => 
  props.pedidos.filter(p => p.estado === 'pendiente').length
);

const pedidosCompletados = computed(() => 
  props.pedidos.filter(p => p.estado === 'completado').length
);

const pedidosHoy = computed(() => {
  const hoy = new Date().toISOString().split('T')[0];
  return props.pedidos.filter(p => 
    p.fecha_hora.startsWith(hoy)
  ).length;
});

const ventasHoy = computed(() => {
  const hoy = new Date().toISOString().split('T')[0];
  return props.pedidos.filter(p => 
    p.fecha_hora.startsWith(hoy) && p.estado === 'completado'
  ).reduce((sum, p) => sum + parseFloat(p.total), 0).toFixed(2);
});

// Funciones helper
const getEstadoClass = (estado) => {
  const classes = {
    'pendiente': 'bg-yellow-100 text-yellow-800',
    'completado': 'bg-green-100 text-green-800',
    'cancelado': 'bg-red-100 text-red-800'
  };
  return classes[estado] || 'bg-gray-100 text-gray-800';
};

const getDropdownColorClass = (estado) => {
  const classes = {
    'pendiente': 'border-yellow-300 text-yellow-700',
    'completado': 'border-green-300 text-green-700',
    'cancelado': 'border-red-300 text-red-700'
  };
  return classes[estado] || 'border-gray-300 text-gray-700';
};

const imprimirRecibo = (pedido) => {
  // Por ahora solo un alert, después se puede implementar
  alert(`🖨️ Imprimiendo recibo del pedido #${pedido.id_pedido}`);
};

const getEstadoText = (estado) => {
  const textos = {
    'pendiente': '⏳ Pendiente',
    'completado': '✅ Completado',
    'cancelado': '❌ Cancelado'
  };
  return textos[estado] || estado;
};

const formatFecha = (fecha) => {
  return new Date(fecha).toLocaleString('es-AR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const completarPedido = (pedido) => {
  pedidoSeleccionado.value = pedido;
  mostrarModal.value = true;
};

// Nueva función para confirmación desde dropdown
const confirmarCompletar = (pedido) => {
  router.put(`/pedidos/${pedido.id_pedido}`, { estado: 'completado' });
};

// Función original para modal (mantener compatibilidad)
const confirmarCompletarModal = () => {
  if (pedidoSeleccionado.value) {
    router.put(`/pedidos/${pedidoSeleccionado.value.id_pedido}`, { estado: 'completado' });
  }
  cerrarModal();
};

const cerrarModal = () => {
  mostrarModal.value = false;
  pedidoSeleccionado.value = null;
};

const cancelarPedido = (pedido) => {
  pedidoCancelar.value = pedido;
  mostrarModalCancelar.value = true;
};

// Nueva función para confirmación desde dropdown
const confirmarCancelar = (pedido) => {
  router.put(`/pedidos/${pedido.id_pedido}`, { estado: 'cancelado' });
};

// Función original para modal (mantener compatibilidad)
const confirmarCancelarModal = () => {
  if (pedidoCancelar.value) {
    router.put(`/pedidos/${pedidoCancelar.value.id_pedido}`, { estado: 'cancelado' });
  }
  cerrarModalCancelar();
};

const cerrarModalCancelar = () => {
  mostrarModalCancelar.value = false;
  pedidoCancelar.value = null;
};

// Funciones de descarga de PDF
const descargarTicketPedido = (pedido) => {
  const url = `/pedidos/${pedido.id_pedido}/ticket`;
  const link = document.createElement('a');
  link.href = url;
  link.download = `ticket-pedido-${pedido.id_pedido}.pdf`;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const descargarReciboPago = (pedido) => {
  const url = `/pedidos/${pedido.id_pedido}/recibo`;
  const link = document.createElement('a');
  link.href = url;
  link.download = `recibo-pago-${pedido.id_pedido}.pdf`;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const descargarTicketCocina = (pedido) => {
  const url = `/pedidos/${pedido.id_pedido}/cocina`;
  const link = document.createElement('a');
  link.href = url;
  link.download = `ticket-cocina-${pedido.id_pedido}.pdf`;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
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