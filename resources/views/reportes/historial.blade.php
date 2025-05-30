@extends('layouts.app')

@section('title', 'Historial de Registros')

@section('content')
<div class="container">
    <h1 class="mb-4">Historial de Residuos</h1>

    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="desde">Desde</label>
                <input type="date" name="desde" id="desde" class="form-control" value="{{ request('desde') }}">
            </div>
            <div class="col-md-4">
                <label for="hasta">Hasta</label>
                <input type="date" name="hasta" id="hasta" class="form-control" value="{{ request('hasta') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
            <div class="col-md-4">
            <a href="{{ route('reportes.historial.pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}" class="btn btn-danger">
                Descargar PDF
            </a>
            </div>

        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Peso</th>
                <th>Peligroso</th>
                <th>Inflamable</th>
                <th>Biodegradable</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($residuos as $residuo)
                <tr>
                    <td>{{ $residuo->id }}</td>
                    <td>{{ $residuo->nombre }}</td>
                    <td>{{ $residuo->categoria->nombre ?? 'N/A' }}</td>
                    <td>{{ $residuo->peso }} kg</td>
                    <td>{{ $residuo->peligroso ? 'Sí' : 'No' }}</td>
                    <td>{{ $residuo->inflamable ? 'Sí' : 'No' }}</td>
                    <td>{{ $residuo->biodegradable ? 'Sí' : 'No' }}</td>
                    <td>{{ $residuo->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $residuos->withQueryString()->links() }}
</div>
@endsection
