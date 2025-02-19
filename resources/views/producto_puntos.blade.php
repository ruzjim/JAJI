<?php $page = 'producto_puntos'; ?>
@extends('layout.mainlayout')

@section('content')
@vite(['resources/js/productoPuntos.js'])
<div class="page-wrapper">
    <div class="content">
        <!-- Breadcrumb Component -->
        @component('components.breadcrumb')
            @slot('title') Lista de Productos y sus Puntos @endslot
            @slot('li_1') Maneja tus productos y puntos @endslot
            @slot('li_2') {{ url('crear-producto_puntos') }} @endslot
            @slot('li_3') Asignar Punto a Producto @endslot
        @endcomponent

        <!-- Productos Puntos List Table -->
        <div class="card table-list-card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <div class="table-responsive producto p-3">
                    <table class="table table-striped table-hover datanew">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Nombre del Producto</th>
                                <th>Nombre del Punto</th>
                                <th>Cantidad De Puntos</th>
                                <th>Estado</th>
                                <th>Descripción del Punto</th>
                                <th>Fecha de Asignación</th>
                                <th class="no-sort">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos_puntos as $pp)
                                <tr>
                                    <td>{{ $pp->producto->Nombre_Producto}} - {{ $pp->producto->Marca }} </td>
                                    <td>{{ $pp->punto->Nombre_Punto ?? 'No asignado' }}</td>
                                    <td>{{ $pp->punto->Puntos_Obtenidos ?? 'Sin Puntos' }}</td>
                                    <td><span class="badge {{ $pp->Estado ? 'bg-success' : 'bg-danger' }}">{{ $pp->Estado ? 'Activo' : 'Inactivo' }}</span></td>
                                    <td>{{ $pp->punto->Descripcion ?? 'Sin descripción' }}</td>
                                    <td>{{ $pp->created_at ? \Carbon\Carbon::parse($pp->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td class="action-table-data text-center">
                                        <div class="edit-delete-action d-flex justify-content-center gap-2">
                                            <a class="me-2 edit-icon p-2" href="{{ route('editar-producto_puntos', $pp->id) }}">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a href="#" class="btn-change-state" data-id="{{ $pp->id }}" data-bs-toggle="modal" data-bs-target="#confirmStateModal">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for Confirming Deletion -->
        <div id="stateChangeRoute" data-route="{{ route('cambiar-estado-producto-punto', ':id') }}" style="display: none;"></div>
    </div>
    <div class="modal fade" id="confirmStateModal" tabindex="-1" aria-labelledby="confirmStateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStateModalLabel">Confirmar cambio de estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas cambiar el estado de esta asignación?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmChangeButton" href="#" class="btn btn-primary">Confirmar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
