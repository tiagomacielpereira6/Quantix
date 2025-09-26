<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">➕ Nuevo Producto</h1>
              <p class="mt-1 text-sm text-gray-500">
                Agrega un nuevo producto al inventario
              </p>
            </div>
            <Link href="/productos" 
                  class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
              ← Volver a Productos
            </Link>
          </div>
        </div>
      </div>

      <!-- Formulario -->
      <div class="bg-white shadow rounded-lg">
        <form @submit.prevent="submit" class="space-y-6 p-6">
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Nombre -->
            <div>
              <label for="nombre" class="block text-sm font-medium text-gray-700">
                Nombre del Producto *
              </label>
              <input
                id="nombre"
                v-model="form.nombre"
                type="text"
                required
                style="color: #111827 !important; background-color: white !important;"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': errors.nombre }"
                placeholder="Ej: Hamburguesa Clásica"
              />
              <div v-if="errors.nombre" class="mt-1 text-sm text-red-600">
                {{ errors.nombre }}
              </div>
            </div>

            <!-- Categoría -->
            <div>
              <label for="categoria" class="block text-sm font-medium text-gray-700">
                Categoría
              </label>
              <select
                id="categoria"
                v-model="form.categoria"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': errors.categoria }"
              >
                <option value="">Seleccionar categoría</option>
                <option value="Comidas">🍔 Comidas</option>
                <option value="Bebidas">🥤 Bebidas</option>
                <option value="Postres">🍰 Postres</option>
                <option value="Snacks">🍿 Snacks</option>
              </select>
              <div v-if="errors.categoria" class="mt-1 text-sm text-red-600">
                {{ errors.categoria }}
              </div>
            </div>

            <!-- Precio -->
            <div>
              <label for="precio" class="block text-sm font-medium text-gray-700">
                Precio (ARS) *
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <span class="text-gray-500 sm:text-sm">$</span>
                </div>
                <input
                  id="precio"
                  v-model="form.precio"
                  type="number"
                  step="0.01"
                  min="0"
                  required
                  style="color: #111827 !important; background-color: white !important;"
                  class="block w-full pl-7 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  :class="{ 'border-red-500': errors.precio }"
                  placeholder="0.00"
                />
              </div>
              <div v-if="errors.precio" class="mt-1 text-sm text-red-600">
                {{ errors.precio }}
              </div>
            </div>

            <!-- Stock -->
            <div>
              <label for="stock" class="block text-sm font-medium text-gray-700">
                Stock Inicial *
              </label>
              <input
                id="stock"
                v-model="form.stock"
                type="number"
                min="0"
                required
                style="color: #111827 !important; background-color: white !important;"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': errors.stock }"
                placeholder="0"
              />
              <div v-if="errors.stock" class="mt-1 text-sm text-red-600">
                {{ errors.stock }}
              </div>
            </div>
          </div>

          <!-- Preview del producto -->
          <div v-if="form.nombre" class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-900 mb-2">👀 Vista previa</h3>
            <div class="flex items-center space-x-4">
              <div class="bg-white p-3 rounded-lg shadow-sm border">
                <h4 class="font-medium text-gray-900">{{ form.nombre }}</h4>
                <p class="text-sm text-gray-500">
                  {{ getCategoriaIcon(form.categoria) }} {{ form.categoria || 'Sin categoría' }}
                </p>
                <p class="text-lg font-bold text-green-600">${{ form.precio || '0.00' }}</p>
                <p class="text-xs text-gray-400">Stock: {{ form.stock || 0 }} unidades</p>
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="flex justify-end space-x-3">
            <Link href="/productos" 
                  class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
              Cancelar
            </Link>
            <button
              type="submit"
              :disabled="processing"
              class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50"
            >
              <span v-if="processing">Guardando...</span>
              <span v-else">💾 Crear Producto</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

const form = useForm({
  nombre: '',
  categoria: '',
  precio: '',
  stock: 0
});

const props = defineProps({
  errors: {
    type: Object,
    default: () => ({})
  }
});

const submit = () => {
  form.post('/productos', {
    onSuccess: () => {
      // Redirección automática después del éxito
    },
    onError: () => {
      // Los errores se manejan automáticamente
    }
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

// Acceso directo a processing
const processing = form.processing;
</script>