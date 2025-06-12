<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Residuo;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; 

class ReportesController extends Controller
{
    public function pesoPorCategoria()
{
    // lógica para consultar el peso agrupado por categoría
    $datos = Residuo::select('categorias.nombre', DB::raw('SUM(residuos.peso) as total_peso'))
            ->join('categorias', 'residuos.categoria_id', '=', 'categorias.id')
            ->groupBy('categorias.nombre')
            ->get();

        return view('reportes.peso_categoria', compact('datos'));
}

public function tiposResiduos()
{
    $peligrosos = Residuo::where('peligroso', true)->count();
    $inflamables = Residuo::where('inflamable', true)->count();
    $biodegradables =Residuo::where('biodegradable', true)->count();

    return view('reportes.tipos_residuos', compact('peligrosos', 'inflamables', 'biodegradables'));
}

public function historial(Request $request)
{
    $query = Residuo::with('categoria');

    if ($request->filled('desde') && $request->filled('hasta')) {
        $query->whereBetween('created_at', [$request->desde, $request->hasta]);
    }

    $residuos = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('reportes.historial', compact('residuos'));
}

public function descargarPDF(Request $request)
{
    $query = Residuo::with('categoria');

    // Usar 'desde' y 'hasta' para filtrar igual que en la vista
    if ($request->filled('desde') && $request->filled('hasta')) {
        $query->whereBetween('created_at', [$request->desde, $request->hasta]);
    }

    $residuos = $query->orderByDesc('created_at')->get();

    $pdf = Pdf::loadView('reportes.pdf.historial_residuos', compact('residuos'));

    return $pdf->download('historial_residuos.pdf');
}


public function residuosCada15Dias()
{
    $residuos = Residuo::select(
            DB::raw("FLOOR(DATEDIFF(created_at, (SELECT MIN(created_at) FROM residuos)) / 15) AS grupo_15dias"),
            DB::raw("MIN(created_at) as fecha_inicio"),
            DB::raw("MAX(created_at) as fecha_fin"),
            DB::raw("COUNT(*) as cantidad"),
            DB::raw("SUM(peso) as total_peso")
        )
        ->groupBy('grupo_15dias')
        ->orderBy('grupo_15dias')
        ->get()
        ->map(function ($item) {
            $item->rango = \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y');
            return $item;
        });

    return view('reportes.residuos_15_dias', compact('residuos'));
}




}
