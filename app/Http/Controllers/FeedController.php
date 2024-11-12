<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory; // Asegúrate de que esto esté importado
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    /**
     * Muestra el feed principal con las publicaciones más recientes.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Obtener el filtro de disponibilidad (si está presente)
        $disponibilidad = $request->input('disponibilidad', 'sí'); // Por defecto, filtra por "sí"

        // Obtener las semillas o publicaciones del modelo Inventory que estén disponibles (filtradas por 'sí' en 'disponible')
        $inventories = Inventory::where('disponible', $disponibilidad) // Filtra por disponibilidad "sí" o "no"
            ->latest()
            ->paginate(10); // Cambiar 'Post' por 'Inventory'
        
        return view('feed.index', compact('inventories', 'disponibilidad')); // Pasar las publicaciones a la vista
    }

    /**
     * Muestra un inventario específico basado en su ID.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Buscar el inventario específico o lanzar un error si no se encuentra
        $inventory = Inventory::findOrFail($id);
        
        return view('feed.show', compact('inventory'));  // Asegúrate de que la vista sea 'feed.show'
    }

    /**
     * Realiza una búsqueda de semillas y perfiles de usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $disponibilidad = $request->input('disponibilidad', 'sí'); // Filtrar por disponibilidad si se pasa como parámetro

        // Buscar en los inventarios (semillas) con disponibilidad "sí" o "no"
        $inventories = Inventory::with('user') // Carga la relación con el usuario
            ->where('disponible', $disponibilidad) // Filtra por disponibilidad (sí/no)
            ->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('type', 'like', "%{$query}%")
                    ->orWhere('base_info', 'like', "%{$query}%")
                    ->orWhere('adaptable_info', 'like', "%{$query}%")
                    ->orWhere('traceability_info', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(10);

        // Buscar en los perfiles de usuarios
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();

        // Pasar ambos resultados a la vista
        return view('feed.index', compact('inventories', 'users', 'query', 'disponibilidad'));
    }
}
