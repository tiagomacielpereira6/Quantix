<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;
use PDF;

class ReporteController extends Controller
{
    public function index()
    {
        // Período por defecto: último mes
        $fechaInicio = Carbon::now()->subMonth()->startOfDay();
        $fechaFin = Carbon::now()->endOfDay();

        $reportes = $this->generarReportes($fechaInicio, $fechaFin);

        return Inertia::render('reportes/Index', $reportes);
    }

    public function filtrar(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->endOfDay();

        $reportes = $this->generarReportes($fechaInicio, $fechaFin);

        return Inertia::render('reportes/Index', $reportes);
    }

    private function generarReportes($fechaInicio, $fechaFin)
    {
        // Estadísticas generales
        $estadisticasGenerales = [
            'total_ventas' => (float) Pedido::where('estado', 'completado')
                                  ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
                                  ->sum('total'),
            'total_pedidos' => (int) Pedido::whereBetween('fecha_hora', [$fechaInicio, $fechaFin])->count(),
            'pedidos_completados' => (int) Pedido::where('estado', 'completado')
                                          ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
                                          ->count(),
            'pedidos_cancelados' => (int) Pedido::where('estado', 'cancelado')
                                         ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
                                         ->count(),
            'ticket_promedio' => (float) Pedido::where('estado', 'completado')
                                      ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
                                      ->avg('total') ?: 0,
            'total_productos' => (int) Producto::count(),
            'total_clientes' => (int) Cliente::count(),
            'total_proveedores' => (int) Proveedor::count()
        ];

        // Ventas por día
        $ventasPorDia = Pedido::select(
                DB::raw('DATE(fecha_hora) as fecha'),
                DB::raw('SUM(CASE WHEN estado = "completado" THEN total ELSE 0 END) as ventas'),
                DB::raw('COUNT(*) as pedidos')
            )
            ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
            ->groupBy(DB::raw('DATE(fecha_hora)'))
            ->orderBy('fecha')
            ->get();

        // Productos más vendidos
        $productosTop = DB::table('detalle_pedidos')
            ->join('pedidos', 'detalle_pedidos.id_pedido', '=', 'pedidos.id_pedido')
            ->join('productos', 'detalle_pedidos.id_producto', '=', 'productos.id_producto')
            ->where('pedidos.estado', 'completado')
            ->whereBetween('pedidos.fecha_hora', [$fechaInicio, $fechaFin])
            ->select(
                'productos.nombre',
                'productos.categoria',
                'productos.precio',
                DB::raw('SUM(detalle_pedidos.cantidad) as cantidad_vendida'),
                DB::raw('SUM(detalle_pedidos.subtotal) as ingresos_total')
            )
            ->groupBy('productos.id_producto', 'productos.nombre', 'productos.categoria', 'productos.precio')
            ->orderByDesc('cantidad_vendida')
            ->limit(10)
            ->get();

        // Clientes más frecuentes
        $clientesTop = DB::table('pedidos')
            ->join('clientes', 'pedidos.id_cliente', '=', 'clientes.id_cliente')
            ->where('pedidos.estado', 'completado')
            ->whereBetween('pedidos.fecha_hora', [$fechaInicio, $fechaFin])
            ->select(
                'clientes.nombre',
                'clientes.telefono',
                DB::raw('COUNT(*) as total_pedidos'),
                DB::raw('SUM(pedidos.total) as total_gastado'),
                DB::raw('AVG(pedidos.total) as promedio_pedido')
            )
            ->groupBy('clientes.id_cliente', 'clientes.nombre', 'clientes.telefono')
            ->orderByDesc('total_gastado')
            ->limit(10)
            ->get();

        // Ventas por categoría
        $ventasPorCategoria = DB::table('detalle_pedidos')
            ->join('pedidos', 'detalle_pedidos.id_pedido', '=', 'pedidos.id_pedido')
            ->join('productos', 'detalle_pedidos.id_producto', '=', 'productos.id_producto')
            ->where('pedidos.estado', 'completado')
            ->whereBetween('pedidos.fecha_hora', [$fechaInicio, $fechaFin])
            ->select(
                'productos.categoria',
                DB::raw('SUM(detalle_pedidos.cantidad) as cantidad_vendida'),
                DB::raw('SUM(detalle_pedidos.subtotal) as ingresos'),
                DB::raw('COUNT(DISTINCT detalle_pedidos.id_pedido) as pedidos_categoria')
            )
            ->groupBy('productos.categoria')
            ->orderByDesc('ingresos')
            ->get();

        // Análisis de horarios
        $ventasPorHora = Pedido::select(
                DB::raw('HOUR(fecha_hora) as hora'),
                DB::raw('COUNT(*) as pedidos'),
                DB::raw('SUM(CASE WHEN estado = "completado" THEN total ELSE 0 END) as ventas')
            )
            ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
            ->groupBy(DB::raw('HOUR(fecha_hora)'))
            ->orderBy('hora')
            ->get();

        // Stock bajo (productos con menos de 10 unidades)
        $stockBajo = Producto::where('stock', '<', 10)
            ->orderBy('stock')
            ->get();

        return [
            'periodo' => [
                'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                'fecha_fin' => $fechaFin->format('Y-m-d')
            ],
            'estadisticas_generales' => $estadisticasGenerales,
            'ventas_por_dia' => $ventasPorDia,
            'productos_top' => $productosTop,
            'clientes_top' => $clientesTop,
            'ventas_por_categoria' => $ventasPorCategoria,
            'ventas_por_hora' => $ventasPorHora,
            'stock_bajo' => $stockBajo
        ];
    }

