<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class PedidoController extends Controller
{
    /**
     * Mostrar lista de pedidos
     */
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'detallePedidos.producto'])
                          ->orderBy('fecha_hora', 'desc')
                          ->get();

        return Inertia::render('pedidos/Index', [
            'pedidos' => $pedidos
        ]);
    }

    /**
     * Mostrar formulario de nuevo pedido
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::where('stock', '>', 0)->orderBy('nombre')->get();

        return Inertia::render('pedidos/Create', [
            'clientes' => $clientes,
            'productos' => $productos
        ]);
    }

    /**
     * Guardar nuevo pedido
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'items' => 'required|array|min:1',
            'items.*.id_producto' => 'required|exists:productos,id_producto',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0'
        ]);

        // Crear el pedido
        $pedido = Pedido::create([
            'fecha_hora' => Carbon::now(),
            'id_cliente' => $request->id_cliente,
            'total' => 0, // Se calculará después
            'estado' => 'pendiente'
        ]);

        $total = 0;

        // Crear detalles del pedido
        foreach ($request->items as $item) {
            $subtotal = $item['cantidad'] * $item['precio_unitario'];
            
            DetallePedido::create([
                'id_pedido' => $pedido->id_pedido,
                'id_producto' => $item['id_producto'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;

            // Actualizar stock
            $producto = Producto::find($item['id_producto']);
            $producto->stock -= $item['cantidad'];
            $producto->save();
        }

        // Actualizar total del pedido
        $pedido->update(['total' => $total]);

        return redirect()->route('pedidos.index')
                        ->with('success', 'Pedido creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        // Cargar relaciones necesarias
        $pedido->load(['cliente', 'detallePedidos.producto']);
        
        return Inertia::render('pedidos/Show', [
            'pedido' => $pedido
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,completado,cancelado'
        ]);
        
        $estadoAnterior = $pedido->estado;
        $nuevoEstado = $request->estado;
        
        // Si se cancela un pedido, devolver stock
        if ($nuevoEstado === 'cancelado' && $estadoAnterior !== 'cancelado') {
            foreach ($pedido->detallePedidos as $detalle) {
                $producto = $detalle->producto;
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }
        }
        
        // Si se reactiva un pedido cancelado, descontar stock otra vez
        if ($estadoAnterior === 'cancelado' && $nuevoEstado !== 'cancelado') {
            foreach ($pedido->detallePedidos as $detalle) {
                $producto = $detalle->producto;
                if ($producto->stock >= $detalle->cantidad) {
                    $producto->stock -= $detalle->cantidad;
                    $producto->save();
                } else {
                    return redirect()->back()->with('error', 
                        "Stock insuficiente para {$producto->nombre}. Stock actual: {$producto->stock}, Requerido: {$detalle->cantidad}"
                    );
                }
            }
        }
        
        $pedido->estado = $nuevoEstado;
        $pedido->save();
        
        return redirect()->route('pedidos.show', $pedido)
                        ->with('success', 'Estado del pedido actualizado correctamente.');
    }

    /**
     * Cancelar pedido (devolver stock)
     */
    public function destroy(Pedido $pedido)
    {
        // Devolver stock si el pedido no está completado
        if ($pedido->estado !== 'completado') {
            foreach ($pedido->detallePedidos as $detalle) {
                $producto = Producto::find($detalle->id_producto);
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }
        }

        $pedido->delete();

        return redirect()->route('pedidos.index')
                        ->with('success', 'Pedido eliminado exitosamente');
    }
}
