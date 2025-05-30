<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Marca -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <i class="fas fa-recycle ml-3 mr-2"></i>
    <span class="brand-text font-weight-light">Reciclaje</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Usuario -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Menú -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Residuos -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-dumpster"></i>
            <p>
              Residuos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview pl-3">
            <li class="nav-item">
              <a href="{{ route('residuos.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon text-success"></i>
                <p>Registrar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('residuos.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon text-info"></i>
                <p>Listar</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Categorías -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tags"></i>
            <p>
              Categorías
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview pl-3">
            <li class="nav-item">
              <a href="{{ route('categorias.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon text-info"></i>
                <p>Listar</p>
              </a>
            </li>

          </ul>
        </li>
        <!-- Reportes -->
<li class="nav-item has-treeview">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-chart-pie"></i>
    <p>
      Reportes
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview pl-3">
    <li class="nav-item">
      <a href="{{ route('reportes.peso_categoria') }}" class="nav-link">
        <i class="far fa-circle nav-icon text-warning"></i>
        <p>Peso por Categoría</p>
      </a>
    </li>
    <li class="nav-item">
              <a href="{{ route('reportes.tipos_residuos') }}" class="nav-link">
              <i class="far fa-circle nav-icon text-danger"></i>
                <p>Tipos de Residuos</p>
                </a>
              </li>
              <li class="nav-item">
                
    <a class="nav-link" href="{{ route('reportes.historial') }}">
        <i class="fas fa-clock"></i>
        Historial de Registros
    </a>
</li>

  </ul>
</li>

<!-- Historial -->
<li class="nav-item">
  <a href="{{ route('activity.index') }}" class="nav-link">
    <i class="nav-icon fas fa-history text-light"></i>
    <p>Historial</p>
  </a>
</li>


      </ul>
    </nav>
  </div>
</aside>
