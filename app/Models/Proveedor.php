<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    
    protected $fillable = [
        'nombre',
        'contacto'
    ];

    /**
     * Relación: Un proveedor puede tener muchas compras
     */
    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'id_proveedor', 'id_proveedor');
    }
}
