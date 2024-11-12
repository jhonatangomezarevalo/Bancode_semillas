<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Inventory; // Modelo de inventarios (semillas)
use DB;

class AdminController extends Controller
{
    public function index()
    {
        // Usuarios por Municipio
        $usuariosPorMunicipio = DB::table('users')
            ->select(DB::raw('municipio, count(*) as total'))
            ->groupBy('municipio')
            ->get();

        // Semillas por Tipo
        $semillasPorTipo = DB::table('inventories')
            ->select(DB::raw('type, count(*) as total'))
            ->groupBy('type')
            ->get();

        // Usuarios por Rol
        $usuariosPorRol = DB::table('users')
            ->select(DB::raw('role_id, count(*) as total'))
            ->groupBy('role_id')
            ->get();

        // Análisis automático de datos

        // Análisis de Usuarios por Municipio
        $totalUsuarios = $usuariosPorMunicipio->sum('total');
        $municipioMayorUsuarios = $usuariosPorMunicipio->sortByDesc('total')->first();
        $analisisUsuariosPorMunicipio = $municipioMayorUsuarios 
            ? "El municipio con mayor cantidad de usuarios es {$municipioMayorUsuarios->municipio} con {$municipioMayorUsuarios->total} usuarios, representando aproximadamente " . round(($municipioMayorUsuarios->total / $totalUsuarios) * 100, 2) . "% del total."
            : "No hay datos suficientes para un análisis de usuarios por municipio.";

        // Análisis de Semillas por Tipo
        $tipoMasSemillas = $semillasPorTipo->sortByDesc('total')->first();
        $analisisSemillasPorTipo = $tipoMasSemillas
            ? "El tipo de semilla más común es {$tipoMasSemillas->type} con {$tipoMasSemillas->total} registros."
            : "No hay datos suficientes para un análisis de semillas por tipo.";

        // Análisis de Usuarios por Rol
        $rolMasFrecuente = $usuariosPorRol->sortByDesc('total')->first();
        $analisisUsuariosPorRol = $rolMasFrecuente
            ? "El rol de usuario más frecuente es el rol con ID {$rolMasFrecuente->role_id}, con {$rolMasFrecuente->total} usuarios registrados."
            : "No hay datos suficientes para un análisis de usuarios por rol.";

        // Enviar datos y análisis a la vista
        return view('admin.index', compact(
            'usuariosPorMunicipio', 
            'semillasPorTipo', 
            'usuariosPorRol',
            'analisisUsuariosPorMunicipio', 
            'analisisSemillasPorTipo', 
            'analisisUsuariosPorRol'
        ));
    }
}
