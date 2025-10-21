<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compras';
    protected $primaryKey = 'id_detalle_compra';
    
    protected $fillable = [
        'id_compra',
        'id_producto',
        'cantidad',
        'costo_unitario',
        'subtotal'
    ];

    protected $casts = [
        'costo_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    /**
     * Relación: Un detalle pertenece a una compra
     */
    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class, 'id_compra', 'id_compra');
    }

    /**
     * Relación: Un detalle pertenece a un producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
