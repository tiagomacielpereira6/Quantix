<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación Personalizada
|--------------------------------------------------------------------------
| Estas rutas manejan la lógica de Login y Registro.
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registro
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Rutas de la Aplicación (Requieren Autenticación)
|--------------------------------------------------------------------------
| Todas estas rutas utilizan el middleware 'auth'.
*/

Route::middleware('auth')->group(function () {
    // Página principal (tablero o dashboard)
    Route::get('/home', function () {
        return Inertia::render('tablero'); // Coincide con tablero.vue
    })->name('home');

    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cerrar Sesión
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Ruta raíz
|--------------------------------------------------------------------------
| Redirige según si el usuario está autenticado o no.
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

