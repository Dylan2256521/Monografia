@extends('layouts.app')

@section('title', 'Historial de Actividad')

@section('content')
<div class="container">
    <h1 class="mb-4">Historial de Actividad</h1>

    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <label for="desde" class="form-label">Desde</label>
                <input type="date" name="desde" id="desde" class="form-control" value="{{ request('desde') }}">
            </div>
            <div class="col-md-3">
                <label for="hasta" class="form-label">Hasta</label>
                <input type="date" name="hasta" id="hasta" class="form-control" value="{{ request('hasta') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
        </div>
    </form>

    @forelse($groupedLogs as $evento => $grupo)
        @php
            $color = match($evento) {
                'Agregado' => 'success',
                'Editado' => 'warning',
                'Eliminado' => 'danger',
                default => 'secondary',
            };
            $icon = match($evento) {
                'Agregado' => 'fa-plus-circle',
                'Editado' => 'fa-edit',
                'Eliminado' => 'fa-trash',
                default => 'fa-info-circle',
            };
        @endphp

        <div class="card border-{{ $color }} shadow mb-4">
            <div class="card-header bg-{{ $color }} text-white fw-bold">
                <i class="fas {{ $icon }}"></i> {{ $evento }}
            </div>
            <ul class="list-group list-group-flush">
                @foreach($grupo as $log)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $log->causer?->name ?? 'Sistema' }}</strong>
                            {{ strtolower($evento) }}
                            <strong>{{ class_basename($log->subject_type) }}</strong>
                            con ID <strong>{{ $log->subject_id }}</strong>
                        </div>
                        <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i:s') }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <div class="alert alert-info">No se encontraron registros.</div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $logs->appends(request()->query())->links() }}
    </div>
</div>
@endsection
