@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Residuo</h2>

    <form action="{{ route('residuos.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="nombre">Nombre del residuo</label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
        </div>

        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="categoria_id">Categoría</label>
            <select name="categoria_id" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="peso">Peso (kg)</label>
            <input type="number" step="0.01" name="peso" class="form-control" required value="{{ old('peso') }}">
        </div>

        <div class="form-group mb-3">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="en espera" {{ old('estado') == 'en espera' ? 'selected' : '' }}>En espera</option>
                <option value="reciclado" {{ old('estado') == 'reciclado' ? 'selected' : '' }}>Reciclado</option>
            </select>
        </div>
        <div class="form-check">
  <input type="checkbox" class="form-check-input" id="inflamable" name="inflamable" value="1">
  <label class="form-check-label" for="inflamable">Inflamable</label>
</div>

<div class="form-check">
  <input type="checkbox" class="form-check-input" id="peligroso" name="peligroso" value="1">
  <label class="form-check-label" for="peligroso">Peligroso</label>
</div>

<div class="form-check">
  <input type="checkbox" class="form-check-input" id="biodegradable" name="biodegradable" value="1">
  <label class="form-check-label" for="biodegradable">Biodegradable</label>
</div>

        <!-- Mapa interactivo -->
        <div class="form-group mb-3">
            <label for="ubicacion">Ubicación</label>
            <div id="map" style="height: 300px; width: 100%; border-radius: 10px;"></div>
        </div>

        <!-- Campos ocultos para latitud y longitud -->
        <input type="hidden" name="lat" id="lat" value="{{ old('lat', 11.377) }}">
        <input type="hidden" name="lng" id="lng" value="{{ old('lng', -72.241) }}">

        <button type="submit" class="btn btn-success">Registrar</button>
    </form>
</div>

{{-- Script Leaflet --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Valores iniciales (usando old() si los hay)
        var initialLat = parseFloat(document.getElementById('lat').value);
        var initialLng = parseFloat(document.getElementById('lng').value);

        var map = L.map('map').setView([initialLat, initialLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

        // Establecer valores iniciales
        function updateLatLng(lat, lng) {
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        }

        updateLatLng(initialLat, initialLng);

        let markerMoved = false;

        marker.on('dragend', function (e) {
            var pos = marker.getLatLng();
            updateLatLng(pos.lat, pos.lng);
            markerMoved = true;
        });

        // Intentar obtener ubicación del usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                if (!markerMoved) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    updateLatLng(lat, lng);
                }
            });
        } else {
            console.warn("Geolocalización no soportada.");
        }
    });
</script>
@endsection
