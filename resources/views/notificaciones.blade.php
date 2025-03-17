<?php $page = 'notificacion-list'; ?>
@extends('layout.mainlayout')

@section('content')
@vite(['resources/js/notificaciones.js'])
    <div class="page-wrapper">
        <div class="content">
            <!-- Breadcrumb Component -->
            @component('components.breadcrumb')
                @slot('title') Lista de Notificaciones @endslot
                @slot('li_1') Gestiona tus notificaciones @endslot
                @slot('li_2') {{ url('crear-notificacion') }} @endslot
                @slot('li_3') Agregar Nueva Notificación @endslot
            @endcomponent

            <!-- Notificaciones Table -->
            <div class="card table-list-card shadow-lg rounded-3 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="card-title">Lista de Notificaciones</h4>
                        <a href="{{ route('crear_notificacion') }}" class="btn btn-primary">Crear Notificación</a>
                    </div>

                    <div class="table-responsive p-3">
                        <table class="table table-striped table-hover datanew">
                            <thead class="bg-warning text-white">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Mensaje</th>
                                    <th>Estado</th>
                                    <th>Fecha de Creación</th>
                                    <th>Última Modificación</th>
                                    <th class="no-sort">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notificaciones as $notificacion)
                                    <tr>
                                        <td>{{ ucfirst($notificacion->Tipo) }}</td>
                                        <td>{{ $notificacion->Mensaje }}</td>
                                        <td>
                                            <span class="badge {{ $notificacion->Estado == 'activo' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($notificacion->Estado) }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($notificacion->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($notificacion->updated_at)->format('d/m/Y H:i') }}</td>
                                        <td class="action-table-data text-center">
                                            <div class="edit-delete-action d-flex justify-content-center gap-2">
                                                <!-- Ícono de edición (Abrir modal) -->
                                                <a href="#" class="me-2 p-2 btn-edit-notification" 
                                                   data-id="{{ $notificacion->Id_Notificacion }}"
                                                   data-mensaje="{{ $notificacion->Mensaje }}"
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#editNotificationModal">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <!-- Ícono de eliminar -->
                                                <a class="me-2 p-2 btn-delete-notification" href="#" 
                                                   data-id="{{ $notificacion->Id_Notificacion }}" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#confirmDeleteModal">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($notificaciones->isEmpty())
                        <p class="text-center text-muted">No hay notificaciones registradas.</p>
                    @endif
                </div>
            </div>
            <!-- /Notificaciones Table -->
        </div>

        <!-- Hidden route for updating messages -->
        <div id="updateMessageRoute" data-route="{{ route('actualizar_mensaje_notificacion', ':id') }}" style="display: none;"></div>

        <!-- Hidden route for deleting -->
        <div id="deleteNotificationRoute" data-route="{{ route('eliminar_notificacion', ':id') }}" style="display: none;"></div>
    </div>

    <!-- Modal para Editar Notificación -->
    <div class="modal fade" id="editNotificationModal" tabindex="-1" aria-labelledby="editNotificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNotificationModalLabel">Editar Notificación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editNotificationId">
                    <label for="editMensaje" class="form-label">Mensaje:</label>
                    <textarea id="editMensaje" class="form-control" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="saveNotificationBtn" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta notificación?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmDeleteButton" href="#" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

@endsection
