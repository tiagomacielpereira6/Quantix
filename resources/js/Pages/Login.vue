<template>
  <AppLayout>
    <div class="flex items-center justify-center min-h-screen">
      <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
          <img src="/images/logo.png" alt="Quantix" class="h-16 w-auto" />
        </div>

        <!-- Título -->
        <h2 class="text-2xl font-bold text-center mb-4">Iniciar sesión</h2>

        <!-- Formulario de login -->
        <form @submit.prevent="submitLogin" class="space-y-4">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="mt-1 block w-full border border-gray-300 rounded-md p-2"
            />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="mt-1 block w-full border border-gray-300 rounded-md p-2"
            />
          </div>

          <button
            type="submit"
            class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700"
          >
            Iniciar sesión
          </button>
        </form>

        <!-- Registro -->
        <p class="mt-4 text-center text-sm text-gray-600">
          ¿No tienes cuenta?
          <Link href="/register" class="text-blue-600 hover:underline">Registrate</Link>
        </p>

      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const form = useForm({
  email: '',
  password: '',
})

const submitLogin = () => {
  form.post('/login', {
    onSuccess: () => {
      // Redirige a /home si login es exitoso
      window.location.href = '/home'
    },
  })
}
</script>
