<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitRecord extends Model
{
    use HasFactory;

    protected $table = 'exit_records';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'destino',
        'motivo',
        'responsable_id',
        'fecha_salida',
        'observaciones',
        'comprobante',
    ];

    protected $casts = [
        'fecha_salida' => 'date',
        'cantidad'     => 'integer',
    ];

    /**
     * Producto relacionado.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    /**
     * Usuario responsable.
     */
    public function responsable()
    {
        return $this->belongsTo(Usuario::class, 'responsable_id');
    }
}
