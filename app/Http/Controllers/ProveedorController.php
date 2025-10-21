<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::withCount(['compras'])
                               ->withSum('compras', 'total')
                               ->orderBy('created_at', 'desc')
                               ->get();

        return Inertia::render('proveedores/Index', [
            'proveedores' => $proveedores
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('proveedores/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')
                        ->with('success', 'Proveedor creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        $proveedor->load([
            'compras.detalleCompras.producto',
            'compras' => function($query) {
                $query->orderBy('fecha_compra', 'desc')->take(10);
            }
        ]);

        $estadisticas = [
            'total_compras' => $proveedor->compras()->count(),
            'monto_total' => $proveedor->compras()->sum('total'),
            'promedio_compra' => $proveedor->compras()->avg('total'),
            'ultima_compra' => $proveedor->compras()->latest('fecha_compra')->first()?->fecha_compra,
            'productos_suministrados' => $proveedor->compras()
                                                   ->join('detalle_compras', 'compras.id_compra', '=', 'detalle_compras.id_compra')
                                                   ->distinct('detalle_compras.id_producto')
                                                   ->count()
        ];

        return Inertia::render('proveedores/Show', [
            'proveedor' => $proveedor,
            'estadisticas' => $estadisticas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {
        return Inertia::render('proveedores/Edit', [
            'proveedor' => $proveedor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.show', $proveedor)
                        ->with('success', 'Proveedor actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        // Verificar si tiene compras asociadas
        if ($proveedor->compras()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'No se puede eliminar el proveedor porque tiene compras asociadas');
        }

        $proveedor->delete();

        return redirect()->route('proveedores.index')
                        ->with('success', 'Proveedor eliminado exitosamente');
    }
}