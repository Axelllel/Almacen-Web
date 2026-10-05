@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- Hero Banner --}}
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-almacen-navy via-almacen-steel to-almacen-dark border border-white/10 p-8 mb-8">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-almacen-accent rounded-full filter blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 rounded-full filter blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    </div>
    <div class="relative z-10">
        <p class="text-almacen-accent text-sm font-semibold uppercase tracking-widest mb-2">Bienvenido al sistema</p>
        <h1 class="font-display text-4xl font-bold text-white mb-3">
            Panel de Control
        </h1>
        <p class="text-slate-400 text-lg max-w-xl">
            Gestiona tu inventario, registra entradas y salidas, y administra usuarios desde un solo lugar.
        </p>
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @php
        $stats = [
            ['label' => 'Total Productos',  'value' => $stats['products']  ?? 0, 'color' => 'text-blue-400',   'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label' => 'Salidas Hoy',      'value' => $stats['exits_today'] ?? 0, 'color' => 'text-red-400',  'icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1'],
            ['label' => 'Total Salidas',    'value' => $stats['exits']      ?? 0, 'color' => 'text-amber-400', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ['label' => 'Usuarios',         'value' => $stats['users']      ?? 0, 'color' => 'text-green-400', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 {{ $stat['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-display font-bold text-white">{{ number_format($stat['value']) }}</p>
            <p class="text-slate-400 text-xs">{{ $stat['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('products.create') }}" class="card group hover:border-almacen-accent/40 transition-all duration-300 hover:-translate-y-1">
        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-500/30 transition-colors">
            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <h3 class="font-display font-semibold text-white mb-1">Nuevo Producto</h3>
        <p class="text-slate-400 text-sm">Registra un producto con imagen, precio y stock.</p>
    </a>

    <a href="{{ route('exits.create') }}" class="card group hover:border-almacen-accent/40 transition-all duration-300 hover:-translate-y-1">
        <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center mb-4 group-hover:bg-red-500/30 transition-colors">
            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
            </svg>
        </div>
        <h3 class="font-display font-semibold text-white mb-1">Registrar Salida</h3>
        <p class="text-slate-400 text-sm">Registra la salida de productos del almacén.</p>
    </a>

    <a href="{{ route('users.create') }}" class="card group hover:border-almacen-accent/40 transition-all duration-300 hover:-translate-y-1">
        <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-500/30 transition-colors">
            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <h3 class="font-display font-semibold text-white mb-1">Nuevo Usuario</h3>
        <p class="text-slate-400 text-sm">Agrega un nuevo usuario al sistema.</p>
    </a>
</div>

{{-- Recent Products Table --}}
@if(isset($recentProducts) && $recentProducts->count() > 0)
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h2 class="font-display font-semibold text-white">Productos Recientes</h2>
        <a href="{{ route('products.index') }}" class="text-almacen-accent text-sm hover:underline">Ver todos →</a>
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
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentProducts as $product)
                <tr>
                    <td>
                        @if($product->imagen)
                            <img src="{{ Storage::url($product->imagen) }}" class="w-10 h-10 rounded-lg object-cover" alt="{{ $product->nombre }}">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td class="font-medium text-white">{{ $product->nombre }}</td>
                    <td>{{ $product->categoria }}</td>
                    <td class="font-mono text-almacen-accent">${{ number_format($product->precio, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge {{ $product->stock > 10 ? 'badge-success' : ($product->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                            {{ $product->stock > 10 ? 'Disponible' : ($product->stock > 0 ? 'Bajo stock' : 'Agotado') }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
