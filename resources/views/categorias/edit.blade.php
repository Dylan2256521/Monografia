@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Categoría</h2>

    <form action="{{ route('categorias.update', $categoria) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre', $categoria->nombre) }}">
        </div>


        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
