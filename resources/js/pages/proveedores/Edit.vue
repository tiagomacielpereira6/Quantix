<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">✏️ Editar Proveedor</h1>
              <p class="mt-1 text-sm text-gray-500">
                Modificar información de: {{ proveedor.nombre }}
              </p>
            </div>
            <div class="flex space-x-3">
              <Link href="/proveedores" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Volver a Lista
              </Link>
              <Link :href="`/proveedores/${proveedor.id_proveedor}`" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                👁️ Ver Proveedor
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Formulario -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <form @submit.prevent="submit" class="space-y-6 p-6">
          <!-- Nombre -->
          <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
              🏪 Nombre de la Empresa *
            </label>
            <input v-model="form.nombre"
                   type="text" 
                   name="nombre" 
                   id="nombre" 
                   required
                   style="color: #111827 !important; background-color: white !important;"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                   placeholder="Ej: Distribuidora ABC S.A.">
            <div v-if="$page.props.errors.nombre" class="mt-1 text-sm text-red-600">
              {{ $page.props.errors.nombre }}
            </div>
          </div>

          <!-- Contacto -->
          <div>
            <label for="contacto" class="block text-sm font-medium text-gray-700 mb-2">
              � Información de Contacto *
            </label>
            <input v-model="form.contacto"
                   type="text" 
                   name="contacto" 
                   id="contacto"
                   required
                   style="color: #111827 !important; background-color: white !important;"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                   placeholder="Ej: Juan Pérez - Tel: +54 11 4567-8900 - Email: juan@distribuidora.com">
            <div v-if="$page.props.errors.contacto" class="mt-1 text-sm text-red-600">
              {{ $page.props.errors.contacto }}
            </div>
            <p class="mt-1 text-sm text-gray-500">
              Información de contacto del proveedor (nombre, teléfono, email, etc.)
            </p>
          </div>

          <!-- Información adicional -->
          <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <span class="text-yellow-400">⚠️</span>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                  Cambios importantes
                </h3>
                <div class="mt-2 text-sm text-yellow-700">
                  <ul class="pl-5 space-y-1">
                    <li>• Los cambios afectarán todos los registros futuros</li>
                    <li>• Las compras anteriores mantendrán la información original</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <Link href="/proveedores" 
                  class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
              Cancelar
            </Link>
            <button type="submit" 
                    :disabled="processing"
                    :class="processing ? 'opacity-50 cursor-not-allowed' : 'hover:bg-green-700'"
                    class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center">
              <span v-if="processing" class="mr-2">⏳</span>
              <span v-else class="mr-2">💾</span>
              {{ processing ? 'Guardando...' : 'Actualizar Proveedor' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Vista previa -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            👁️ Vista Previa
          </h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Así se verá la información actualizada del proveedor
          </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-start">
            <div class="flex-shrink-0 h-12 w-12">
              <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                <span class="text-green-600 font-medium">
                  {{ form.nombre ? form.nombre.charAt(0).toUpperCase() : '?' }}
                </span>
              </div>
            </div>
            <div class="ml-4">
              <div class="text-lg font-medium text-gray-900">
                {{ form.nombre || 'Nombre de la empresa' }}
              </div>
              <div v-if="form.contacto" class="text-sm text-gray-600 mt-2 whitespace-pre-line">
                � {{ form.contacto }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

const props = defineProps({
  proveedor: Object
});

const processing = ref(false);

const form = reactive({
  nombre: props.proveedor.nombre,
  contacto: props.proveedor.contacto || '',
});

const submit = () => {
  processing.value = true;
  
  router.put(`/proveedores/${props.proveedor.id_proveedor}`, form, {
    onFinish: () => {
      processing.value = false;
    },
    onSuccess: () => {
      // El redirect se maneja en el controlador
    },
    onError: (errors) => {
      console.log('Errores de validación:', errors);
    }
  });
};
</script>