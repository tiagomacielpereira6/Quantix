<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    
    protected $fillable = [
        'fecha_hora',
        'id_cliente',
        'total',
        'estado'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'total' => 'decimal:2'
    ];

    /**
     * Relación: Un pedido pertenece a un cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Relación: Un pedido puede tener muchos detalles
     */
    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }
}
