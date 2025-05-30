<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Botón de menú lateral -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('dashboard') }}" class="nav-link">Inicio</a>
    </li>
  </ul>

  <!-- Opciones de usuario -->
  <ul class="navbar-nav ml-auto">
    <!-- Botón de logout -->
    <li class="nav-item">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link nav-link">Cerrar sesión</button>
      </form>
    </li>
  </ul>
</nav>
