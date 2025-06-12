@extends('layouts.app')

@section('title', 'Registrar Residuo')

@section('content')
<div class="container">
    <h2 class="mb-4 animate__animated animate__fadeInDown">Registrar Residuo</h2>

    <form action="{{ route('residuos.store') }}" method="POST" id="residuoForm" novalidate>
        @csrf

        <div class="form-group mb-3">
            <label for="nombre" class="animate__animated animate__fadeInLeft">Nombre del residuo</label>
            <input 
                type="text" name="nombre" class="form-control animate__animated" required 
                value="{{ old('nombre') }}" 
                id="nombre"
                onfocus="animateFocus(this)" 
                onblur="animateBlur(this)">
            @error('nombre')
                <small class="text-danger animate__animated animate__shakeX">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="descripcion" class="animate__animated animate__fadeInLeft animate__delay-1s">Descripción</label>
            <textarea 
                name="descripcion" class="form-control animate__animated" 
                id="descripcion"
                onfocus="animateFocus(this)" 
                onblur="animateBlur(this)">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <small class="text-danger animate__animated animate__shakeX">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="categoria_id" class="animate__animated animate__fadeInLeft animate__delay-2s">Categoría</label>
            <select 
                name="categoria_id" class="form-control" required
                id="categoria_id"
                {{-- Sin onfocus/onblur para no animar selects --}}
            >
                <option value="">Seleccione una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <small class="text-danger animate__animated animate__shakeX">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="peso" class="animate__animated animate__fadeInLeft animate__delay-3s">Peso (kg)</label>
            <input 
                type="number" step="0.01" name="peso" class="form-control animate__animated" required
                id="peso"
                value="{{ old('peso') }}" 
                onfocus="animateFocus(this)" 
                onblur="animateBlur(this)">
            @error('peso')
                <small class="text-danger animate__animated animate__shakeX">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="estado" class="animate__animated animate__fadeInLeft animate__delay-4s">Estado</label>
            <select 
                name="estado" class="form-control" required
                id="estado"
                {{-- Sin onfocus/onblur para no animar selects --}}
            >
                <option value="en espera" {{ old('estado') == 'en espera' ? 'selected' : '' }}>En espera</option>
                <option value="reciclado" {{ old('estado') == 'reciclado' ? 'selected' : '' }}>Reciclado</option>
            </select>
            @error('estado')
                <small class="text-danger animate__animated animate__shakeX">{{ $message }}</small>
            @enderror
        </div>

        {{-- Checkboxes animados con fadeInUp más rápido --}}
        <div class="form-check animate__animated animate__fadeInUp animate__faster animate__delay-2s">
            <input type="checkbox" class="form-check-input" id="inflamable" name="inflamable" value="1" {{ old('inflamable') ? 'checked' : '' }}>
            <label class="form-check-label" for="inflamable">Inflamable</label>
        </div>

        <div class="form-check animate__animated animate__fadeInUp animate__faster animate__delay-3s">
            <input type="checkbox" class="form-check-input" id="peligroso" name="peligroso" value="1" {{ old('peligroso') ? 'checked' : '' }}>
            <label class="form-check-label" for="peligroso">Peligroso</label>
        </div>

        <div class="form-check mb-3 animate__animated animate__fadeInUp animate__faster animate__delay-4s">
            <input type="checkbox" class="form-check-input" id="biodegradable" name="biodegradable" value="1" {{ old('biodegradable') ? 'checked' : '' }}>
            <label class="form-check-label" for="biodegradable">Biodegradable</label>
        </div>

        <div class="form-group mb-3 animate__animated animate__fadeInUp animate__faster animate__delay-5s">
            <label for="ubicacion">Ubicación</label>
            <div id="map" style="height: 300px; width: 100%; border-radius: 10px; opacity: 0;"></div>
        </div>

        <input type="hidden" name="lat" id="lat" value="{{ old('lat', 11.377) }}">
        <input type="hidden" name="lng" id="lng" value="{{ old('lng', -72.241) }}">

        <button type="submit" class="btn btn-success animate__animated animate__fadeInUp animate__faster">Registrar</button>
    </form>
</div>
@endsection

@push('styles')
    {{-- Animate.css CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush

@push('scripts')
<script>
function animateFocus(element) {
    if(element.tagName.toLowerCase() === 'select') return; // No animar selects
    element.classList.add('animate__pulse');
}
function animateBlur(element) {
    element.classList.remove('animate__pulse');
}

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar mapa Leaflet
    var initialLat = parseFloat(document.getElementById('lat').value);
    var initialLng = parseFloat(document.getElementById('lng').value);

    var map = L.map('map').setView([initialLat, initialLng], 13);

    // Fade in del mapa rápido
    let mapDiv = document.getElementById('map');
    let opacity = 0;
    let interval = setInterval(() => {
        opacity += 0.1;
        if(opacity >= 1) {
            opacity = 1;
            clearInterval(interval);
        }
        mapDiv.style.opacity = opacity;
    }, 30);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

    function updateLatLng(lat, lng) {
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;

        // Animar marcador al moverse
        let markerIcon = marker._icon;
        markerIcon.classList.add('animate__rubberBand');
        setTimeout(() => markerIcon.classList.remove('animate__rubberBand'), 800);
    }

    updateLatLng(initialLat, initialLng);

    let markerMoved = false;

    marker.on('dragend', function () {
        var pos = marker.getLatLng();
        updateLatLng(pos.lat, pos.lng);
        markerMoved = true;
    });

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

    // Validación simple con animación y SweetAlert2
    const form = document.getElementById('residuoForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        let valid = true;

        // Validar campo nombre
        const nombre = form.nombre;
        if (!nombre.value.trim()) {
            valid = false;
            nombre.classList.add('animate__headShake', 'is-invalid');
            setTimeout(() => nombre.classList.remove('animate__headShake'), 800);
        } else {
            nombre.classList.remove('is-invalid');
        }

        // Puedes agregar más validaciones aquí...

        if(valid) {
            Swal.fire({
                icon: 'success',
                title: '¡Registro exitoso!',
                text: 'El residuo ha sido registrado correctamente.',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
            }).then(() => {
                form.submit();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, completa todos los campos obligatorios.',
            });
        }
    });
});
</script>
@endpush
