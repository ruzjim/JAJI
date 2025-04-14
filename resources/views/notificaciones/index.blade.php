@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        @component('components.breadcrumb')
            @slot('title') Lista de Notificaciones @endslot
            @slot('li_1') Gestión de Notificaciones @endslot
            @slot('li_2') {{ route('notificaciones.index') }} @endslot
            @slot('li_3') Agregar Notificación @endslot
        @endcomponent

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="card table-list-card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('notificaciones.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Agregar Notificación
                    </a>
                </div>

                <div class="table-responsive p-3">
                    <table class="table table-striped table-hover datanew">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Mensaje</th>
                                <th>Fecha de creación</th>
                                <th>Última modificación</th>
                                <th class="no-sort text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificaciones as $noti)
                                <tr>
                                    <td>{{ $noti->Id_Notificacion }}</td>
                                    <td>{{ $noti->Tipo }}</td>
                                    <td>{{ $noti->Estado }}</td>
                                    <td>{{ $noti->Mensaje }}</td>
                                    <td>{{ $noti->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $noti->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="action-table-data text-center">
                                        <div class="edit-delete-action d-flex justify-content-center gap-2">
                                            <a class="me-2 p-2" href="{{ route('notificaciones.edit', $noti->Id_Notificacion) }}">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a href="{{ route('notificaciones.cambiarEstado', $noti->Id_Notificacion) }}"
                                               onclick="return confirm('¿Estás seguro de que deseas desactivar esta notificación?');"
                                               class="p-2 text-danger" title="Desactivar">
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
    </div>
</div>
@endsection
