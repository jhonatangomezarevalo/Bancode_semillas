<?php

// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\User;  // Asegúrate de tener el modelo User
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
        $filter = $request->input('filter', 'day');  // Valor predeterminado 'day'

        // Consultar los registros de usuarios basados en el filtro
        $userRegistrations = DB::table('users')
            ->select(DB::raw('COUNT(*) as count'), DB::raw('DATE(created_at) as label'))
            ->when($filter == 'day', function ($query) {
                return $query->groupBy(DB::raw('DATE(created_at)'));
            })
            ->when($filter == 'week', function ($query) {
                return $query->groupBy(DB::raw('WEEK(created_at)'));
            })
            ->when($filter == 'month', function ($query) {
                return $query->groupBy(DB::raw('MONTH(created_at)'));
            })
            ->when($filter == 'year', function ($query) {
                return $query->groupBy(DB::raw('YEAR(created_at)'));
            })
            ->get();

        // Calcular estadísticas del análisis
        $totalRegistrations = $userRegistrations->sum('count');
        $averageRegistrations = $userRegistrations->count() > 0 ? $totalRegistrations / $userRegistrations->count() : 0;

        // Analizar la tendencia de crecimiento
        $analysis = "En total, se han registrado {$totalRegistrations} usuarios. ";
        $analysis .= $userRegistrations->count() > 1 ? "El promedio de registros por {$filter} es de {$averageRegistrations} usuarios." : "No hay suficientes datos para calcular un promedio.";

        // También podrías agregar una simple comparación con el mes pasado o semana pasada si los datos lo permiten
        if ($filter == 'month' && $userRegistrations->count() > 1) {
            $previousMonthData = DB::table('users')
                ->select(DB::raw('COUNT(*) as count'), DB::raw('DATE(created_at) as label'))
                ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $previousMonthTotal = $previousMonthData->sum('count');
            $growth = $previousMonthTotal > 0 ? (($totalRegistrations - $previousMonthTotal) / $previousMonthTotal) * 100 : 0;

            $analysis .= " En comparación con el mes pasado, hubo un " . round($growth, 2) . "% de crecimiento en los registros.";
        }

        return view('admin.report', compact('userRegistrations', 'filter', 'analysis'));
    }
}
