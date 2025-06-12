@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Bienvenido al Panel de Control</h1>

    <!-- Primera fila: 4 tarjetas -->
    <div class="row">
        <!-- Nuevos registros hoy -->
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $nuevosRegistros }}</h3>
                    <p>Nuevos Registros Hoy</p>
                </div>
                <div class="icon">
                    <i class="fas fa-database"></i>
                </div>
                <a href="{{ route('residuos.index') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total de residuos -->
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalResiduos }}</h3>
                    <p>Total de Residuos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dumpster"></i>
                </div>
                <a href="{{ route('residuos.index') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Peso total reciclado -->
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($pesoTotalReciclado, 2) }} kg</h3>
                    <p>Peso Total Reciclado</p>
                </div>
                <div class="icon">
                    <i class="fas fa-weight"></i>
                </div>
                <a href="{{ route('residuos.index') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Categorías registradas -->
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $cantidadCategorias }}</h3>
                    <p>Categorías Registradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
                <a href="{{ route('categorias.index') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Segunda fila: 2 tarjetas (mismo tamaño que arriba) -->
    <div class="row">
        <!-- Residuos últimos 15 días -->
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $residuosUltimos15Dias }}</h3>
                    <p>Residuos en los últimos 15 días</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{ route('reportes.residuos15dias') }}" class="small-box-footer">Ver historial <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Último residuo registrado -->
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $ultimoResiduo->created_at->format('d/m/Y') }}</h3>
                    <p>Último Residuo Registrado</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('residuos.show', $ultimoResiduo->id) }}" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Botón historial -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('reportes.historial') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-clock"></i> Ver Historial de Residuos
            </a>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="row">
        <div class="col-md-8">
            <canvas id="chartCategorias"></canvas>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const labels = @json($datos->pluck('nombre'));
    const dataPesos = @json($datos->pluck('total_peso'));

    const ctx = document.getElementById('chartCategorias').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Peso por Categoría (kg)',
                data: dataPesos,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush


