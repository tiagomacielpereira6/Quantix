<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::withCount('pedidos')
                          ->with(['pedidos' => function($query) {
                              $query->where('estado', 'completado')
                                    ->select('id_cliente', 'total');
                          }])
                          ->get()
                          ->map(function($cliente) {
                              $cliente->total_gastado = $cliente->pedidos->sum('total');
                              return $cliente;
                          });

        return Inertia::render('clientes/Index', [
            'clientes' => $clientes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('clientes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20|unique:clientes,telefono',
            'correo' => 'nullable|email|max:255|unique:clientes,correo',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.unique' => 'Ya existe un cliente con este número de teléfono',
            'correo.email' => 'El formato del correo no es válido',
            'correo.unique' => 'Ya existe un cliente con este correo electrónico',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        // Cargar pedidos con detalles
        $cliente->load(['pedidos.detallePedidos.producto']);
        
        return Inertia::render('clientes/Show', [
            'cliente' => $cliente
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return Inertia::render('clientes/Edit', [
            'cliente' => $cliente
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20|unique:clientes,telefono,' . $cliente->id_cliente . ',id_cliente',
            'correo' => 'nullable|email|max:255|unique:clientes,correo,' . $cliente->id_cliente . ',id_cliente',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.unique' => 'Ya existe un cliente con este número de teléfono',
            'correo.email' => 'El formato del correo no es válido',
            'correo.unique' => 'Ya existe un cliente con este correo electrónico',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar si el cliente tiene pedidos
        if ($cliente->pedidos()->count() > 0) {
            return redirect()->back()
                            ->with('error', 'No se puede eliminar el cliente porque tiene pedidos asociados.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente eliminado exitosamente.');
    }
}
