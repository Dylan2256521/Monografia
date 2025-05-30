<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Residuo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    // Nuevos registros de hoy
    $nuevosRegistros = Residuo::whereDate('created_at', today())->count();

    // Peso total por categoría (para el gráfico)
    $datos = DB::table('residuos')
        ->join('categorias', 'residuos.categoria_id', '=', 'categorias.id')
        ->select('categorias.nombre', DB::raw('SUM(residuos.peso) as total_peso'))
        ->groupBy('categorias.nombre')
        ->get();

    // Total de residuos
    $totalResiduos = DB::table('residuos')->count();

    // Peso total reciclado
    $pesoTotalReciclado = DB::table('residuos')->sum('peso');

    // Cantidad de categorías
    $cantidadCategorias = DB::table('categorias')->count();
    
    // Residuos de los últimos 15 días
    $residuosUltimos15Dias = Residuo::where('created_at', '>=', Carbon::now()->subDays(15))->count();

    // Último residuo registrado
    $ultimoResiduo = Residuo::latest()->first();

    return view('dashboard', compact(
        'nuevosRegistros',
        'datos',
        'totalResiduos',
        'pesoTotalReciclado',
        'cantidadCategorias',
        'residuosUltimos15Dias',
        'ultimoResiduo'
    ));
}

}
