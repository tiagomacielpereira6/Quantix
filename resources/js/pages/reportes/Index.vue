<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">📊 Reportes y Análisis</h1>
              <p class="mt-1 text-sm text-gray-500">
                Dashboard completo de ventas y estadísticas
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filtros de fecha -->
      <div class="bg-white shadow rounded-lg p-4">
        <form @submit.prevent="filtrarReportes" class="flex items-end space-x-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Fecha inicio</label>
            <input type="date" 
                   v-model="filtros.fecha_inicio"
                   style="color: #111827 !important; background-color: white !important;"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Fecha fin</label>
            <input type="date" 
                   v-model="filtros.fecha_fin"
                   style="color: #111827 !important; background-color: white !important;"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
          <button type="submit" 
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            📈 Generar Reporte
          </button>
          <button type="button" 
                  @click="setFiltroRapido"
                  class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            🔄 Último Mes
          </button>
        </form>
        <p class="text-sm text-gray-500 mt-2">
          Período actual: {{ formatFecha(periodo.fecha_inicio) }} - {{ formatFecha(periodo.fecha_fin) }}
        </p>
      </div>

      <!-- Botones de descarga PDF -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-medium text-gray-900">📄 Descargar Reportes PDF</h3>
          <div class="text-sm text-gray-500">
            Genera reportes profesionales en formato PDF
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Reporte de Ventas -->
          <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
            <div class="flex items-center space-x-3 mb-3">
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                  <span class="text-white text-lg">📊</span>
                </div>
              </div>
              <div>
                <h4 class="text-sm font-medium text-gray-900">Reporte de Ventas</h4>
                <p class="text-xs text-gray-600">Análisis completo de ventas y rendimiento</p>
              </div>
            </div>
            <button @click="descargarReporteVentas" 
                    :disabled="generandoPDF.ventas"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center space-x-2">
              <span v-if="generandoPDF.ventas">⏳</span>
              <span v-else>📥</span>
              <span>{{ generandoPDF.ventas ? 'Generando...' : 'Descargar PDF' }}</span>
            </button>
          </div>

          <!-- Reporte de Inventario -->
          <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
            <div class="flex items-center space-x-3 mb-3">
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                  <span class="text-white text-lg">📦</span>
                </div>
              </div>
              <div>
                <h4 class="text-sm font-medium text-gray-900">Reporte de Inventario</h4>
                <p class="text-xs text-gray-600">Estado actual del stock y productos</p>
              </div>
            </div>
            <button @click="descargarReporteInventario" 
                    :disabled="generandoPDF.inventario"
                    class="w-full bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center space-x-2">
              <span v-if="generandoPDF.inventario">⏳</span>
              <span v-else>📥</span>
              <span>{{ generandoPDF.inventario ? 'Generando...' : 'Descargar PDF' }}</span>
            </button>
          </div>

          <!-- Reporte de Clientes -->
          <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
            <div class="flex items-center space-x-3 mb-3">
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                  <span class="text-white text-lg">👥</span>
                </div>
              </div>
              <div>
                <h4 class="text-sm font-medium text-gray-900">Reporte de Clientes</h4>
                <p class="text-xs text-gray-600">Análisis de clientela y segmentación</p>
              </div>
            </div>
            <button @click="descargarReporteClientes" 
                    :disabled="generandoPDF.clientes"
                    class="w-full bg-purple-600 hover:bg-purple-700 disabled:bg-purple-400 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center space-x-2">
              <span v-if="generandoPDF.clientes">⏳</span>
              <span v-else>📥</span>
              <span>{{ generandoPDF.clientes ? 'Generando...' : 'Descargar PDF' }}</span>
            </button>
          </div>
        </div>

        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
          <div class="flex items-center space-x-2">
            <span class="text-yellow-600">💡</span>
            <p class="text-sm text-yellow-800">
              <strong>Tip:</strong> Los reportes se generan con los datos del período seleccionado arriba. 
              Ajusta las fechas antes de descargar para obtener la información que necesitas.
            </p>
          </div>
        </div>
      </div>

      <!-- Estadísticas generales -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">💰</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Ventas</dt>
                  <dd class="text-lg font-medium text-gray-900">${{ formatMoney(estadisticasGenerales.total_ventas) }}</dd>
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
                  <span class="text-white font-semibold">📦</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Pedidos</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ estadisticasGenerales.total_pedidos || 0 }}</dd>
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
                  <span class="text-white font-semibold">🎯</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Ticket Promedio</dt>
                  <dd class="text-lg font-medium text-gray-900">${{ formatMoney(estadisticasGenerales.ticket_promedio) }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">✅</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Tasa Completado</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ calcularTasaCompletado() }}%</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Gráficos y tablas -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ventas por día -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900">📈 Ventas por Día</h3>
          </div>
          <div class="px-4 py-5 sm:p-6">
            <div class="space-y-3">
              <div v-for="venta in ventasPorDia" :key="venta.fecha" 
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                  <div class="text-sm font-medium text-gray-900">{{ formatFecha(venta.fecha) }}</div>
                  <div class="text-xs text-gray-500">{{ venta.pedidos }} pedidos</div>
                </div>
                <div class="text-right">
                  <div class="text-sm font-bold text-green-600">${{ formatMoney(venta.ventas) }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Productos más vendidos -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900">🏆 Top Productos</h3>
          </div>
          <div class="px-4 py-5 sm:p-6">
            <div class="space-y-3">
              <div v-for="(producto, index) in productosTop" :key="index" 
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                  <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full text-xs font-medium"
                          :class="getRankingClass(index)">
                      {{ index + 1 }}
                    </span>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ producto.nombre }}</div>
                    <div class="text-xs text-gray-500">{{ producto.categoria }}</div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-sm font-bold text-blue-600">{{ producto.cantidad_vendida }} ud.</div>
                  <div class="text-xs text-gray-500">${{ formatMoney(producto.ingresos_total) }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Clientes top -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900">👥 Mejores Clientes</h3>
          </div>
          <div class="px-4 py-5 sm:p-6">
            <div class="space-y-3">
              <div v-for="(cliente, index) in clientesTop" :key="index" 
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                  <div class="flex-shrink-0 h-8 w-8">
                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                      <span class="text-purple-600 font-medium text-xs">
                        {{ cliente.nombre.charAt(0).toUpperCase() }}
                      </span>
                    </div>
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ cliente.nombre }}</div>
                    <div class="text-xs text-gray-500">{{ cliente.total_pedidos }} pedidos</div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-sm font-bold text-green-600">${{ formatMoney(cliente.total_gastado) }}</div>
                  <div class="text-xs text-gray-500">Prom: ${{ formatMoney(cliente.promedio_pedido) }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Ventas por categoría -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900">🍔 Ventas por Categoría</h3>
          </div>
          <div class="px-4 py-5 sm:p-6">
            <div class="space-y-3">
              <div v-for="categoria in ventasPorCategoria" :key="categoria.categoria" 
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                  <span class="text-lg">{{ getCategoriaIcon(categoria.categoria) }}</span>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ categoria.categoria }}</div>
                    <div class="text-xs text-gray-500">{{ categoria.cantidad_vendida }} productos</div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-sm font-bold text-green-600">${{ formatMoney(categoria.ingresos) }}</div>
                  <div class="text-xs text-gray-500">{{ categoria.pedidos_categoria }} pedidos</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Stock bajo -->
      <div v-if="stockBajo.length > 0" class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 bg-red-50">
          <h3 class="text-lg leading-6 font-medium text-red-900">⚠️ Stock Bajo (Menos de 10 unidades)</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div v-for="producto in stockBajo" :key="producto.id_producto" 
                 class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
              <div>
                <div class="text-sm font-medium text-gray-900">{{ producto.nombre }}</div>
                <div class="text-xs text-gray-500">{{ producto.categoria }} - ${{ producto.precio }}</div>
              </div>
              <div class="text-right">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                  {{ producto.stock }} unidades
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

