<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth; // Necesario para cerrar la sesión antes de eliminar
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Muestra la vista de edición de perfil.
     * Renderiza el componente Vue Profile/Edit.vue
     */
    public function edit(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            // Propiedades de ejemplo para la vista, como la verificación de email
            'mustVerifyEmail' => $request->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Actualiza la información del perfil del usuario (nombre y email).
     */
    public function update(Request $request)
    {
        // 1. Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            // Asegura que el email sea único, excepto para el usuario actual
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        // 2. Llenar el modelo con los datos validados
        $request->user()->fill($request->validated());

        // 3. Si el email cambia, se debe restablecer la verificación
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // 4. Guardar los cambios
        $request->user()->save();

        // 5. Redirigir de vuelta a la página de edición con un mensaje de éxito
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina la cuenta del usuario. Requiere la contraseña actual.
     */
    public function destroy(Request $request)
    {
        // 1. Validar la contraseña para confirmar la eliminación
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // 2. Cerrar la sesión del usuario
        Auth::logout();

        // 3. Eliminar el registro del usuario
        $user->delete();

        // 4. Invalidar la sesión y regenerar el token (seguridad)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 5. Redirigir al inicio de la aplicación
        return Redirect::to('/');
    }
}
