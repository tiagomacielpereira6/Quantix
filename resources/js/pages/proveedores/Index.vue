<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">🏪 Gestión de Proveedores</h1>
              <p class="mt-1 text-sm text-gray-500">
                Administra tus proveedores y relaciones comerciales
              </p>
            </div>
            <Link href="/proveedores/create" 
                  class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
              ➕ Nuevo Proveedor
            </Link>
          </div>
        </div>
      </div>

      <!-- Filtros -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="block text-sm font-medium text-gray-700">Buscar proveedor</label>
            <input type="text" 
                   v-model="filtros.nombre"
                   placeholder="Nombre del proveedor..."
                   style="color: #111827 !important; background-color: white !important;"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="text" 
                   v-model="filtros.telefono"
                   placeholder="Número de teléfono..."
                   style="color: #111827 !important; background-color: white !important;"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Correo</label>
            <input type="email" 
                   v-model="filtros.correo"
                   placeholder="Correo electrónico..."
                   style="color: #111827 !important; background-color: white !important;"
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
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">🏪</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Proveedores</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ proveedores.length }}</dd>
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
                  <span class="text-white font-semibold">📦</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Con Compras</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ proveedoresConCompras }}</dd>
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
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Comprado</dt>
                  <dd class="text-lg font-medium text-gray-900">${{ totalComprado }}</dd>
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
                  <span class="text-white font-semibold">📊</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Promedio Compra</dt>
                  <dd class="text-lg font-medium text-gray-900">${{ promedioCompra }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla de proveedores -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Proveedor
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Contacto
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Compras
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total Comprado
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="proveedor in proveedoresFiltrados" :key="proveedor.id_proveedor">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                      <span class="text-blue-600 font-medium text-sm">
                        {{ proveedor.nombre.charAt(0).toUpperCase() }}
                      </span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                      {{ proveedor.nombre }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ proveedor.contacto || 'Sin contacto' }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  📞 {{ proveedor.telefono }}
                </div>
                <div class="text-sm text-gray-500" v-if="proveedor.correo">
                  📧 {{ proveedor.correo }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                  {{ proveedor.compras_count || 0 }} compras
                </div>
                <div class="text-sm text-gray-500">
                  Registrado {{ formatFecha(proveedor.created_at) }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                ${{ proveedor.compras_sum_total || '0.00' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <DropdownMenu :trigger-text="`🏪 Gestionar`" button-class="text-xs">
                  <template #items>
                    <DropdownItem
                      :href="`/proveedores/${proveedor.id_proveedor}`"
                      icon="👁️"
                      label="Ver Perfil"
                      description="Información completa del proveedor"
                    />
                    <DropdownItem
                      :href="`/proveedores/${proveedor.id_proveedor}/edit`"
                      icon="✏️"
                      label="Editar Datos"
                      description="Modificar información del proveedor"
                      variant="default"
                    />
                    <DropdownSeparator />
                    <DropdownItem
                      @click="crearCompra(proveedor)"
                      icon="🛒"
                      label="Nueva Compra"
                      description="Registrar compra de productos"
                      variant="success"
                    />
                    <DropdownItem
                      @click="verHistorialCompras(proveedor)"
                      icon="📊"
                      label="Historial Compras"
                      description="Ver todas las compras realizadas"
                      variant="default"
                    />
                    <DropdownSeparator />
                    <DropdownItem
                      @confirm="eliminarProveedor(proveedor)"
                      icon="🗑️"
                      label="Eliminar"
                      description="Eliminar proveedor permanentemente"
                      variant="danger"
                      :needs-confirmation="true"
                      confirmation-title="¿Eliminar proveedor?"
                      :confirmation-message="`⚠️ ${proveedor.nombre} será eliminado permanentemente junto con todo su historial de compras.`"
                      confirm-button-text="🗑️ Eliminar"
                    />
                  </template>
                </DropdownMenu>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Mensaje si no hay proveedores -->
        <div v-if="proveedoresFiltrados.length === 0" class="text-center py-8">
          <div class="text-gray-500">
            <span class="text-4xl block mb-2">🏪</span>
            <p class="text-lg font-medium">No hay proveedores registrados</p>
            <p class="text-sm">Comienza agregando tu primer proveedor</p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import DropdownMenu from '../../components/DropdownMenu.vue';
import DropdownItem from '../../components/DropdownItem.vue';
import DropdownSeparator from '../../components/DropdownSeparator.vue';

const props = defineProps({
  proveedores: {
    type: Array,
    default: () => []
  }
});

// Filtros reactivos
const filtros = ref({
  nombre: '',
  telefono: '',
  correo: ''
});

// Proveedores filtrados
const proveedoresFiltrados = computed(() => {
  let proveedores = props.proveedores;

  if (filtros.value.nombre) {
    proveedores = proveedores.filter(p => 
      p.nombre.toLowerCase().includes(filtros.value.nombre.toLowerCase())
    );
  }

  if (filtros.value.telefono) {
    proveedores = proveedores.filter(p => 
      p.telefono.includes(filtros.value.telefono)
    );
  }

  if (filtros.value.correo) {
    proveedores = proveedores.filter(p => 
      p.correo?.toLowerCase().includes(filtros.value.correo.toLowerCase())
    );
  }

  return proveedores;
});

// Estadísticas calculadas
const proveedoresConCompras = computed(() => 
  props.proveedores.filter(p => (p.compras_count || 0) > 0).length
);

const totalComprado = computed(() => 
  props.proveedores.reduce((sum, p) => sum + parseFloat(p.compras_sum_total || 0), 0).toFixed(2)
);

const promedioCompra = computed(() => {
  const total = parseFloat(totalComprado.value);
  const totalCompras = props.proveedores.reduce((sum, p) => sum + (p.compras_count || 0), 0);
  return totalCompras > 0 ? (total / totalCompras).toFixed(2) : '0.00';
});

// Funciones helper
const formatFecha = (fecha) => {
  return new Date(fecha).toLocaleDateString('es-AR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  });
};

const crearCompra = (proveedor) => {
  // Por ahora mostrar placeholder hasta implementar sistema de compras
  alert(`🛒 Función próximamente: Nueva compra para ${proveedor.nombre}`);
};

const verHistorialCompras = (proveedor) => {
  // Por ahora mostrar placeholder hasta implementar sistema de compras
  alert(`📊 Función próximamente: Historial de compras de ${proveedor.nombre}`);
};

const eliminarProveedor = (proveedor) => {
  router.delete(`/proveedores/${proveedor.id_proveedor}`);
};
</script>