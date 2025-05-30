@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Residuo</h2>

    <form action="{{ route('residuos.update', $residuo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nombre">Nombre del residuo</label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre', $residuo->nombre) }}">
        </div>

        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $residuo->descripcion) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="categoria_id">Categoría</label>
            <select name="categoria_id" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $residuo->categoria_id) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="peso">Peso (kg)</label>
            <input type="number" step="0.01" name="peso" class="form-control" required value="{{ old('peso', $residuo->peso) }}">
        </div>

        <div class="form-group mb-3">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="en espera" {{ old('estado', $residuo->estado) == 'en espera' ? 'selected' : '' }}>En espera</option>
                <option value="reciclado" {{ old('estado', $residuo->estado) == 'reciclado' ? 'selected' : '' }}>Reciclado</option>
            </select>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="inflamable" name="inflamable" value="1"
           {{ $residuo->inflamable ? 'checked' : '' }}>
             <label class="form-check-label" for="inflamable">Inflamable</label>
        </div>

        <div class="form-check">
        <input type="checkbox" class="form-check-input" id="peligroso" name="peligroso" value="1"
                {{ $residuo->peligroso ? 'checked' : '' }}>
        <label class="form-check-label" for="peligroso">Peligroso</label>
        </div>

        <div class="form-check">
        <input type="checkbox" class="form-check-input" id="biodegradable" name="biodegradable" value="1"
                {{ $residuo->biodegradable ? 'checked' : '' }}>
        <label class="form-check-label" for="biodegradable">Biodegradable</label>
        </div>


        <!-- Mapa interactivo -->
        <div class="form-group mb-3">
            <label for="ubicacion">Ubicación</label>
            <div id="map" style="height: 300px; width: 100%; border-radius: 10px;"></div>
        </div>

        <!-- Campos ocultos para latitud y longitud -->
        <input type="hidden" name="lat" id="lat" value="{{ old('lat', $residuo->lat ?? 11.377) }}">
        <input type="hidden" name="lng" id="lng" value="{{ old('lng', $residuo->lng ?? -72.241) }}">

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('residuos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

{{-- Script Leaflet --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var initialLat = parseFloat(document.getElementById('lat').value);
        var initialLng = parseFloat(document.getElementById('lng').value);

        var map = L.map('map').setView([initialLat, initialLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

        function updateLatLng(lat, lng) {
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        }

        updateLatLng(initialLat, initialLng);

        marker.on('dragend', function (e) {
            var pos = marker.getLatLng();
            updateLatLng(pos.lat, pos.lng);
        });
    });
</script>
@endsection
