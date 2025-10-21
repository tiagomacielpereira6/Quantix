<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">🍔 Gestión de Productos</h1>
              <p class="mt-1 text-sm text-gray-500">
                Administra el inventario de productos del carrito
              </p>
            </div>
            <Link href="/productos/create" 
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
              ➕ Nuevo Producto
            </Link>
          </div>
        </div>
      </div>

      <!-- Mensajes Flash -->
      <div v-if="props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ props.flash.success }}
      </div>
      <div v-if="props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ props.flash.error }}
      </div>

      <!-- Filtros -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="block text-sm font-medium text-gray-700">Buscar producto</label>
            <input type="text" 
                   v-model="filtros.busqueda"
                   @input="filtrarProductos"
                   placeholder="Nombre del producto..."
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Categoría</label>
            <select v-model="filtros.categoria" 
                    @change="filtrarProductos"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
              <option value="">Todas las categorías</option>
              <option value="Comidas">🍔 Comidas</option>
              <option value="Bebidas">🥤 Bebidas</option>
              <option value="Postres">🍰 Postres</option>
              <option value="Snacks">🍿 Snacks</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <select v-model="filtros.estado" 
                    @change="filtrarProductos"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
              <option value="">Todos los estados</option>
              <option value="activo">✅ Activos</option>
              <option value="inactivo">❌ Inactivos</option>
              <option value="disponible">📦 Con Stock</option>
              <option value="bajo">⚠️ Stock Bajo</option>
              <option value="agotado">🚫 Agotado</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tabla de productos -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Producto
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Categoría
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Precio
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Stock
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
            <tr v-for="producto in productosFiltrados" :key="producto.id_producto">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="text-sm font-medium text-gray-900">
                    {{ producto.nombre }}
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getCategoriaClass(producto.categoria)">
                  {{ getCategoriaIcon(producto.categoria) }} {{ producto.categoria || 'Sin categoría' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${{ producto.precio }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ producto.stock }} unidades
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-col space-y-1">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="getStockClass(producto.stock)">
                    {{ getStockStatus(producto.stock) }}
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="getActivoClass(producto.activo)">
                    {{ getActivoStatus(producto.activo) }}
                  </span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <DropdownMenu :trigger-text="`⚙️ Acciones`" button-class="text-xs">
                  <template #items>
                    <DropdownItem
                      :href="`/productos/${producto.id_producto}`"
                      icon="👁️"
                      label="Ver Detalles"
                      description="Información completa del producto"
                    />
                    <DropdownItem
                      :href="`/productos/${producto.id_producto}/edit`"
                      icon="✏️"
                      label="Editar"
                      description="Modificar información del producto"
                      variant="default"
                    />
                    <DropdownSeparator />
                    <DropdownItem
                      @click="mostrarModalToggleActivo(producto)"
                      :icon="producto.activo ? '⏸️' : '▶️'"
                      :label="producto.activo ? 'Desactivar' : 'Activar'"
                      :description="producto.activo ? 'Ocultar producto del menú' : 'Mostrar producto en el menú'"
                      :variant="producto.activo ? 'warning' : 'success'"
                    />
                    <DropdownSeparator />
                    <DropdownItem
                      @click="mostrarModalEliminar(producto)"
                      icon="🗑️"
                      label="Eliminar"
                      description="Eliminar permanentemente (si no tiene pedidos)"
                      variant="danger"
                    />
                  </template>
                </DropdownMenu>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>

  <!-- Modal de confirmación -->
  <ConfirmationModal
    :is-visible="modal.visible"
    :title="modal.title"
    :message="modal.message"
    :additional-info="modal.additionalInfo"
    :icon="modal.icon"
    :variant="modal.variant"
    :confirm-text="modal.confirmText"
    :confirm-icon="modal.confirmIcon"
    @confirm="modal.onConfirm"
    @cancel="cerrarModal"
    @close="cerrarModal"
  />
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '../../layouts/AppLayout.vue';
import DropdownMenu from '../../components/DropdownMenu.vue';
import DropdownItem from '../../components/DropdownItem.vue';
import DropdownSeparator from '../../components/DropdownSeparator.vue';
import ConfirmationModal from '../../components/ConfirmationModal.vue';

// Props del controlador
const props = defineProps({
  productos: {
    type: Array,
    default: () => []
  },
  flash: {
    type: Object,
    default: () => ({})
  }
});

// Filtros reactivos
const filtros = ref({
  busqueda: '',
  categoria: '',
  estado: ''
});

// Modal de confirmación
const modal = ref({
  visible: false,
  title: '',
  message: '',
  additionalInfo: '',
  icon: '',
  variant: 'danger',
  confirmText: 'Confirmar',
  confirmIcon: '✓',
  onConfirm: () => {}
});

// Productos filtrados
const productosFiltrados = computed(() => {
  let productos = props.productos;

  if (filtros.value.busqueda) {
    productos = productos.filter(p => 
      p.nombre.toLowerCase().includes(filtros.value.busqueda.toLowerCase())
    );
  }

  if (filtros.value.categoria) {
    productos = productos.filter(p => p.categoria === filtros.value.categoria);
  }

  if (filtros.value.estado) {
    productos = productos.filter(p => {
      if (filtros.value.estado === 'activo') return p.activo === true;
      if (filtros.value.estado === 'inactivo') return p.activo === false;
      if (filtros.value.estado === 'disponible') return p.stock > 10;
      if (filtros.value.estado === 'bajo') return p.stock <= 10 && p.stock > 0;
      if (filtros.value.estado === 'agotado') return p.stock === 0;
    });
  }

  return productos;
});

// Funciones helper
const getCategoriaClass = (categoria) => {
  const classes = {
    'Comidas': 'bg-orange-100 text-orange-800',
    'Bebidas': 'bg-blue-100 text-blue-800',
    'Postres': 'bg-pink-100 text-pink-800',
    'Snacks': 'bg-yellow-100 text-yellow-800'
  };
  return classes[categoria] || 'bg-gray-100 text-gray-800';
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

const getStockClass = (stock) => {
  if (stock === 0) return 'bg-red-100 text-red-800';
  if (stock <= 10) return 'bg-yellow-100 text-yellow-800';
  return 'bg-green-100 text-green-800';
};

const getStockStatus = (stock) => {
  if (stock === 0) return '❌ Agotado';
  if (stock <= 10) return '⚠️ Stock Bajo';
  return '✅ Disponible';
};

const getActivoClass = (activo) => {
  return activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
};

const getActivoStatus = (activo) => {
  return activo ? '✅ Activo' : '❌ Inactivo';
};

const mostrarModalToggleActivo = (producto) => {
  const accion = producto.activo ? 'desactivar' : 'activar';
  const icono = producto.activo ? '⏸️' : '▶️';
  
  modal.value = {
    visible: true,
    title: `¿${accion.charAt(0).toUpperCase() + accion.slice(1)} producto?`,
    message: `${icono} El producto "${producto.nombre}" será ${producto.activo ? 'ocultado del menú' : 'visible en el menú'}.`,
    additionalInfo: producto.activo ? 
      'El producto mantendrá su stock y podrás reactivarlo cuando quieras.' : 
      'El producto volverá a estar disponible para pedidos.',
    icon: icono,
    variant: producto.activo ? 'warning' : 'success',
    confirmText: accion.charAt(0).toUpperCase() + accion.slice(1),
    confirmIcon: icono,
    onConfirm: () => toggleActivoProducto(producto)
  };
};

const mostrarModalEliminar = (producto) => {
  let additionalInfo = 'Esta acción no se puede deshacer.';
  if (producto.stock > 0) {
    additionalInfo += ` El producto tiene ${producto.stock} unidades en stock.`;
  }
  
  modal.value = {
    visible: true,
    title: '¿Eliminar producto?',
    message: `🗑️ El producto "${producto.nombre}" será eliminado permanentemente del sistema.`,
    additionalInfo: additionalInfo,
    icon: '🗑️',
    variant: 'danger',
    confirmText: 'Eliminar',
    confirmIcon: '🗑️',
    onConfirm: () => eliminarProducto(producto)
  };
};

const toggleActivoProducto = (producto) => {
  router.patch(`/productos/${producto.id_producto}/toggle-activo`);
  cerrarModal();
};

const eliminarProducto = (producto) => {
  router.delete(`/productos/${producto.id_producto}`);
  cerrarModal();
};

const cerrarModal = () => {
  modal.value.visible = false;
};

const filtrarProductos = () => {
  // Esta función se ejecuta automáticamente por el computed
};
</script>