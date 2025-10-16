<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisterController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function showRegistrationForm()
    {
        // Renderiza el componente Vue Register.vue
        return Inertia::render('Auth/Register');
    }

    /**
     * Procesa la solicitud de registro, crea y loguea al usuario.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // El modelo User se encarga del hashing
        ]);

        Auth::login($user);

        // Redirige al usuario a la página principal /home
        return redirect()->route('tablero.index');
    }
}
