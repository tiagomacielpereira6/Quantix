<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Mostrar lista de productos
     */
    public function index()
    {
        $productos = Producto::orderBy('nombre')->get();

        return Inertia::render('productos/Index', [
            'productos' => $productos,
            'flash' => [
                'success' => session('success'),
                'error' => session('error')
            ]
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return Inertia::render('productos/Create');
    }

    /**
     * Guardar nuevo producto
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'nullable|string|max:100'
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')
                        ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Mostrar producto específico
     */
    public function show(Producto $producto)
    {
        return Inertia::render('productos/Show', [
            'producto' => $producto
        ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Producto $producto)
    {
        return Inertia::render('productos/Edit', [
            'producto' => $producto
        ]);
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'nullable|string|max:100'
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
                        ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Eliminar producto
     */
    public function destroy(Producto $producto)
    {
        // Verificar si el producto tiene pedidos asociados
        $pedidosAsociados = DB::table('detalle_pedidos')
            ->where('id_producto', $producto->id_producto)
            ->count();

        if ($pedidosAsociados > 0) {
            return redirect()->route('productos.index')
                            ->with('error', "❌ No se puede eliminar el producto '{$producto->nombre}' porque tiene {$pedidosAsociados} pedido(s) asociado(s). Considera desactivarlo en lugar de eliminarlo.");
        }

        try {
            $nombreProducto = $producto->nombre;
            $producto->delete();

            return redirect()->route('productos.index')
                            ->with('success', "✅ Producto '{$nombreProducto}' eliminado exitosamente");
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                            ->with('error', "❌ Error al eliminar el producto: " . $e->getMessage());
        }
    }

    /**
     * Cambiar estado activo/inactivo del producto
     */
    public function toggleActivo(Producto $producto)
    {
        try {
            $producto->activo = !$producto->activo;
            $producto->save();

            $estado = $producto->activo ? 'activado' : 'desactivado';
            $icono = $producto->activo ? '✅' : '⏸️';

            return redirect()->route('productos.index')
                            ->with('success', "{$icono} Producto '{$producto->nombre}' {$estado} exitosamente");
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                            ->with('error', "❌ Error al cambiar estado del producto: " . $e->getMessage());
        }
    }
}
