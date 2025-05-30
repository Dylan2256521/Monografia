@extends('layouts.app') {{-- o el layout que uses --}}

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Residuos Procesados Cada 15 Días</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Rango de Fechas</th>
                    <th>Cantidad de Residuos</th>
                    <th>Peso Total (kg)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($residuos as $index => $registro)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $registro->rango }}</td>
                    <td>{{ $registro->cantidad }}</td>
                    <td>{{ number_format($registro->total_peso, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No hay datos disponibles</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
