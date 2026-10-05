<?php

namespace App\Http\Controllers;

use App\Models\ExitRecord;
use App\Models\Product;
use App\Models\Usuario;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'products'   => Product::count(),
            'exits'      => ExitRecord::count(),
            'exits_today'=> ExitRecord::whereDate('fecha_salida', today())->count(),
            'users'      => Usuario::count(),
        ];

        $recentProducts = Product::latest()->take(5)->get();

        return view('home', compact('stats', 'recentProducts'));
    }
}
