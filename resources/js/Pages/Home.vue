<template>
    <AppLayout>
        <Head title="Home" />

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6 border-gray-200 dark:border-gray-700">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-7 h-7 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6m-6 0h-2M9 20h6"/></svg>
                Dashboard Principal
            </h1>
            <p class="mt-2 sm:mt-0 text-sm font-medium text-gray-500 dark:text-gray-400">
                Bienvenido de vuelta, {{ $page.props.auth.user.name }}!
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card de Bienvenida -->
            <div class="md:col-span-2 bg-green-50 dark:bg-gray-700 p-6 rounded-xl shadow-lg border border-green-200 dark:border-gray-600">
                <h2 class="text-xl font-bold text-green-800 dark:text-green-400 mb-2">
                    Gestión de Negocios de Comida Rápida
                </h2>
                <p class="text-gray-700 dark:text-gray-300">
                    Estás utilizando un sistema de autenticación personalizado con Laravel, Inertia y Vue 3. 
                    Ahora puedes empezar a construir la lógica de tu aplicación (pedidos, inventario, reportes) aquí.
                </p>
            </div>

            <!-- Card de Perfil Rápido -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Tu Perfil</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium">Email:</span> {{ $page.props.auth.user.email }}
                </p>
                <div class="mt-4">
                    <Link :href="route('profile.edit')" class="text-sm text-orange-600 hover:text-orange-500 font-medium transition duration-150">
                        Ir a Editar Perfil
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>
