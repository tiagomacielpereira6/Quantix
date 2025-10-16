<template>
  <div class="login-page">
    <div class="login-container">
      <img src="/logo.png" alt="Logo de la App" class="logo" />
      <form @submit.prevent="submit">
        <input v-model="form.email" type="email" placeholder="Email" required />
        <input v-model="form.password" type="password" placeholder="Contraseña" required />
        <button type="submit">Ingresar</button>
      </form>
      <p v-if="errors.email" class="error">{{ errors.email }}</p>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/vue3';

const form = reactive({
  email: '',
  password: ''
});

const errors = reactive({});

function submit() {
  Inertia.post('/login', form, {
    onError: (errs) => Object.assign(errors, errs),
    onSuccess: () => {
      // redirige automáticamente a /tablero
    }
  });
}
</script>

<style>
.login-page { display:flex; justify-content:center; align-items:center; height:100vh; }
.login-container { width:300px; display:flex; flex-direction:column; gap:10px; }
.logo { width:150px; margin:0 auto 20px; }
.error { color:red; font-size:0.9em; }
</style>
