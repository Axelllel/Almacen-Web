<?php

namespace App\Http\Controllers;

use App\Models\ExitRecord;
use App\Models\Product;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExitController extends Controller
{
    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('nombre')->get();
        $users    = Usuario::where('activo', true)->orderBy('nombre')->get();
        $exits    = ExitRecord::with(['product', 'responsable'])->latest()->paginate(10);

        return view('exits.create', compact('products', 'users', 'exits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'producto_id'    => 'required|exists:products,id',
            'cantidad'       => 'required|integer|min:1',
            'destino'        => 'required|string|max:255',
            'motivo'         => 'required|string|max:100',
            'responsable_id' => 'required|exists:usuarios,id',
            'fecha_salida'   => 'required|date',
            'observaciones'  => 'nullable|string|max:1000',
            'comprobante'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ], [
            'producto_id.required'    => 'Selecciona un producto.',
            'producto_id.exists'      => 'El producto seleccionado no existe.',
            'cantidad.required'       => 'La cantidad es obligatoria.',
            'cantidad.min'            => 'La cantidad debe ser al menos 1.',
            'destino.required'        => 'El destino es obligatorio.',
            'motivo.required'         => 'El motivo de salida es obligatorio.',
            'responsable_id.required' => 'Selecciona un responsable.',
            'fecha_salida.required'   => 'La fecha de salida es obligatoria.',
        ]);

        // Verify sufficient stock
        $product = Product::findOrFail($validated['producto_id']);
        if ($validated['cantidad'] > $product->stock) {
            return back()
                ->withInput()
                ->withErrors(['cantidad' => "Stock insuficiente. Disponible: {$product->stock} {$product->unidad}."]);
        }

        // Handle comprobante upload
        if ($request->hasFile('comprobante')) {
            $validated['comprobante'] = $request->file('comprobante')
                ->store('comprobantes', 'public');
        }

        // Use transaction to ensure consistency
        DB::transaction(function () use ($validated, $product) {
            ExitRecord::create($validated);
            // Deduct stock
            $product->decrement('stock', $validated['cantidad']);
        });

        return redirect()->route('exits.create')
            ->with('success', "Salida registrada: {$validated['cantidad']} unidad(es) de '{$product->nombre}'.");
    }
}