    /**
     * Generar reporte de ventas en PDF
     */
    public function generarReporteVentas(Request $request)
    {
        $fechaInicio = $request->fecha_inicio ? Carbon::parse($request->fecha_inicio)->startOfDay() : Carbon::now()->subMonth()->startOfDay();
        $fechaFin = $request->fecha_fin ? Carbon::parse($request->fecha_fin)->endOfDay() : Carbon::now()->endOfDay();

        $reportes = $this->generarReportes($fechaInicio, $fechaFin);
        
        $pdf = PDF::loadView('pdf.reporte-ventas', compact('reportes'));
        $pdf->setPaper('A4', 'portrait');
        
        $nombreArchivo = "reporte-ventas-" . $fechaInicio->format('Y-m-d') . "-" . $fechaFin->format('Y-m-d') . ".pdf";
        
        return $pdf->download($nombreArchivo);
    }

    /**
     * Generar reporte de inventario en PDF
     */
    public function generarReporteInventario()
    {
        $productos = Producto::where('activo', true)
                           ->orderBy('stock', 'asc')
                           ->get();

        $estadisticas = [
            'total_productos' => $productos->count(),
            'productos_stock_bajo' => $productos->where('stock', '<=', 10)->count(),
            'productos_agotados' => $productos->where('stock', 0)->count(),
            'valor_inventario' => $productos->sum(function($p) { return $p->stock * $p->precio; })
        ];
        
        $pdf = PDF::loadView('pdf.reporte-inventario', compact('productos', 'estadisticas'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('reporte-inventario-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Generar reporte de clientes en PDF
     */
    public function generarReporteClientes()
    {
        $clientes = Cliente::withCount(['pedidos'])
                          ->withSum(['pedidos' => function($query) {
                              $query->where('estado', 'completado');
                          }], 'total')
                          ->orderByDesc('pedidos_sum_total')
                          ->get();

        $estadisticas = [
            'total_clientes' => $clientes->count(),
            'clientes_activos' => $clientes->where('pedidos_count', '>', 0)->count(),
            'cliente_top_gasto' => $clientes->first()->pedidos_sum_total ?? 0,
            'promedio_gasto' => $clientes->where('pedidos_count', '>', 0)->avg('pedidos_sum_total') ?? 0
        ];
        
        $pdf = PDF::loadView('pdf.reporte-clientes', compact('clientes', 'estadisticas'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('reporte-clientes-' . now()->format('Y-m-d') . '.pdf');
    }
}