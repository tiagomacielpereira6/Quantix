<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\GastoIngreso;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class TableroController extends Controller
{
    public function index()
    {
        // Obtener estadísticas del día
        $hoy = Carbon::today();
        
        // Ventas del día (suma de pedidos completados)
        $ventasHoy = Pedido::where('fecha_hora', '>=', $hoy)
                           ->where('estado', 'completado')
                           ->sum('total');

        // Pedidos pendientes
        $pedidosPendientes = Pedido::where('estado', 'pendiente')->count();

        // Total de productos activos (con stock > 0)
        $totalProductos = Producto::where('stock', '>', 0)->count();

        // Total de clientes registrados
        $totalClientes = Cliente::count();

        return Inertia::render('Tablero', [
            'ventasHoy' => (float) $ventasHoy,
            'pedidosPendientes' => (int) $pedidosPendientes,
            'totalProductos' => (int) $totalProductos,
            'totalClientes' => (int) $totalClientes,
        ]);
    }
}
