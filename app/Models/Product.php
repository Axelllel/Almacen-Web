<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'categoria',
        'precio',
        'stock',
        'codigo',
        'unidad',
        'descripcion',
        'imagen',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock'  => 'integer',
    ];

    /**
     * Salidas asociadas a este producto.
     */
    public function exits()
    {
        return $this->hasMany(Exit::class, 'producto_id');
    }
}
