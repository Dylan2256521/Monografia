@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-4 d-flex justify-content-between align-items-center">
    Listado de Categorías
    <a href="{{ route('categorias.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Agregar Categoría
    </a>
  </h3>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table id="tabla-categorias" class="table table-striped table-bordered m-0">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categorias as $categoria)
              <tr>
                <td>{{ $categoria->id }}</td>
                <td>{{ $categoria->nombre }}</td>
                <td>{{ $categoria->descripcion }}</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-1 flex-wrap">
                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-sm btn-warning mb-1" title="Editar">
                      <i class="fas fa-edit"></i>
                    </a>

                    <form method="POST" action="{{ route('categorias.destroy', $categoria->id) }}" class="d-inline delete-form" data-id="{{ $categoria->id }}">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-sm btn-danger show-confirm mb-1" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">No se han registrado categorías aún.</td>
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
  $(document).ready(function () {
    const tabla = $('#tabla-categorias').DataTable({
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
      responsive: true,
      columnDefs: [
        { orderable: false, targets: 3 } // Deshabilita orden en columna acciones
      ]
    });

    // Confirmación de eliminar con SweetAlert
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

    // Auto ocultar alertas
    const alert = document.querySelector('.alert-success');
    if (alert) {
      setTimeout(() => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
      }, 3000);
    }
  });
</script>
@endpush
