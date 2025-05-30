<!DOCTYPE html> 
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Gestión de Reciclaje') }} - @yield('title')</title>

  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  @vite(['resources/css/app.css']) {{-- Tus estilos de Laravel --}}
  @stack('styles') {{-- Por si alguna vista quiere meter CSS personalizado --}}
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    @include('profile.partials.navbar')

    <!-- Sidebar -->
    @include('profile.partials.sidebar')

    <!-- Contenido principal -->
    <div class="content-wrapper p-3">
      @yield('content')
    </div>
  </div>

  <!-- JS de librerías externas al final del body para que no bloqueen carga -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  @vite(['resources/js/app.js']) {{-- Tu JS propio con Laravel --}}
  @stack('scripts') {{-- Aquí sí funcionará correctamente el @push desde otras vistas --}}
</body>
</html>
