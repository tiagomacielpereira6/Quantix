<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onSuccess: () => window.location.href = route('home'),
    onError: () => {
      // En caso de error, se muestran automáticamente los errores
    },
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Login" />
    <div class="text-center mb-6">
      <img src="/images/logo.png" class="h-16 mx-auto mb-2" alt="Quantix Logo">
      <h1 class="text-2xl font-bold text-gray-900">Quantix</h1>
      <p class="text-gray-500">Ingresa tus credenciales</p>
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <InputLabel for="email" value="Correo electrónico" />
        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <div>
        <InputLabel for="password" value="Contraseña" />
        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required />
        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center space-x-2">
          <input type="checkbox" v-model="form.remember" class="rounded">
          <span class="text-sm text-gray-600">Recordarme</span>
        </label>
        <Link href="/register" class="text-sm text-gray-600 underline hover:text-gray-900">Crear cuenta</Link>
      </div>

      <PrimaryButton :disabled="form.processing" class="w-full">Ingresar</PrimaryButton>
    </form>
  </GuestLayout>
</template>
