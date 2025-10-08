<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <div class="flex items-center space-x-2">
            <img src="/images/logo.png" alt="Logo Quantix" class="h-10 w-auto">
            <span class="text-2xl font-bold text-gray-900">Quantix</span>
          </div>

          <div class="space-x-4">
            <Link href="/home" class="text-gray-700 hover:text-gray-900">Inicio</Link>
            <Link href="/profile" class="text-gray-700 hover:text-gray-900">Perfil</Link>
            <Link href="/logout" method="post" class="text-gray-700 hover:text-gray-900">Salir</Link>
          </div>
        </div>
      </div>
    </nav>

    <main class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
