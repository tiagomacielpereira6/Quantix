<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">🏪 {{ proveedor.nombre }}</h1>
              <p class="mt-1 text-sm text-gray-500">
                Información detallada del proveedor
              </p>
            </div>
            <div class="flex space-x-3">
              <Link href="/proveedores" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Volver a Lista
              </Link>
              <Link :href="`/proveedores/${proveedor.id_proveedor}/edit`" 
                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ✏️ Editar
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información del proveedor -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Datos básicos -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">📋 Información Básica</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Nombre de la Empresa</dt>
                  <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ proveedor.nombre }}</dd>
                </div>
                <div v-if="proveedor.contacto">
                  <dt class="text-sm font-medium text-gray-500">Persona de Contacto</dt>
                  <dd class="mt-1 text-sm text-gray-900">👤 {{ proveedor.contacto }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                  <dd class="mt-1 text-sm text-gray-900">📞 {{ proveedor.telefono }}</dd>
                </div>
                <div v-if="proveedor.correo">
                  <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                  <dd class="mt-1 text-sm text-gray-900">📧 {{ proveedor.correo }}</dd>
                </div>
                <div v-if="proveedor.direccion" class="sm:col-span-2">
                  <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                  <dd class="mt-1 text-sm text-gray-900">📍 {{ proveedor.direccion }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Registrado</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ formatFecha(proveedor.created_at) }}</dd>
                </div>
              </dl>
            </div>
          </div>

          <!-- Últimas compras -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">📦 Últimas Compras</h3>
              <p class="mt-1 text-sm text-gray-500">Historial reciente de compras</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <div v-if="proveedor.compras && proveedor.compras.length > 0" class="flow-root">
                <ul class="-my-5 divide-y divide-gray-200">
                  <li v-for="compra in proveedor.compras" :key="compra.id_compra" class="py-5">
                    <div class="flex items-center space-x-4">
                      <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                          <span class="text-lg">📦</span>
                        </div>
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">
                          Compra #{{ compra.id_compra }}
                        </p>
                        <p class="text-sm text-gray-500">
                          {{ formatFecha(compra.fecha_compra) }}
                        </p>
                        <p class="text-xs text-gray-400">
                          {{ compra.detalle_compras?.length || 0 }} productos diferentes
                        </p>
                      </div>
                      <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">
                          ${{ compra.total }}
                        </p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div v-else class="text-center py-8">
                <div class="text-gray-500">
                  <span class="text-4xl block mb-2">📦</span>
                  <p class="text-lg font-medium">Sin compras registradas</p>
                  <p class="text-sm">Aún no se han realizado compras a este proveedor</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Estadísticas -->
        <div class="lg:col-span-1 space-y-6">
          <!-- Resumen estadístico -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">📊 Estadísticas</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <dl class="space-y-4">
                <div class="flex justify-between">
                  <dt class="text-sm text-gray-500">Total Compras:</dt>
                  <dd class="text-sm font-medium text-gray-900">{{ estadisticas.total_compras }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-gray-500">Monto Total:</dt>
                  <dd class="text-sm font-medium text-green-600">${{ estadisticas.monto_total?.toFixed(2) || '0.00' }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-gray-500">Promedio por Compra:</dt>
                  <dd class="text-sm font-medium text-gray-900">${{ estadisticas.promedio_compra?.toFixed(2) || '0.00' }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-gray-500">Productos Diferentes:</dt>
                  <dd class="text-sm font-medium text-gray-900">{{ estadisticas.productos_suministrados }}</dd>
                </div>
                <div v-if="estadisticas.ultima_compra" class="border-t pt-4">
                  <dt class="text-sm text-gray-500">Última Compra:</dt>
                  <dd class="text-sm font-medium text-gray-900 mt-1">{{ formatFecha(estadisticas.ultima_compra) }}</dd>
                </div>
              </dl>
            </div>
          </div>

          <!-- Estado del proveedor -->
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">🎯 Estado</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <div class="text-center">
                <div class="mb-4">
                  <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                        :class="getEstadoClass()">
                    {{ getEstadoText() }}
                  </span>
                </div>
                
                <div class="space-y-3">
                  <div class="text-sm">
                    <div class="flex justify-between mb-1">
                      <span class="text-gray-600">Actividad:</span>
                      <span class="font-medium">{{ getNivelActividad() }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div class="h-2 rounded-full transition-all"
                           :class="getBarraActividadClass()"
                           :style="`width: ${getPorcentajeActividad()}%`"></div>
                    </div>
                  </div>
                </div>

                <div class="mt-4 pt-4 border-t">
                  <button @click="eliminarProveedor"
                          class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md font-medium text-sm">
                    🗑️ Eliminar Proveedor
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

const props = defineProps({
  proveedor: Object,
  estadisticas: Object
});

const formatFecha = (fecha) => {
  return new Date(fecha).toLocaleString('es-AR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const getEstadoClass = () => {
  const compras = props.estadisticas.total_compras;
  if (compras === 0) return 'bg-gray-100 text-gray-800';
  if (compras >= 10) return 'bg-green-100 text-green-800';
  if (compras >= 5) return 'bg-yellow-100 text-yellow-800';
  return 'bg-blue-100 text-blue-800';
};

const getEstadoText = () => {
  const compras = props.estadisticas.total_compras;
  if (compras === 0) return '⚪ Sin actividad';
  if (compras >= 10) return '🟢 Muy activo';
  if (compras >= 5) return '🟡 Activo';
  return '🔵 Poco activo';
};

const getNivelActividad = () => {
  const compras = props.estadisticas.total_compras;
  if (compras === 0) return 'Sin compras';
  if (compras >= 10) return 'Muy alto';
  if (compras >= 5) return 'Alto';
  return 'Bajo';
};

const getPorcentajeActividad = () => {
  const compras = props.estadisticas.total_compras;
  return Math.min(compras * 10, 100); // Cada compra = 10%, máximo 100%
};

const getBarraActividadClass = () => {
  const compras = props.estadisticas.total_compras;
  if (compras >= 10) return 'bg-green-500';
  if (compras >= 5) return 'bg-yellow-500';
  if (compras > 0) return 'bg-blue-500';
  return 'bg-gray-300';
};

const eliminarProveedor = () => {
  const mensaje = props.estadisticas.total_compras > 0 
    ? `¿Eliminar proveedor "${props.proveedor.nombre}"? Este proveedor tiene ${props.estadisticas.total_compras} compras asociadas.`
    : `¿Eliminar proveedor "${props.proveedor.nombre}"? Esta acción no se puede deshacer.`;
    
  if (confirm(mensaje)) {
    router.delete(`/proveedores/${props.proveedor.id_proveedor}`);
  }
};
</script>