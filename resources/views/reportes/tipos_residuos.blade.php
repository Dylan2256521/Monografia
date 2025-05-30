@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tipos de Residuos</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $peligrosos }}</h3>
                    <p>Residuos Peligrosos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-skull-crossbones"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $inflamables }}</h3>
                    <p>Residuos Inflamables</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fire"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $biodegradables }}</h3>
                    <p>Residuos Biodegradables</p>
                </div>
                <div class="icon">
                    <i class="fas fa-leaf"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
