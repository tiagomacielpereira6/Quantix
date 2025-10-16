<template>
    <AppLayout>
        <Head title="Perfil" />

        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6 border-b pb-4 border-gray-200 dark:border-gray-700">
             <svg xmlns="http://www.w3.org/2000/svg" class="inline w-7 h-7 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Configuración del Perfil
        </h1>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Formulario de Actualización de Información -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Información de Perfil</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Actualiza la información de nombre y correo electrónico de tu cuenta.
                        </p>
                    </header>
                    
                    <!-- Formulario de ejemplo simple para Inertia -->
                    <form @submit.prevent="updateProfile" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="Nombre" />
                            <TextInput id="name" type="text" v-model="form.name" required autofocus class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput id="email" type="email" v-model="form.email" required class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <PrimaryButton :processing="form.processing" class="bg-orange-600 hover:bg-orange-700">Guardar</PrimaryButton>
                            
                            <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Guardado.</p>
                            </Transition>
                        </div>
                    </form>
                </section>
            </div>

            <!-- Sección de Eliminación de Cuenta -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Eliminar Cuenta</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente.
                        </p>
                    </header>
                    <button @click="confirmDelete" class="mt-4 px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                        Eliminar Cuenta
                    </button>
                    
                    <!-- El modal de confirmación real debería ser un componente. Esto es solo para la demostración. -->
                    <div v-if="deleting" class="mt-4 p-4 border border-red-300 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <p class="text-sm font-semibold text-red-800 dark:text-red-400 mb-2">¿Estás absolutamente seguro?</p>
                        <button @click="deleting = false" class="text-sm text-gray-700 dark:text-gray-300 underline mr-4">Cancelar</button>
                        <PrimaryButton @click="deleteUser" class="bg-red-600 hover:bg-red-700">Confirmar Eliminación</PrimaryButton>
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    auth: Object,
});

const deleting = ref(false);

const form = useForm({
    name: props.auth.user.name,
    email: props.auth.user.email,
});

const formDelete = useForm({
    password: '', // Esto solo es un placeholder; se requeriría un input real en un modal
});

const updateProfile = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};

const confirmDelete = () => {
    // Aquí normalmente abrirías un modal pidiendo la contraseña
    deleting.value = true;
};

const deleteUser = () => {
    // Simulación de la eliminación; en un entorno real, usarías un modal de confirmación de contraseña.
    formDelete.delete(route('profile.destroy'), {
        preserveScroll: true,
        // data: { password: formDelete.password } // Si se usara un input
    });
};
</script>
