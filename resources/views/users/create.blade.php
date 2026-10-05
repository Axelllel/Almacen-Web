@extends('layouts.app')
@section('title', 'Registro de Usuarios')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8">
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-3">
            <a href="{{ route('home') }}" class="hover:text-slate-300 transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-300">Registro Usuarios</span>
        </nav>
        <h1 class="font-display text-3xl font-bold text-white">Registro de Usuarios</h1>
        <p class="text-slate-400 mt-1">Agrega nuevos usuarios al sistema de gestión del almacén.</p>
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
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Datos del Usuario
            </h2>
        </div>

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nombre --}}
                <div>
                    <label class="form-label" for="nombre">
                        Nombre(s) <span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                           class="form-input" placeholder="Ej. Juan Carlos" required maxlength="100">
                </div>

                {{-- Apellido --}}
                <div>
                    <label class="form-label" for="apellido">
                        Apellido(s) <span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}"
                           class="form-input" placeholder="Ej. García López" required maxlength="100">
                </div>

                {{-- Email --}}
                <div>
                    <label class="form-label" for="email">
                        Correo Electrónico <span class="text-red-400">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-input" placeholder="usuario@empresa.com" required>
                </div>

                {{-- Teléfono --}}
                <div>
                    <label class="form-label" for="telefono">
                        Teléfono
                    </label>
                    <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}"
                           class="form-input" placeholder="+52 55 0000 0000" maxlength="20">
                </div>

                {{-- Rol --}}
                <div>
                    <label class="form-label" for="rol">
                        Rol / Cargo <span class="text-red-400">*</span>
                    </label>
                    <select id="rol" name="rol" class="form-select" required>
                        <option value="" disabled selected>Seleccionar rol</option>
                        <option value="Administrador" {{ old('rol')=='Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Almacenista"   {{ old('rol')=='Almacenista'   ? 'selected' : '' }}>Almacenista</option>
                        <option value="Supervisor"    {{ old('rol')=='Supervisor'    ? 'selected' : '' }}>Supervisor</option>
                        <option value="Operario"      {{ old('rol')=='Operario'      ? 'selected' : '' }}>Operario</option>
                        <option value="Auditor"       {{ old('rol')=='Auditor'       ? 'selected' : '' }}>Auditor</option>
                    </select>
                </div>

                {{-- Departamento --}}
                <div>
                    <label class="form-label" for="departamento">
                        Departamento
                    </label>
                    <input type="text" id="departamento" name="departamento" value="{{ old('departamento') }}"
                           class="form-input" placeholder="Ej. Producción, Logística...">
                </div>

                {{-- Password --}}
                <div>
                    <label class="form-label" for="password">
                        Contraseña <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                               class="form-input pr-10" placeholder="Mínimo 8 caracteres"
                               minlength="8" required>
                        <button type="button" onclick="togglePass('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Password Confirm --}}
                <div>
                    <label class="form-label" for="password_confirmation">
                        Confirmar Contraseña <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-input pr-10" placeholder="Repetir contraseña"
                               minlength="8" required>
                        <button type="button" onclick="togglePass('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Estado --}}
                <div class="md:col-span-2 flex items-center gap-3">
                    <input type="checkbox" id="activo" name="activo" value="1"
                           class="w-4 h-4 rounded bg-almacen-dark border-white/20 text-almacen-accent focus:ring-almacen-accent/50"
                           {{ old('activo', '1') ? 'checked' : '' }}>
                    <label for="activo" class="text-sm text-slate-300 cursor-pointer">
                        Usuario activo — puede acceder al sistema
                    </label>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    @if(isset($users) && $users->count() > 0)
    <div class="card mt-6">
        <div class="card-header flex items-center justify-between">
            <h2 class="font-display font-semibold text-white">Usuarios del Sistema</h2>
            <span class="badge badge-success">{{ $users->total() }} usuarios</span>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Departamento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-white font-medium">{{ $user->nombre }} {{ $user->apellido }}</td>
                        <td class="font-mono text-sm">{{ $user->email }}</td>
                        <td><span class="badge badge-warning">{{ $user->rol }}</span></td>
                        <td>{{ $user->departamento ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $user->activo ? 'badge-success' : 'badge-danger' }}">
                                {{ $user->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger"
                                        data-confirm="¿Eliminar al usuario {{ $user->nombre }}?">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
    @endif

</div>

<script>
function togglePass(id) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
