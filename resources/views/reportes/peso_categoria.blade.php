@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Reporte: Peso por Categoría</h2>

    <div class="card">
        <div class="card-body">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Categoría</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Peso Total (Kg)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $item->nombre }}</td>
                            <td style="padding: 10px; border: 1px solid #dee2e6;">{{ number_format($item->total_peso, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
