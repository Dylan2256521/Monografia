@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-4">Listado de Residuos</h3>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table id="tabla-residuos" class="table table-striped table-bordered m-0">
          <thead class="thead-dark">
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Categoría</th>
              <th>Peso (kg)</th>
              <th>Estado</th>
              <th class="text-center">Características</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($residuos as $residuo)
              <tr>
                <td>{{ $residuo->nombre }}</td>
                <td>{{ $residuo->descripcion }}</td>
                <td>{{ $residuo->categoria->nombre }}</td>
                <td>{{ $residuo->peso }}</td>
                <td>
                  <span class="badge badge-{{ $residuo->estado === 'reciclado' ? 'success' : 'secondary' }}">
                    {{ ucfirst($residuo->estado) }}
                  </span>
                </td>
                <td class="text-center">
                  @if ($residuo->inflamable)
                    <span class="badge badge-danger" title="Inflamable">
                      <i class="fas fa-fire"></i>
                    </span>
                  @endif
                  @if ($residuo->peligroso)
                    <span class="badge badge-warning" title="Peligroso">
                      <i class="fas fa-skull-crossbones"></i>
                    </span>
                  @endif
                  @if ($residuo->biodegradable)
                    <span class="badge badge-success" title="Biodegradable">
                      <i class="fas fa-leaf"></i>
                    </span>
                  @endif
                </td>
                <td>
                  <div class="d-flex flex-wrap justify-content-center gap-1">
                    <a href="{{ route('residuos.edit', $residuo->id) }}" class="btn btn-sm btn-warning mr-1 mb-1">
                      <i class="fas fa-edit"></i>
                    </a>

                    <form class="d-inline delete-form" data-id="{{ $residuo->id }}" method="POST" action="{{ route('residuos.destroy', $residuo->id) }}">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger btn-sm show-confirm mr-1">Eliminar</button>
                    </form>

                    <button type="button" class="btn btn-sm btn-info mb-1"
                            data-toggle="modal"
                            data-target="#mapModal-{{ $residuo->id }}"
                            data-lat="{{ $residuo->lat }}"
                            data-lng="{{ $residuo->lng }}"
                            data-nombre="{{ $residuo->nombre }}"
                            data-map="map-{{ $residuo->id }}">
                      Ver Ubicación
                    </button>
                  </div>

                  <!-- Modal para el mapa -->
                  <div class="modal fade" id="mapModal-{{ $residuo->id }}" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel-{{ $residuo->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="mapModalLabel-{{ $residuo->id }}">Ubicación del residuo</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div id="map-{{ $residuo->id }}" style="height: 400px; width: 100%;"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">No se han registrado residuos aún.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let maps = {};

  $(document).ready(function () {
    $('#tabla-residuos').DataTable({
      language: {
        lengthMenu: 'Mostrar _MENU_ registros por página',
        zeroRecords: 'No se encontraron resultados',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'No hay registros disponibles',
        infoFiltered: '(filtrado de _MAX_ registros totales)',
        search: 'Buscar:',
        paginate: {
          first: 'Primero',
          last: 'Último',
          next: 'Siguiente',
          previous: 'Anterior'
        }
      },
      responsive: true
    });

    // Confirmación con SweetAlert
    document.querySelectorAll('.show-confirm').forEach(button => {
      button.addEventListener('click', function () {
        const form = this.closest('form');
        Swal.fire({
          title: '¿Estás seguro?',
          text: 'Esta acción no se puede deshacer.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });

    // Desvanecer alertas
    const alert = document.querySelector('.alert-success');
    if (alert) {
      setTimeout(() => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
      }, 3000);
    }

    // Inicializar mapas
    $('[id^=mapModal-]').on('shown.bs.modal', function (e) {
      const trigger = $(e.relatedTarget);
      const lat = trigger.data('lat');
      const lng = trigger.data('lng');
      const nombre = trigger.data('nombre');
      const mapId = trigger.data('map');

      if (maps[mapId]) {
        maps[mapId].remove();
      }

      maps[mapId] = L.map(mapId).setView([lat, lng], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(maps[mapId]);

      L.marker([lat, lng]).addTo(maps[mapId])
        .bindPopup('Ubicación de: ' + nombre)
        .openPopup();

      setTimeout(() => {
        maps[mapId].invalidateSize();
      }, 200);
    });
  });
</script>
@endpush
