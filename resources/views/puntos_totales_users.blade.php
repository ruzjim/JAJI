<?php $page = 'puntos'; ?>
@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Breadcrumb Component -->
        @component('components.breadcrumb')
            @slot('title') Puntos Acumulados del Usuario @endslot
            @slot('li_1') Gestión de Puntos @endslot
            @slot('li_2') {{ url('puntos-users') }} @endslot
            @slot('li_3') Buscar Usuario @endslot
        @endcomponent

        <!-- Card con información del usuario -->
        <div class="card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <h4 class="mb-4">Información del Usuario</h4>

                @if(isset($usuario))
                    <div class="row mb-3">
                        <label class="col-md-2 fw-bold">Nombre:</label>
                        <div class="col-md-10">
                            <p class="form-control-plaintext">{{ $usuario->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 fw-bold">Cédula:</label>
                        <div class="col-md-10">
                            <p class="form-control-plaintext">{{ $usuario->cedula }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 fw-bold">Correo:</label>
                        <div class="col-md-10">
                            <p class="form-control-plaintext">{{ $usuario->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 fw-bold">Teléfono:</label>
                        <div class="col-md-10">
                            <p class="form-control-plaintext">{{ $usuario->telefono ?? 'No hay teléfono disponible' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 fw-bold">Total de Puntos Acumulados:</label>
                        <div class="col-md-10">
                            <p class="form-control-plaintext fw-bold text-primary fs-4">{{ $usuario->total_puntos }}</p>
                        </div>
                    </div>

                @else
                    <div class="alert alert-warning">No se encontraron datos para esta cédula.</div>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('puntos_users') }}" class="btn btn-secondary">Realizar otra búsqueda</a>
        </div>
    </div>
</div>
@endsection
