<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GastoIngreso extends Model
{
    protected $table = 'gastos_ingresos';
    protected $primaryKey = 'id_movimiento';
    
    protected $fillable = [
        'tipo',
        'descripcion',
        'monto',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2'
    ];

    /**
     * Scopes para filtrar por tipo
     */
    public function scopeIngresos($query)
    {
        return $query->where('tipo', 'Ingreso');
    }

    public function scopeGastos($query)
    {
        return $query->where('tipo', 'Gasto');
    }
}
