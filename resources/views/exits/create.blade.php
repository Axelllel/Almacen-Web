@extends('layouts.app')
@section('title', 'Registro de Salida')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8">
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-3">
            <a href="{{ route('home') }}" class="hover:text-slate-300 transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-300">Registro Salida</span>
        </nav>
        <h1 class="font-display text-3xl font-bold text-white">Registro de Salida</h1>
        <p class="text-slate-400 mt-1">Documenta la salida de productos del almacén.</p>
    </div>

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

    <div class="card">
        <div class="card-header">
            <h2 class="font-display font-semibold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Datos de Salida
            </h2>
        </div>

        <form action="{{ route('exits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Producto --}}
                <div class="md:col-span-2">
                    <label class="form-label" for="producto_id">
                        Producto <span class="text-red-400">*</span>
                    </label>
                    <select id="producto_id" name="producto_id" class="form-select" required>
                        <option value="" disabled selected>Seleccionar producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                    data-stock="{{ $product->stock }}"
                                    {{ old('producto_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->nombre }} — Stock: {{ $product->stock }} {{ $product->unidad }}
                            </option>
                        @endforeach
                    </select>
                    <p id="stock-info" class="text-xs text-slate-500 mt-1 hidden">
                        Stock disponible: <span id="stock-value" class="font-mono text-almacen-accent"></span>
                    </p>
                </div>

                {{-- Cantidad --}}
                <div>
                    <label class="form-label" for="cantidad">
                        Cantidad <span class="text-red-400">*</span>
                    </label>
                    <input type="number" id="cantidad" name="cantidad" value="{{ old('cantidad', 1) }}"
                           class="form-input" min="1" required>
                </div>

                {{-- Destino --}}
                <div>
                    <label class="form-label" for="destino">
                        Destino / Área <span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="destino" name="destino" value="{{ old('destino') }}"
                           class="form-input" placeholder="Ej. Taller, Área de producción..." required>
                </div>

                {{-- Motivo --}}
                <div>
                    <label class="form-label" for="motivo">
                        Motivo de Salida <span class="text-red-400">*</span>
                    </label>
                    <select id="motivo" name="motivo" class="form-select" required>
                        <option value="" disabled selected>Seleccionar motivo</option>
                        <option value="Uso en producción"  {{ old('motivo')=='Uso en producción'  ? 'selected' : '' }}>Uso en producción</option>
                        <option value="Mantenimiento"      {{ old('motivo')=='Mantenimiento'      ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="Devolución"         {{ old('motivo')=='Devolución'         ? 'selected' : '' }}>Devolución a proveedor</option>
                        <option value="Transferencia"      {{ old('motivo')=='Transferencia'      ? 'selected' : '' }}>Transferencia interna</option>
                        <option value="Merma"              {{ old('motivo')=='Merma'              ? 'selected' : '' }}>Merma / Descarte</option>
                        <option value="Otro"               {{ old('motivo')=='Otro'               ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                {{-- Responsable --}}
                <div>
                    <label class="form-label" for="responsable">
                        Responsable <span class="text-red-400">*</span>
                    </label>
                    <select id="responsable" name="responsable_id" class="form-select" required>
                        <option value="" disabled selected>Seleccionar responsable</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('responsable_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->nombre }} {{ $user->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha --}}
                <div>
                    <label class="form-label" for="fecha_salida">
                        Fecha de Salida <span class="text-red-400">*</span>
                    </label>
                    <input type="date" id="fecha_salida" name="fecha_salida"
                           value="{{ old('fecha_salida', date('Y-m-d')) }}"
                           class="form-input" required>
                </div>

                {{-- Observaciones --}}
                <div class="md:col-span-2">
                    <label class="form-label" for="observaciones">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="3"
                              class="form-textarea"
                              placeholder="Notas adicionales sobre esta salida...">{{ old('observaciones') }}</textarea>
                </div>

                {{-- Comprobante (Dropzone) --}}
                <div class="md:col-span-2">
                    <label class="form-label">
                        Comprobante / Evidencia
                        <span class="text-slate-500 font-normal">(opcional)</span>
                    </label>
                    <input type="file" id="comprobante" name="comprobante" class="hidden" accept="image/*">
                    <div id="exit-dropzone" class="dropzone-custom dropzone"></div>
                    <p class="text-xs text-slate-500 mt-2">
                        Sube una foto del comprobante de salida o evidencia. Máximo 10 MB.
                    </p>
                </div>

            </div>

            <div class="flex items-center justify-between mt-8 pt-6 border-t border-white/10">
                <a href="{{ route('home') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                    </svg>
                    Registrar Salida
                </button>
            </div>
        </form>
    </div>

    {{-- Exits Table --}}
    @if(isset($exits) && $exits->count() > 0)
    <div class="card mt-6">
        <div class="card-header flex items-center justify-between">
            <h2 class="font-display font-semibold text-white">Salidas Registradas</h2>
            <span class="badge badge-danger">{{ $exits->total() }} registros</span>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Destino</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th>Comprobante</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exits as $exit)
                    <tr>
                        <td class="font-mono text-slate-500">{{ $exit->id }}</td>
                        <td class="text-white font-medium">{{ $exit->product->nombre ?? '—' }}</td>
                        <td class="font-mono">{{ $exit->cantidad }}</td>
                        <td>{{ $exit->destino }}</td>
                        <td><span class="badge badge-warning">{{ $exit->motivo }}</span></td>
                        <td class="font-mono text-slate-400">{{ \Carbon\Carbon::parse($exit->fecha_salida)->format('d/m/Y') }}</td>
                        <td>
                            @if($exit->comprobante)
                                <a href="{{ Storage::url($exit->comprobante) }}" target="_blank"
                                   class="text-almacen-accent hover:underline text-xs">Ver imagen</a>
                            @else
                                <span class="text-slate-600 text-xs">Sin comprobante</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $exits->links() }}</div>
    </div>
    @endif

</div>

<script>
// Show available stock when product is selected
document.getElementById('producto_id')?.addEventListener('change', function () {
    const opt   = this.options[this.selectedIndex];
    const stock = opt.dataset.stock;
    const info  = document.getElementById('stock-info');
    const val   = document.getElementById('stock-value');
    if (stock !== undefined) {
        info.classList.remove('hidden');
        val.textContent = stock;
        document.getElementById('cantidad').max = stock;
    }
});
</script>

@endsection
