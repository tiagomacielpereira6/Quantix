<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">➕ Nuevo Pedido</h1>
              <p class="mt-1 text-sm text-gray-500">
                Crear un nuevo pedido para un cliente
              </p>
            </div>
            <Link href="/pedidos" 
                  class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
              ← Volver a Pedidos
            </Link>
          </div>
        </div>
      </div>

      <!-- Formulario -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Selección de cliente y productos -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Cliente -->
          <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">👤 Seleccionar Cliente</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Cliente *</label>
                <div class="mb-2">
                  <select v-model="form.id_cliente" 
                          required
                          style="color: #000 !important;"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                          :class="{ 'border-red-500': errors.id_cliente }">
                    <option value="" disabled style="color: #666 !important;">Seleccionar cliente</option>
                    <template v-for="cliente in (clientes || [])" :key="cliente.id_cliente">
                      <option :value="cliente.id_cliente" style="color: #000 !important;">
                        {{ cliente.nombre }} - {{ cliente.telefono }}
                      </option>
                    </template>
                  </select>
                </div>
                
                <div v-if="!clientes || clientes.length === 0" class="mt-1 text-sm text-red-600">
                  No hay clientes disponibles
                </div>
                <div v-if="errors.id_cliente" class="mt-1 text-sm text-red-600">
                  {{ errors.id_cliente }}
                </div>
              </div>
              <div class="flex items-end">
                <Link href="/clientes/create" 
                      class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm">
                  + Nuevo Cliente
                </Link>
              </div>
            </div>
          </div>

          <!-- Productos disponibles -->
          <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">🍔 Productos Disponibles</h3>
            
            <!-- Búsqueda de productos -->
            <div class="mb-4">
              <input type="text" 
                     v-model="busquedaProducto"
                     placeholder="Buscar producto..."
                     style="color: #111827 !important; background-color: white !important;"
                     class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Lista de productos -->
            <div v-if="!productos || productos.length === 0" class="text-center py-8 text-gray-500">
              No hay productos con stock disponible
            </div>
            <div v-else class="mb-2 text-sm text-gray-600">
              {{ productosFiltrados.length }} productos disponibles de {{ productos.length }} total
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto">
              <div v-for="producto in productosFiltrados" :key="producto.id_producto"
                   class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                <div class="flex justify-between items-start">
                  <div class="flex-1">
                    <h4 class="text-sm font-medium text-gray-900">{{ producto.nombre }}</h4>
                    <p class="text-xs text-gray-500">{{ producto.categoria }}</p>
                    <p class="text-sm font-bold text-green-600">${{ producto.precio }}</p>
                    <p class="text-xs text-gray-400">Stock: {{ producto.stock }}</p>
                  </div>
                  <button @click="agregarProducto(producto)"
                          class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                    + Agregar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Resumen del pedido -->
        <div class="lg:col-span-1">
          <div class="bg-white shadow rounded-lg p-6 sticky top-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">📋 Resumen del Pedido</h3>
            
            <div v-if="form.items.length === 0" class="text-center py-8">
              <p class="text-gray-500">No hay productos agregados</p>
              <p class="text-sm text-gray-400">Selecciona productos de la lista</p>
            </div>

            <div v-else class="space-y-3">
              <div v-for="(item, index) in form.items" :key="index"
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex-1">
                  <h5 class="text-sm font-medium text-gray-900">{{ item.nombre }}</h5>
                  <p class="text-xs text-gray-500">${{ item.precio_unitario }} c/u</p>
                  <div class="flex items-center mt-1">
                    <button @click="decrementarCantidad(index)"
                            class="bg-red-500 hover:bg-red-600 text-white w-6 h-6 rounded text-xs">
                      -
                    </button>
                    <span class="mx-2 text-sm font-medium text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ item.cantidad || 0 }}</span>
                    <button @click="incrementarCantidad(index)"
                            class="bg-green-500 hover:bg-green-600 text-white w-6 h-6 rounded text-xs">
                      +
                    </button>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-bold">${{ (item.cantidad * item.precio_unitario).toFixed(2) }}</p>
                  <button @click="eliminarItem(index)"
                          class="text-red-600 hover:text-red-800 text-xs">
                    🗑️ Eliminar
                  </button>
                </div>
              </div>

              <!-- Total -->
              <div class="border-t pt-3">
                <div class="flex justify-between items-center">
                  <span class="text-lg font-bold text-gray-900">Total:</span>
                  <span class="text-xl font-bold text-green-600">${{ calcularTotal() }}</span>
                </div>
              </div>

              <!-- Botón crear pedido -->
              <button @click="crearPedido"
                      :disabled="!form.id_cliente || form.items.length === 0 || processing"
                      class="w-full bg-green-600 hover:bg-green-700 disabled:bg-gray-400 text-white py-3 px-4 rounded-lg font-medium transition-colors">
                <span v-if="processing">Creando pedido...</span>
                <span v-else>🛒 Crear Pedido</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '../../layouts/AppLayout.vue';

const props = defineProps({
  clientes: {
    type: Array,
    default: () => []
  },
  productos: {
    type: Array,
    default: () => []
  },
  errors: {
    type: Object,
    default: () => ({})
  }
});

const form = useForm({
  id_cliente: '',
  items: []
});

const busquedaProducto = ref('');
const processing = ref(false);

// Productos filtrados por búsqueda
const productosFiltrados = computed(() => {
  const productos = props.productos || [];
  if (!busquedaProducto.value) return productos;
  
  return productos.filter(producto =>
    producto.nombre.toLowerCase().includes(busquedaProducto.value.toLowerCase()) ||
    producto.categoria.toLowerCase().includes(busquedaProducto.value.toLowerCase())
  );
});

const agregarProducto = (producto) => {
  // Verificar si el producto ya está en el pedido
  const existeIndex = form.items.findIndex(item => item.id_producto === producto.id_producto);
  
  if (existeIndex >= 0) {
    // Si ya existe, incrementar cantidad
    form.items[existeIndex].cantidad++;
  } else {
    // Si no existe, agregarlo
    form.items.push({
      id_producto: producto.id_producto,
      nombre: producto.nombre,
      precio_unitario: producto.precio,
      cantidad: 1
    });
  }
};

const incrementarCantidad = (index) => {
  const item = form.items[index];
  const producto = (props.productos || []).find(p => p.id_producto === item.id_producto);
  
  if (producto && item.cantidad < producto.stock) {
    item.cantidad++;
  } else {
    alert(`Stock máximo disponible: ${producto?.stock || 0}`);
  }
};

const decrementarCantidad = (index) => {
  if (form.items[index].cantidad > 1) {
    form.items[index].cantidad--;
  }
};

const eliminarItem = (index) => {
  form.items.splice(index, 1);
};

const calcularTotal = () => {
  return form.items.reduce((total, item) => {
    return total + (item.cantidad * item.precio_unitario);
  }, 0).toFixed(2);
};

const crearPedido = () => {
  if (!form.id_cliente) {
    alert('Por favor selecciona un cliente');
    return;
  }
  
  if (form.items.length === 0) {
    alert('Por favor agrega al menos un producto');
    return;
  }

  processing.value = true;
  
  form.post('/pedidos', {
    onSuccess: () => {
      processing.value = false;
    },
    onError: () => {
      processing.value = false;
    }
  });
};
</script>