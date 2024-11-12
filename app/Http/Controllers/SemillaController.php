<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemillaController extends Controller
{
    // Método para mostrar todas las semillas con la información relacionada de los usuarios
    public function index(Request $request)
    {
        // Realizamos una consulta a la tabla `inventories` y nos unimos con la tabla `users`
        $query = Inventory::join('users', 'inventories.user_id', '=', 'users.id')
            ->select(
                'users.name as usuario_nombre',
                'inventories.name as nombre_semilla',  // 'name' de semilla
                'users.municipio',
                'inventories.type',
                'inventories.base_info',  // 'base_info' ahora es parte de la consulta
                'inventories.disponible',
                'inventories.id as inventario_id'
            );

        // Filtrar por nombre de semilla
        if ($request->has('nombre') && $request->nombre != '') {  // Corregido 'name' a 'nombre'
            $query->where('inventories.name', 'like', '%' . $request->nombre . '%');
        }

        // Filtrar por municipio
        if ($request->has('municipio') && $request->municipio != '') {
            $query->where('users.municipio', $request->municipio);
        }

        // Filtrar por disponibilidad
        if ($request->has('disponible') && $request->disponible != '') {
            $query->where('inventories.disponible', $request->disponible);
        }

        // Obtener los resultados
        $semillas = $query->get();  // Aquí se obtiene la información de la base de datos

        // Obtener la lista de municipios para el filtro
        $municipios = User::distinct()->pluck('municipio');

        // Consulta de semillas por municipio
        $semillasPorMunicipio = DB::table('users')
            ->join('inventories', 'inventories.user_id', '=', 'users.id')  // Unión de tablas
            ->select(DB::raw('users.municipio, inventories.name, count(*) as count'))
            ->groupBy('users.municipio', 'inventories.name')
            ->get();
    
        // Consulta de semillas por municipio y tipo
        $semillasPorTipo = DB::table('users')
            ->join('inventories', 'inventories.user_id', '=', 'users.id')  // Unión de tablas
            ->select(DB::raw('users.municipio, inventories.type, count(*) as count'))
            ->groupBy('users.municipio', 'inventories.type')
            ->get();

        // Datos para las gráficas
        $labels = $semillasPorTipo->pluck('type')->unique();  // Tipos únicos de semillas
        $countsPorTipo = $semillasPorTipo->groupBy('type')->map(function($group) {
            return $group->sum('count');
        });

        // Datos de disponibilidad
        $disponibilidadCounts = $semillas->groupBy('disponible')->map->count();

        // Pasamos estos datos a la vista
        return view('admin.semillas', [
            'semillasPorMunicipio' => $semillasPorMunicipio,
            'semillasPorTipo' => $semillasPorTipo,
            'semillas' => $semillas,   // Asegúrate de pasar la lista de semillas
            'municipios' => $municipios, // Lista de municipios para el filtro
            'labels' => $labels,        // Para las gráficas
            'countsPorTipo' => $countsPorTipo, // Contadores por tipo de semilla
            'disponibilidadCounts' => $disponibilidadCounts // Contadores de disponibilidad
        ]);
    }

    // Método para eliminar una semilla del inventario
    public function destroy($id)
    {
        // Buscar la semilla por el ID
        $semilla = Inventory::findOrFail($id);

        // Eliminar la semilla
        $semilla->delete();

        return redirect()->route('admin.semillas')->with('success', 'Semilla eliminada correctamente');
    }
}
