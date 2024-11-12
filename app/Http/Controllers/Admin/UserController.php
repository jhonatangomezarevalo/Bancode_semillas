<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Crear una consulta base de usuarios
        $query = User::query();

        // Filtro por rol (si se aplica)
        if ($request->has('role') && $request->role != '') {
            // Verifica si el rol es un nombre y obtiene el role_id correspondiente
            $role = Role::where('name', $request->role)->first();
            
            if ($role) {
                $query->where('role_id', $role->id); // Filtramos por role_id
            }
        }

        // Filtro por municipio (si se aplica)
        if ($request->has('municipio') && $request->municipio != '') {
            $query->where('municipio', $request->municipio); // Filtramos por municipio
        }

        // Recupera los usuarios según los filtros
        $usuarios = $query->get();

        // Recupera todos los roles disponibles para el filtro
        $roles = Role::all(); 

        // Recupera todos los municipios disponibles para el filtro
        $municipios = User::distinct()->pluck('municipio');

        // Preparar los datos para las gráficas circulares de roles
        $roleCounts = $roles->map(function ($role) {
            // Contamos cuántos usuarios tienen el role_id correspondiente a cada rol
            return User::where('role_id', $role->id)->count(); 
        });

        // Preparar los datos para las gráficas circulares de municipios
        $municipioCounts = $municipios->map(function ($municipio) {
            return User::where('municipio', $municipio)->count();
        });

        // Pasamos los datos a la vista
        return view('admin.usuarios', compact('usuarios', 'roles', 'municipios', 'roleCounts', 'municipioCounts'));
    }

    public function show($id)
    {
        // Encuentra el usuario o muestra un error 404 si no se encuentra
        $usuario = User::findOrFail($id);

        // Retorna la vista de detalles del usuario
        return view('profile.show_user', compact('usuario'));
    }

    public function destroy($id)
    {
        // Encuentra al usuario por ID o muestra un error 404 si no se encuentra
        $usuario = User::findOrFail($id);

        // Elimina al usuario
        $usuario->delete();

        // Redirige de vuelta con un mensaje de éxito
        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado con éxito.');
    }
}
    