const props = defineProps({
  periodo: {
    type: Object,
    default: () => ({ fecha_inicio: '', fecha_fin: '' })
  },
  estadisticas_generales: {
    type: Object,
    default: () => ({
      total_ventas: 0,
      total_pedidos: 0,
      pedidos_completados: 0,
      pedidos_cancelados: 0,
      ticket_promedio: 0,
      total_productos: 0,
      total_clientes: 0,
      total_proveedores: 0
    })
  },
  ventas_por_dia: {
    type: Array,
    default: () => []
  },
  productos_top: {
    type: Array,
    default: () => []
  },
  clientes_top: {
    type: Array,
    default: () => []
  },
  ventas_por_categoria: {
    type: Array,
    default: () => []
  },
  ventas_por_hora: {
    type: Array,
    default: () => []
  },
  stock_bajo: {
    type: Array,
    default: () => []
  }
});

// Renombrar props para mayor claridad con valores por defecto
const periodo = props.periodo || { fecha_inicio: '', fecha_fin: '' };
const estadisticasGenerales = props.estadisticas_generales || {
  total_ventas: 0,
  total_pedidos: 0,
  pedidos_completados: 0,
  pedidos_cancelados: 0,
  ticket_promedio: 0
};
const ventasPorDia = props.ventas_por_dia || [];
const productosTop = props.productos_top || [];
const clientesTop = props.clientes_top || [];
const ventasPorCategoria = props.ventas_por_categoria || [];
const stockBajo = props.stock_bajo || [];

