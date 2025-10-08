<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onSuccess: () => window.location.href = route('home'),
    onError: () => {},
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Registro" />

    <div class="text-center mb-6">
      <img src="/images/logo.png" class="h-16 mx-auto mb-2" alt="Quantix Logo">
      <h1 class="text-2xl font-bold text-gray-900">Quantix</h1>
      <p class="text-gray-500">Crea tu cuenta</p>
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <InputLabel for="name" value="Nombre" />
        <TextInput id="name" v-model="form.name" required autofocus />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <div>
        <InputLabel for="email" value="Correo electrónico" />
        <TextInput id="email" type="email" v-model="form.email" required />
        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <div>
        <InputLabel for="password" value="Contraseña" />
        <TextInput id="password" type="password" v-model="form.password" required />
        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <div>
        <InputLabel for="password_confirmation" value="Confirmar contraseña" />
        <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" required />
        <InputError :message="form.errors.password_confirmation" class="mt-2" />
      </div>

      <div class="flex items-center justify-between">
        <Link href="/login" class="text-sm text-gray-600 underline hover:text-gray-900">Ya tienes cuenta?</Link>
        <PrimaryButton :disabled="form.processing" class="w-full">Registrarse</PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
