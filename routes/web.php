<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResiduoController; // 👈 añade esto
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController; // 👈 añade esto
use App\Http\Controllers\ReportesController; // 👈 añade esto
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de residuos (CRUD)
    Route::resource('/residuos', ResiduoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::get('/reportes/peso-categoria', [App\Http\Controllers\ReportesController::class, 'pesoPorCategoria'])->name('reportes.peso_categoria');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
    Route::get('/actividad', [ActivityLogController::class, 'index'])->name('activity.index');
    Route::get('/reportes/tipos-residuos', [App\Http\Controllers\ReportesController::class, 'tiposResiduos'])->name('reportes.tipos_residuos');
    Route::get('/reportes/historial', [ReportesController::class, 'historial'])->name('reportes.historial');
    Route::get('/reportes/historial/pdf', [ReportesController::class, 'descargarPDF'])->name('reportes.historial.pdf');
    Route::get('/reportes/residuos-15-dias', [ReportesController::class, 'residuosCada15Dias'])->name('reportes.residuos15dias');


});

require __DIR__.'/auth.php';
