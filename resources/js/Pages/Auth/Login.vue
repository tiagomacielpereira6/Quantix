<template>
    <GuestLayout>
        <Head title="Log In" />

        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
            Iniciar Sesión
        </h2>
        
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Contraseña -->
            <div>
                <InputLabel for="password" value="Contraseña" />
                <TextInput
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <!-- Checkbox "Recordarme" -->
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        v-model="form.remember"
                        class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500"
                    />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                </label>

                <!-- Link a Registro -->
                <Link
                    :href="route('register')"
                    class="text-sm text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300 font-medium transition duration-150"
                >
                    ¿Crear cuenta?
                </Link>
            </div>

            <!-- Botón de Login -->
            <PrimaryButton :processing="form.processing" class="mt-4 bg-green-600 hover:bg-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1m0-13v-1m-9 4h2m5-4v2m-2-2h2m-4 5h2m-5-4h2m-5 4h2m-5 4h2m-5-4h2m-5 4h2"/></svg>
                Ingresar
            </PrimaryButton>
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
