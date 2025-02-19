<?php $page = 'puntos'; ?>
@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Breadcrumb Component -->
        @component('components.breadcrumb')
            @slot('title') Buscar Usuario @endslot
            @slot('li_1') Gestión de Puntos @endslot
            @slot('li_2') {{ url('puntos-totales-users') }} @endslot
            @slot('li_3') Ver Puntos Totales @endslot
        @endcomponent

        <!-- Card para la búsqueda -->
        <div class="card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <h4 class="mb-4">Buscar Usuario por Cédula</h4>
                <form action="{{ route('puntos_users_buscar') }}" method="GET">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese la cédula del usuario" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
