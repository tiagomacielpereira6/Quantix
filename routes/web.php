<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TicketController;
use Inertia\Inertia;

// Ruta principal - redirige al tablero
Route::get('/', function () {
    return redirect()->route('tablero');
})->middleware('auth');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Tablero principal
    Route::get('/tablero', [TableroController::class, 'index'])->name('tablero');

    // Rutas de productos
    Route::resource('productos', ProductoController::class);
    Route::patch('/productos/{producto}/toggle-activo', [ProductoController::class, 'toggleActivo'])->name('productos.toggle-activo');

    // Rutas de pedidos
    Route::resource('pedidos', PedidoController::class);

    // Rutas de clientes
    Route::resource('clientes', ClienteController::class);

    // Rutas de proveedores
    Route::resource('proveedores', ProveedorController::class);

    // Rutas de reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::post('/reportes/filtrar', [ReporteController::class, 'filtrar'])->name('reportes.filtrar');

    // Rutas para generación de reportes PDF
    Route::get('/reportes/ventas/pdf', [ReporteController::class, 'generarReporteVentas'])->name('reportes.ventas.pdf');
    Route::get('/reportes/inventario/pdf', [ReporteController::class, 'generarReporteInventario'])->name('reportes.inventario.pdf');
    Route::get('/reportes/clientes/pdf', [ReporteController::class, 'generarReporteClientes'])->name('reportes.clientes.pdf');

    // Rutas para tickets PDF
    Route::get('/pedidos/{pedido}/ticket', [TicketController::class, 'generarTicketPedido'])->name('pedidos.ticket');
    Route::get('/pedidos/{pedido}/recibo', [TicketController::class, 'generarReciboPago'])->name('pedidos.recibo');
    Route::get('/pedidos/{pedido}/cocina', [TicketController::class, 'generarTicketCocina'])->name('pedidos.cocina');
    Route::post('/pedidos/{pedido}/imprimir', [TicketController::class, 'imprimirTicketPedido'])->name('pedidos.imprimir');
});

Route::get('/clientes', function () {
    return Inertia::render('clientes/Index');
})->name('clientes.index');

// Dashboard original (comentado por ahora)
// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
// require __DIR__.'/auth.php'; // Deshabilitado para usar Fortify
