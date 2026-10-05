<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Show the form + list of products.
     */
    public function create()
    {
        $products = Product::latest()->paginate(10);
        return view('products.create', compact('products'));
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'categoria'   => 'required|string|max:100',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'codigo'      => 'nullable|string|max:100|unique:products,codigo',
            'unidad'      => 'nullable|string|max:20',
            'descripcion' => 'nullable|string|max:1000',
            'imagen'      => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ], [
            'nombre.required'    => 'El nombre del producto es obligatorio.',
            'categoria.required' => 'Selecciona una categoría.',
            'precio.required'    => 'El precio es obligatorio.',
            'precio.numeric'     => 'El precio debe ser un número.',
            'stock.required'     => 'El stock es obligatorio.',
            'codigo.unique'      => 'Este código ya está registrado.',
            'imagen.image'       => 'El archivo debe ser una imagen.',
            'imagen.max'         => 'La imagen no debe pesar más de 10 MB.',
        ]);

        // Handle image upload
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')
                ->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.create')
            ->with('success', "Producto '{$validated['nombre']}' registrado exitosamente.");
    }

    /**
     * Index (all products).
     */
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('products.create', compact('products'));
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        if ($product->imagen) {
            Storage::disk('public')->delete($product->imagen);
        }
        $product->delete();

        return redirect()->route('products.create')
            ->with('success', "Producto '{$product->nombre}' eliminado.");
    }
}
