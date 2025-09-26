<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <!-- Logo -->
            <div class="flex-shrink-0">
              <h1 class="text-xl font-bold text-gray-900">� Carrito Rápido</h1>
            </div>
            
            <!-- Navegación -->
            <div class="hidden md:ml-8 md:flex md:space-x-8">
              <Link href="/tablero" 
                    :class="isActive('/tablero') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                📊 Tablero
              </Link>
              
              <Link href="/productos" 
                    :class="isActive('/productos') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                🍔 Productos
              </Link>
              
              <Link href="/pedidos" 
                    :class="isActive('/pedidos') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                📦 Pedidos
              </Link>
              
              <Link href="/clientes" 
                    :class="isActive('/clientes') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                👥 Clientes
              </Link>
              
              <Link href="/proveedores" 
                    :class="isActive('/proveedores') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                🚚 Proveedores
              </Link>
              
              <Link href="/reportes" 
                    :class="isActive('/reportes') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                📈 Reportes
              </Link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const isActive = (path) => {
  return window.location.pathname.startsWith(path);
};
</script>