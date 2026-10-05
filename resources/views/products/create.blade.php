@extends('layouts.app')
@section('title', 'Registro de Producto')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-3">
            <a href="{{ route('home') }}" class="hover:text-slate-300 transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-300">Registro Producto</span>
        </nav>
        <h1 class="font-display text-3xl font-bold text-white">Registro de Producto</h1>
        <p class="text-slate-400 mt-1">Agrega un nuevo producto al inventario del almacén.</p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="alert-error mb-6">
        <p class="font-medium mb-1">Por favor corrige los siguientes errores:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Form Card --}}
    <div class="card">
        <div class="card-header">
            <h2 class="font-display font-semibold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-almacen-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Información del Producto
            </h2>
        </div>

        <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nombre --}}
                <div>
                    <label class="form-label" for="nombre">
                        Nombre del Producto <span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                           class="form-input" placeholder="Ej. Tornillo hexagonal M6"
                           required maxlength="255">
                </div>

                {{-- Categoría --}}
                <div>
                    <label class="form-label" for="categoria">
                        Categoría <span class="text-red-400">*</span>
                    </label>
                    <select id="categoria" name="categoria" class="form-select" required>
                        <option value="" disabled selected>Seleccionar categoría</option>
                        <option value="Herramientas"     {{ old('categoria')=='Herramientas' ? 'selected' : '' }}>Herramientas</option>
                        <option value="Materia Prima"    {{ old('categoria')=='Materia Prima' ? 'selected' : '' }}>Materia Prima</option>
                        <option value="Insumos"          {{ old('categoria')=='Insumos' ? 'selected' : '' }}>Insumos</option>
                        <option value="Equipos"          {{ old('categoria')=='Equipos' ? 'selected' : '' }}>Equipos</option>
                        <option value="Repuestos"        {{ old('categoria')=='Repuestos' ? 'selected' : '' }}>Repuestos</option>
                        <option value="Otro"             {{ old('categoria')=='Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                {{-- Precio --}}
                <div>
                    <label class="form-label" for="precio">
                        Precio Unitario (MXN) <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-mono text-sm">$</span>
                        <input type="number" id="precio" name="precio" value="{{ old('precio') }}"
                               class="form-input pl-7" placeholder="0.00"
                               step="0.01" min="0" required>
                    </div>
                </div>

                {{-- Stock --}}
                <div>
                    <label class="form-label" for="stock">
                        Cantidad en Stock <span class="text-red-400">*</span>
                    </label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}"
                           class="form-input" placeholder="0"
                           min="0" required>
                </div>

                {{-- Código/SKU --}}
                <div>
                    <label class="form-label" for="codigo">
                        Código / SKU
                    </label>
                    <input type="text" id="codigo" name="codigo" value="{{ old('codigo') }}"
                           class="form-input font-mono" placeholder="SKU-0001">
                </div>

                {{-- Unidad de Medida --}}
                <div>
                    <label class="form-label" for="unidad">
                        Unidad de Medida
                    </label>
                    <select id="unidad" name="unidad" class="form-select">
                        <option value="pza" {{ old('unidad','pza')=='pza' ? 'selected' : '' }}>Pieza (pza)</option>
                        <option value="kg"  {{ old('unidad')=='kg'  ? 'selected' : '' }}>Kilogramo (kg)</option>
                        <option value="lt"  {{ old('unidad')=='lt'  ? 'selected' : '' }}>Litro (lt)</option>
                        <option value="mt"  {{ old('unidad')=='mt'  ? 'selected' : '' }}>Metro (mt)</option>
                        <option value="caja"{{ old('unidad')=='caja'? 'selected' : '' }}>Caja</option>
                    </select>
                </div>

                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label class="form-label" for="descripcion">
                        Descripción
                    </label>
                    <textarea id="descripcion" name="descripcion" rows="3"
                              class="form-textarea"
                              placeholder="Descripción detallada del producto...">{{ old('descripcion') }}</textarea>
                </div>

                {{-- Imagen (Dropzone) --}}
                <div class="md:col-span-2">
                    <label class="form-label">
                        Imagen del Producto
                    </label>

                    {{-- Hidden native input (populated by JS) --}}
                    <input type="file" id="imagen" name="imagen" class="hidden" accept="image/*">

                    {{-- Dropzone area --}}
                    <div id="product-dropzone" class="dropzone-custom dropzone"></div>

                    <p class="text-xs text-slate-500 mt-2">
                        Formatos: JPG, PNG, WEBP, GIF — Máximo 10 MB
                    </p>
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-white/10">
                <a href="{{ route('home') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Producto
                </button>
            </div>
        </form>
    </div>

    {{-- Products List --}}
    @if(isset($products) && $products->count() > 0)
    <div class="card mt-6">
        <div class="card-header flex items-center justify-between">
            <h2 class="font-display font-semibold text-white">Productos Registrados</h2>
            <span class="badge badge-warning">{{ $products->total() }} registros</span>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->imagen)
                                <img src="{{ Storage::url($product->imagen) }}" class="w-10 h-10 rounded-lg object-cover" alt="">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="font-medium text-white">{{ $product->nombre }}</td>
                        <td>{{ $product->categoria }}</td>
                        <td class="font-mono text-almacen-accent">${{ number_format($product->precio, 2) }}</td>
                        <td>
                            <span class="badge {{ $product->stock > 10 ? 'badge-success' : ($product->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger"
                                        data-confirm="¿Eliminar el producto '{{ $product->nombre }}'?">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
    @endif

</div>
@endsection
