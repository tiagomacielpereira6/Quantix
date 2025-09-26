<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    
    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'categoria',
        'activo'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean'
    ];

    /**
     * Relación: Un producto puede estar en muchos detalles de pedidos
     */
    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'id_producto', 'id_producto');
    }

    /**
     * Relación: Un producto puede estar en muchos detalles de compras
     */
    public function detalleCompras(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'id_producto', 'id_producto');
    }
}
