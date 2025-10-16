<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900 font-inter">
        <!-- Logo de Quantix -->
        <div class="mb-6">
            <div class="h-16 w-16 flex items-center justify-center rounded-full bg-orange-500 shadow-lg overflow-hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M12 2a4 4 0 0 0-4 4v3H6a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1"/><path d="M2 17h20"/><path d="M16 4h2a2 2 0 0 1 2 2v3h-2a4 4 0 0 0-4 4v-4"/></svg>
            </div>
        </div>

        <!-- Contenedor del Formulario -->
        <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-xl border border-gray-200 dark:border-gray-700">
            <slot />
        </div>
    </div>
</template>
