<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h1 class="text-2xl font-bold text-gray-900">📊 Tablero de Control</h1>
          <p class="mt-1 text-sm text-gray-500">
            Bienvenido al sistema de gestión de carrito de comida rápida
          </p>
        </div>
      </div>

      <!-- Estadísticas -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Ventas del día -->
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
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Ventas del Día
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    ${{ ventasHoy || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Pedidos pendientes -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">⏳</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Pedidos Pendientes
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ pedidosPendientes || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Total productos -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">🍔</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Productos Activos
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ totalProductos || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Total clientes -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold">👥</span>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Clientes
                  </dt>
                  <dd class="text-lg font-medium text-gray-900">
                    {{ totalClientes || 0 }}
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Acciones rápidas -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
            🚀 Acciones Rápidas
          </h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <Link href="/pedidos/create" 
                  class="relative group bg-blue-50 p-6 rounded-lg hover:bg-blue-100 transition-colors">
              <div>
                <span class="rounded-lg inline-flex p-3 bg-blue-600 text-white">
                  📝
                </span>
              </div>
              <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900 group-hover:text-blue-900">
                  Nuevo Pedido
                </h3>
                <p class="mt-2 text-sm text-gray-500 group-hover:text-blue-700">
                  Registrar un nuevo pedido de cliente
                </p>
              </div>
            </Link>

            <Link href="/productos" 
                  class="relative group bg-green-50 p-6 rounded-lg hover:bg-green-100 transition-colors">
              <div>
                <span class="rounded-lg inline-flex p-3 bg-green-600 text-white">
                  🍔
                </span>
              </div>
              <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900 group-hover:text-green-900">
                  Gestionar Productos
                </h3>
                <p class="mt-2 text-sm text-gray-500 group-hover:text-green-700">
                  Administrar inventario de productos
                </p>
              </div>
            </Link>

            <Link href="/reportes" 
                  class="relative group bg-purple-50 p-6 rounded-lg hover:bg-purple-100 transition-colors">
              <div>
                <span class="rounded-lg inline-flex p-3 bg-purple-600 text-white">
                  📈
                </span>
              </div>
              <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900 group-hover:text-purple-900">
                  Ver Reportes
                </h3>
                <p class="mt-2 text-sm text-gray-500 group-hover:text-purple-700">
                  Analizar ventas y estadísticas
                </p>
              </div>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

// Props del controlador
defineProps({
  ventasHoy: Number,
  pedidosPendientes: Number,
  totalProductos: Number,
  totalClientes: Number,
});
</script>