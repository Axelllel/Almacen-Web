<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        $users = Usuario::latest()->paginate(10);
        return view('users.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:100',
            'apellido'     => 'required|string|max:100',
            'email'        => 'required|email|unique:usuarios,email|max:255',
            'telefono'     => 'nullable|string|max:20',
            'rol'          => 'required|in:Administrador,Almacenista,Supervisor,Operario,Auditor',
            'departamento' => 'nullable|string|max:100',
            'password'     => 'required|string|min:8|confirmed',
            'activo'       => 'nullable|boolean',
        ], [
            'nombre.required'    => 'El nombre es obligatorio.',
            'apellido.required'  => 'El apellido es obligatorio.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El correo electrónico no es válido.',
            'email.unique'       => 'Este correo ya está registrado.',
            'rol.required'       => 'Selecciona un rol.',
            'rol.in'             => 'El rol seleccionado no es válido.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['activo']   = $request->has('activo');

        Usuario::create($validated);

        return redirect()->route('users.create')
            ->with('success', "Usuario '{$validated['nombre']} {$validated['apellido']}' creado exitosamente.");
    }

    public function destroy(Usuario $user)
    {
        $name = "{$user->nombre} {$user->apellido}";
        $user->delete();

        return redirect()->route('users.create')
            ->with('success', "Usuario '{$name}' eliminado.");
    }
}
