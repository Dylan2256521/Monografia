@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Historial de Actividad</h1>

    @foreach($groupedLogs as $event => $group)
        @php
            $color = match($event) {
                'created' => 'success',
                'updated' => 'warning',
                'deleted' => 'danger',
                default => 'secondary',
            };
            $icon = match($event) {
                'created' => 'fa-plus-circle',
                'updated' => 'fa-edit',
                'deleted' => 'fa-trash',
                default => 'fa-info-circle',
            };
        @endphp

        <div class="card border-{{ $color }} shadow mb-4">
            <div class="card-header bg-{{ $color }} text-white">
                <i class="fas {{ $icon }}"></i> {{ ucfirst($event) }}
            </div>
            <ul class="list-group list-group-flush">
                @foreach($group as $log)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $log->causer?->name ?? 'Sistema' }}</strong>
                            {{ $event }} 
                            <strong>{{ class_basename($log->subject_type) }}</strong>
                            con ID <strong>{{ $log->subject_id }}</strong>
                        </div>
                        <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i:s') }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $logs->links() }}
    </div>
</div>
@endsection
