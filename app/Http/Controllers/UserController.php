<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    // Mostrar el perfil de un usuario específico
    public function show(User $user)
    {
        // Obtener las semillas (inventarios) del usuario
        $semillas = $user->inventories()->latest()->paginate(10); // Cambié 'semillas' a 'inventories'
        return view('users.show', compact('user', 'semillas'));
    }

    // Editar el perfil del usuario autenticado
    public function edit()
    {
        $user = auth()->user();
        return view('users.edit', compact('user'));
    }

    // Actualizar el perfil del usuario autenticado
    public function update(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'ubicacion' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'foto_perfil' => 'nullable|image|max:2048',
        ]);

        // Manejo de la foto de perfil
        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }
            $path = $request->file('foto_perfil')->store('perfiles', 'public');
            $validatedData['foto_perfil'] = $path;
        }

        // Actualizar los datos del usuario
        $user->update($validatedData);

        return redirect()->route('users.show', $user->id)->with('success', 'Perfil actualizado exitosamente.');
    }

    // Actualizar la contraseña del usuario autenticado
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.show', $user->id)->with('success', 'Contraseña actualizada exitosamente.');
    }

}
