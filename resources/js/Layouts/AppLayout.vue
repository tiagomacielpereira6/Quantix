<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 font-inter">
        <!-- Navegación Superior (Navbar) -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center text-xl font-bold text-orange-600 dark:text-orange-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M12 2a4 4 0 0 0-4 4v3H6a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1"/><path d="M2 17h20"/><path d="M16 4h2a2 2 0 0 1 2 2v3h-2a4 4 0 0 0-4 4v-4"/></svg>
                            Quantix Manager
                        </div>
                    </div>

                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <!-- Links de Navegación -->
                        <Link :href="route('home')" class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 transition duration-150 rounded-lg">
                            Home
                        </Link>
                        <Link :href="route('profile.edit')" class="ml-4 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 transition duration-150 rounded-lg">
                            Perfil
                        </Link>

                        <!-- Botón de Logout -->
                        <Link :href="route('logout')" method="post" as="button" class="ml-6 flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                            Cerrar Sesión
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido de la Página -->
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <slot />
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
