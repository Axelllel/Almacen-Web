<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo users
        Usuario::create([
            'nombre'       => 'Admin',
            'apellido'     => 'Sistema',
            'email'        => 'admin@webalmacen.com',
            'rol'          => 'Administrador',
            'departamento' => 'Dirección',
            'password'     => Hash::make('password'),
            'activo'       => true,
        ]);

        Usuario::create([
            'nombre'       => 'Juan',
            'apellido'     => 'García López',
            'email'        => 'juan@webalmacen.com',
            'telefono'     => '+52 55 1234 5678',
            'rol'          => 'Almacenista',
            'departamento' => 'Almacén',
            'password'     => Hash::make('password'),
            'activo'       => true,
        ]);

        // Demo products
        $products = [
            ['nombre' => 'Tornillo Hexagonal M6',  'categoria' => 'Insumos',       'precio' => 0.50,  'stock' => 500,  'unidad' => 'pza', 'codigo' => 'TH-M6'],
            ['nombre' => 'Tuerca M6',               'categoria' => 'Insumos',       'precio' => 0.25,  'stock' => 500,  'unidad' => 'pza', 'codigo' => 'TU-M6'],
            ['nombre' => 'Cinta de Aislar',         'categoria' => 'Insumos',       'precio' => 18.00, 'stock' => 50,   'unidad' => 'pza', 'codigo' => 'CA-001'],
            ['nombre' => 'Martillo 16oz',           'categoria' => 'Herramientas',  'precio' => 250.00,'stock' => 10,   'unidad' => 'pza', 'codigo' => 'HM-16'],
            ['nombre' => 'Taladro Percutor 700W',   'categoria' => 'Equipos',       'precio' => 1800.00,'stock' => 3,   'unidad' => 'pza', 'codigo' => 'TP-700'],
            ['nombre' => 'Aceite Lubricante 1L',    'categoria' => 'Insumos',       'precio' => 85.00, 'stock' => 20,   'unidad' => 'lt',  'codigo' => 'AL-001'],
            ['nombre' => 'Cable Eléctrico THW',     'categoria' => 'Materia Prima', 'precio' => 12.00, 'stock' => 300,  'unidad' => 'mt',  'codigo' => 'CE-THW'],
            ['nombre' => 'Guantes de Trabajo',      'categoria' => 'Insumos',       'precio' => 45.00, 'stock' => 30,   'unidad' => 'pza', 'codigo' => 'GT-001'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
