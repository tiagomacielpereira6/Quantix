<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <!-- Logo -->
            <div class="flex-shrink-0">
              <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Quantix
              </h1>
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

          <!-- Menú de usuario -->
          <div class="flex items-center space-x-4">
            <!-- Información del usuario -->
            <div class="hidden md:flex md:items-center md:space-x-4">
              <span class="text-sm text-gray-700">
                Bienvenido, <span class="font-medium">{{ $page.props.auth?.user?.name || 'Usuario' }}</span>
              </span>
              <span class="text-xs text-gray-500">
                (@{{ $page.props.auth?.user?.username || 'usuario' }})
              </span>
            </div>

            <!-- Botón de logout -->
            <button 
              @click="logout"
              class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
            >
              <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              Salir
            </button>
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
import { Link, router } from '@inertiajs/vue3';

const isActive = (path) => {
  return window.location.pathname.startsWith(path);
};

const logout = () => {
  router.post('/logout');
};
</script>