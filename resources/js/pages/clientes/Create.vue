<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">➕ Nuevo Cliente</h1>
              <p class="mt-1 text-sm text-gray-500">
                Agrega un nuevo cliente a tu base de datos
              </p>
            </div>
            <Link href="/clientes" 
                  class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
              ← Volver
            </Link>
          </div>
        </div>
      </div>

      <!-- Formulario -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <form @submit.prevent="submit" class="space-y-6 p-6">
          <!-- Nombre -->
          <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
              👤 Nombre Completo *
            </label>
            <input v-model="form.nombre"
                   type="text" 
                   name="nombre" 
                   id="nombre" 
                   required
                   style="color: #111827 !important; background-color: white !important;"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                   placeholder="Ej: Juan Pérez">
            <div v-if="$page.props.errors.nombre" class="mt-1 text-sm text-red-600">
              {{ $page.props.errors.nombre }}
            </div>
          </div>

          <!-- Teléfono -->
          <div>
            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
              📞 Teléfono *
            </label>
            <input v-model="form.telefono"
                   type="tel" 
                   name="telefono" 
                   id="telefono" 
                   required
                   style="color: #111827 !important; background-color: white !important;"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                   placeholder="Ej: +54 9 11 1234-5678">
            <div v-if="$page.props.errors.telefono" class="mt-1 text-sm text-red-600">
              {{ $page.props.errors.telefono }}
            </div>
            <p class="mt-1 text-sm text-gray-500">
              Formato recomendado: +54 9 11 1234-5678 o 11 1234-5678
            </p>
          </div>

          <!-- Correo -->
          <div>
            <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
              📧 Correo Electrónico (Opcional)
            </label>
            <input v-model="form.correo"
                   type="email" 
                   name="correo" 
                   id="correo" 
                   style="color: #111827 !important; background-color: white !important;"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                   placeholder="Ej: juan.perez@email.com">
            <div v-if="$page.props.errors.correo" class="mt-1 text-sm text-red-600">
              {{ $page.props.errors.correo }}
            </div>
            <p class="mt-1 text-sm text-gray-500">
              El correo es opcional pero útil para comunicaciones futuras
            </p>
          </div>

          <!-- Información adicional -->
          <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <span class="text-blue-400">💡</span>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">
                  Información útil
                </h3>
                <div class="mt-2 text-sm text-blue-700">
                  <ul class="pl-5 space-y-1">
                    <li>• El nombre y teléfono son obligatorios</li>
                    <li>• El número de teléfono debe ser único en el sistema</li>
                    <li>• El correo electrónico también debe ser único si se proporciona</li>
                    <li>• Podrás editar esta información después de crear el cliente</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <Link href="/clientes" 
                  class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
              Cancelar
            </Link>
            <button type="submit" 
                    :disabled="processing"
                    :class="processing ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center">
              <span v-if="processing" class="mr-2">⏳</span>
              <span v-else class="mr-2">💾</span>
              {{ processing ? 'Guardando...' : 'Crear Cliente' }}
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
            Así se verá la información del cliente
          </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12">
              <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                <span class="text-blue-600 font-medium">
                  {{ form.nombre ? form.nombre.charAt(0).toUpperCase() : '?' }}
                </span>
              </div>
            </div>
            <div class="ml-4">
              <div class="text-lg font-medium text-gray-900">
                {{ form.nombre || 'Nombre del cliente' }}
              </div>
              <div class="text-sm text-gray-500">
                📞 {{ form.telefono || 'Número de teléfono' }}
              </div>
              <div v-if="form.correo" class="text-sm text-gray-500">
                📧 {{ form.correo }}
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

const processing = ref(false);

const form = reactive({
  nombre: '',
  telefono: '',
  correo: ''
});

const submit = () => {
  processing.value = true;
  
  router.post('/clientes', form, {
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