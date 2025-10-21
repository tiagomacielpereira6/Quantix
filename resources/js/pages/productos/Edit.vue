<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">✏️ Editar Producto</h1>
              <p class="mt-1 text-sm text-gray-500">
                Modificar información del producto: {{ producto.nombre }}
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
                Stock Actual *
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
              <p class="mt-1 text-xs text-gray-500">
                Stock anterior: {{ producto.stock }} unidades
              </p>
            </div>
          </div>

          <!-- Vista previa de cambios -->
          <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-yellow-800 mb-2">⚠️ Cambios realizados</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
              <div>
                <h4 class="font-medium text-gray-700">Valores Anteriores</h4>
                <ul class="text-gray-600 space-y-1">
                  <li>Nombre: {{ producto.nombre }}</li>
                  <li>Categoría: {{ producto.categoria || 'Sin categoría' }}</li>
                  <li>Precio: ${{ producto.precio }}</li>
                  <li>Stock: {{ producto.stock }}</li>
                </ul>
              </div>
              <div>
                <h4 class="font-medium text-gray-700">Valores Nuevos</h4>
                <ul class="text-gray-600 space-y-1">
                  <li :class="{ 'text-orange-600 font-medium': form.nombre !== producto.nombre }">
                    Nombre: {{ form.nombre }}
                  </li>
                  <li :class="{ 'text-orange-600 font-medium': form.categoria !== producto.categoria }">
                    Categoría: {{ form.categoria || 'Sin categoría' }}
                  </li>
                  <li :class="{ 'text-orange-600 font-medium': form.precio != producto.precio }">
                    Precio: ${{ form.precio }}
                  </li>
                  <li :class="{ 'text-orange-600 font-medium': form.stock != producto.stock }">
                    Stock: {{ form.stock }}
                  </li>
                </ul>
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
              class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 disabled:opacity-50"
            >
              <span v-if="processing">Guardando...</span>
              <span v-else>💾 Actualizar Producto</span>
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

const props = defineProps({
  producto: Object,
  errors: {
    type: Object,
    default: () => ({})
  }
});

const form = useForm({
  nombre: props.producto.nombre,
  categoria: props.producto.categoria,
  precio: props.producto.precio,
  stock: props.producto.stock
});

const submit = () => {
  form.put(`/productos/${props.producto.id_producto}`, {
    onSuccess: () => {
      // Redirección automática después del éxito
    }
  });
};

const processing = form.processing;
</script>