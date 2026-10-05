<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'rol',
        'departamento',
        'password',
        'activo',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'activo'   => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Salidas a cargo de este usuario.
     */
    public function exits()
    {
        return $this->hasMany(ExitRecord::class, 'responsable_id');
    }
}
