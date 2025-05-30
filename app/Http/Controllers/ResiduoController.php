<?php

namespace App\Http\Controllers;
use App\Models\Residuo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Categoria;

class ResiduoController extends Controller
{
    public function index()
    {
        $residuos = Residuo::all();
        return view('residuos.index', compact('residuos'));
    }



    public function create()
    {
        $categorias = Categoria::all();
        return view('residuos.create', compact('categorias'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'categoria_id' => 'required|exists:categorias,id',
        'peso' => 'required|numeric|min:0',
        'estado' => 'required|string',
        'lat' => 'nullable|numeric',
        'lng' => 'nullable|numeric',
        'inflamable' => 'boolean',
        'peligroso' => 'boolean',
        'biodegradable' => 'boolean',
    ]);

    $validated['user_id'] = Auth::id(); // Asegúrate de agregar el user_id

    Residuo::create($validated); // Guarda en la BD

    return redirect()->route('dashboard')->with('success', 'Residuo registrado correctamente.');
}
    public function edit($id)
{
    $residuo = Residuo::findOrFail($id);
    $categorias = Categoria::all();
    return view('residuos.edit', compact('residuo', 'categorias'));
}


    public function update(Request $request, $id)
{
    $residuo = Residuo::findOrFail($id);

    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'categoria_id' => 'required|exists:categorias,id',
        'peso' => 'required|numeric|min:0',
        'estado' => 'required|string',
        'lat' => 'nullable|numeric',
        'lng' => 'nullable|numeric',
        'inflamable' => 'boolean',
        'peligroso' => 'boolean',
        'biodegradable' => 'boolean',
        
    
    ]);

    $residuo->update($validatedData);

    return redirect()->route('residuos.index')->with('success', 'Residuo actualizado correctamente.');
}



public function destroy($id)
{
    $residuo = Residuo::findOrFail($id);
    $residuo->delete();

    return redirect()->route('residuos.index')->with('success', 'Residuo eliminado correctamente.');
}





}
