<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">👥 Gestión de Clientes</h1>
              <p class="mt-1 text-sm text-gray-500">
                Administra tu base de clientes
              </p>
            </div>
            <Link href="/clientes/create" 
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
              ➕ Nuevo Cliente
            </Link>
          </div>
        </div>
      </div>

      <!-- Estadísticas -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">👥</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Clientes</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ clientes?.length || 0 }}</dd>
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
                  <span class="text-white font-semibold">🛒</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Clientes Activos</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ clientesActivos }}</dd>
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
                  <dt class="text-sm font-medium text-gray-500 truncate">Top Cliente</dt>
                  <dd class="text-lg font-medium text-gray-900">${{ topCliente }}</dd>
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
                  <dt class="text-sm font-medium text-gray-500 truncate">Promedio Gastos</dt>
                  <dd class="text-lg font-medium text-gray-900">${{ promedioGastos }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Buscador -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="max-w-md">
            <label for="buscar" class="sr-only">Buscar clientes</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-400">🔍</span>
              </div>
              <input v-model="busqueda" 
                     type="text" 
                     name="buscar" 
                     id="buscar" 
                     class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                     placeholder="Buscar por nombre, teléfono o correo...">
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla de clientes -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Cliente
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Contacto
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Pedidos
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total Gastado
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="cliente in clientesFiltrados" :key="cliente.id_cliente" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                      <span class="text-blue-600 font-medium text-sm">
                        {{ cliente.nombre.charAt(0).toUpperCase() }}
                      </span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                      {{ cliente.nombre }}
                    </div>
                    <div class="text-sm text-gray-500">
                      Cliente #{{ cliente.id_cliente }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">📞 {{ cliente.telefono }}</div>
                <div v-if="cliente.correo" class="text-sm text-gray-500">📧 {{ cliente.correo }}</div>
                <div v-else class="text-sm text-gray-400 italic">Sin correo</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ cliente.pedidos_count }} pedidos</div>
                <div class="text-sm text-gray-500">
                  <span v-if="cliente.pedidos_count > 0" 
                        :class="cliente.pedidos_count >= 5 ? 'text-green-600' : cliente.pedidos_count >= 3 ? 'text-yellow-600' : 'text-gray-500'">
                    {{ getNivelCliente(cliente.pedidos_count) }}
                  </span>
                  <span v-else class="text-gray-400">Nuevo cliente</span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">${{ cliente.total_gastado || '0.00' }}</div>
                <div class="text-sm text-gray-500">
                  <span v-if="cliente.total_gastado > 0">
                    ${{ ((cliente.total_gastado || 0) / Math.max(cliente.pedidos_count, 1)).toFixed(2) }} promedio
                  </span>
                  <span v-else class="text-gray-400">Sin compras</span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <DropdownMenu :trigger-text="`👤 Cliente`" button-class="text-xs">
                  <template #items>
                    <DropdownItem
                      :href="`/clientes/${cliente.id_cliente}`"
                      icon="👁️"
                      label="Ver Perfil"
                      description="Información completa del cliente"
                    />
                    <DropdownItem
                      :href="`/clientes/${cliente.id_cliente}/edit`"
                      icon="✏️"
                      label="Editar Datos"
                      description="Modificar información del cliente"
                      variant="default"
                    />
                    <DropdownSeparator />
                    <DropdownItem
                      @click="crearPedido(cliente)"
                      icon="🛒"
                      label="Nuevo Pedido"
                      description="Crear pedido para este cliente"
                      variant="success"
                    />
                    <DropdownItem
                      @click="verHistorial(cliente)"
                      icon="📊"
                      label="Historial Pedidos"
                      description="Ver todos los pedidos del cliente"
                      variant="default"
                    />
                    <DropdownSeparator v-if="cliente.pedidos_count === 0" />
                    <DropdownItem
                      v-if="cliente.pedidos_count === 0"
                      @confirm="eliminarCliente(cliente)"
                      icon="🗑️"
                      label="Eliminar"
                      description="Eliminar cliente permanentemente"
                      variant="danger"
                      :needs-confirmation="true"
                      confirmation-title="¿Eliminar cliente?"
                      :confirmation-message="`⚠️ ${cliente.nombre} será eliminado permanentemente del sistema.`"
                      confirm-button-text="🗑️ Eliminar"
                    />
                    <DropdownItem
                      v-else
                      icon="🚫"
                      label="No se puede eliminar"
                      description="Cliente tiene pedidos asociados"
                      variant="danger"
                      :disabled="true"
                    />
                  </template>
                </DropdownMenu>
              </td>
            </tr>
          </tbody>
        </table>
        
        <!-- Estado vacío -->
        <div v-if="clientesFiltrados.length === 0" class="text-center py-12">
          <div class="text-gray-400 text-lg mb-2">👥</div>
          <h3 class="text-sm font-medium text-gray-900 mb-1">No hay clientes</h3>
          <p class="text-sm text-gray-500 mb-4">
            {{ busqueda ? 'No se encontraron clientes con esos criterios' : 'Comienza agregando tu primer cliente' }}
          </p>
          <Link v-if="!busqueda" href="/clientes/create" 
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            ➕ Agregar Cliente
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';
import DropdownMenu from '../../components/DropdownMenu.vue';
import DropdownItem from '../../components/DropdownItem.vue';
import DropdownSeparator from '../../components/DropdownSeparator.vue';

const props = defineProps({
  clientes: {
    type: Array,
    default: () => []
  }
});

const busqueda = ref('');

// Computed properties
const clientesActivos = computed(() => {
  return (props.clientes || []).filter(c => c.pedidos_count > 0).length;
});

const topCliente = computed(() => {
  const clientesArray = props.clientes || [];
  if (clientesArray.length === 0) return '0.00';
  const max = Math.max(...clientesArray.map(c => c.total_gastado || 0));
  return max.toFixed(2);
});

const promedioGastos = computed(() => {
  const clientesArray = props.clientes || [];
  const clientesConGastos = clientesArray.filter(c => c.total_gastado > 0);
  if (clientesConGastos.length === 0) return '0.00';
  const total = clientesConGastos.reduce((sum, c) => sum + (c.total_gastado || 0), 0);
  return (total / clientesConGastos.length).toFixed(2);
});

const clientesFiltrados = computed(() => {
  const clientesArray = props.clientes || [];
  if (!busqueda.value) return clientesArray;
  
  const termino = busqueda.value.toLowerCase();
  return clientesArray.filter(cliente => 
    cliente.nombre.toLowerCase().includes(termino) ||
    cliente.telefono.toLowerCase().includes(termino) ||
    (cliente.correo && cliente.correo.toLowerCase().includes(termino))
  );
});

// Funciones helper
const getNivelCliente = (pedidos) => {
  if (pedidos >= 10) return '⭐ VIP';
  if (pedidos >= 5) return '🥇 Frecuente';
  if (pedidos >= 3) return '🥈 Regular';
  return '🥉 Ocasional';
};

const crearPedido = (cliente) => {
  // Redirigir a crear pedido con cliente preseleccionado
  router.visit(`/pedidos/create?cliente=${cliente.id_cliente}`);
};

const verHistorial = (cliente) => {
  // Redirigir a pedidos filtrados por cliente
  router.visit(`/pedidos?cliente=${cliente.id_cliente}`);
};

const eliminarCliente = (cliente) => {
  router.delete(`/clientes/${cliente.id_cliente}`);
};
</script>