// Filtros reactivos
const filtros = ref({
  fecha_inicio: periodo.fecha_inicio || new Date(new Date().setMonth(new Date().getMonth() - 1)).toISOString().split('T')[0],
  fecha_fin: periodo.fecha_fin || new Date().toISOString().split('T')[0]
});

// Estados de carga para PDFs
const generandoPDF = ref({
  ventas: false,
  inventario: false,
  clientes: false
});

// Funciones
const formatFecha = (fecha) => {
  return new Date(fecha).toLocaleDateString('es-AR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  });
};

const formatMoney = (value) => {
  if (value === null || value === undefined) return '0.00';
  const num = parseFloat(value);
  return isNaN(num) ? '0.00' : num.toFixed(2);
};

const calcularTasaCompletado = () => {
  if (!estadisticasGenerales || !estadisticasGenerales.total_pedidos || estadisticasGenerales.total_pedidos === 0) {
    return '0.0';
  }
  const completados = estadisticasGenerales.pedidos_completados || 0;
  const total = estadisticasGenerales.total_pedidos || 1;
  return ((completados / total) * 100).toFixed(1);
};

const getRankingClass = (index) => {
  if (index === 0) return 'bg-yellow-500 text-white';
  if (index === 1) return 'bg-gray-400 text-white';
  if (index === 2) return 'bg-orange-600 text-white';
  return 'bg-blue-100 text-blue-800';
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

const filtrarReportes = () => {
  if (!filtros.value.fecha_inicio || !filtros.value.fecha_fin) {
    alert('Por favor selecciona ambas fechas');
    return;
  }
  
  if (new Date(filtros.value.fecha_inicio) > new Date(filtros.value.fecha_fin)) {
    alert('La fecha de inicio no puede ser mayor que la fecha fin');
    return;
  }
  
  console.log('Enviando filtros:', filtros.value);
  router.post('/reportes/filtrar', filtros.value, {
    onError: (errors) => {
      console.error('Error al filtrar reportes:', errors);
    },
    onSuccess: () => {
      console.log('Reportes filtrados exitosamente');
    }
  });
};

const setFiltroRapido = () => {
  const hoy = new Date();
  const unMesAtras = new Date();
  unMesAtras.setMonth(hoy.getMonth() - 1);
  
  filtros.value.fecha_inicio = unMesAtras.toISOString().split('T')[0];
  filtros.value.fecha_fin = hoy.toISOString().split('T')[0];
  
  filtrarReportes();
};

// Funciones para descargar PDFs
const descargarReporteVentas = () => {
  if (generandoPDF.value.ventas) return;
  
  generandoPDF.value.ventas = true;
  
  const params = new URLSearchParams({
    fecha_inicio: filtros.value.fecha_inicio,
    fecha_fin: filtros.value.fecha_fin
  });
  
  const url = `/reportes/ventas/pdf?${params.toString()}`;
  
  // Crear enlace temporal para descarga
  const link = document.createElement('a');
  link.href = url;
  link.download = `reporte-ventas-${filtros.value.fecha_inicio}-${filtros.value.fecha_fin}.pdf`;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  
  // Reset estado después de un momento
  setTimeout(() => {
    generandoPDF.value.ventas = false;
  }, 2000);
};

const descargarReporteInventario = () => {
  if (generandoPDF.value.inventario) return;
  
  generandoPDF.value.inventario = true;
  
  const url = '/reportes/inventario/pdf';
  
  // Crear enlace temporal para descarga
  const link = document.createElement('a');
  link.href = url;
  link.download = `reporte-inventario-${new Date().toISOString().split('T')[0]}.pdf`;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  
  // Reset estado después de un momento
  setTimeout(() => {
    generandoPDF.value.inventario = false;
  }, 2000);
};

const descargarReporteClientes = () => {
  if (generandoPDF.value.clientes) return;
  
  generandoPDF.value.clientes = true;
  
  const url = '/reportes/clientes/pdf';
  
  // Crear enlace temporal para descarga
  const link = document.createElement('a');
  link.href = url;
  link.download = `reporte-clientes-${new Date().toISOString().split('T')[0]}.pdf`;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  
  // Reset estado después de un momento
  setTimeout(() => {
    generandoPDF.value.clientes = false;
  }, 2000);
};
</script>