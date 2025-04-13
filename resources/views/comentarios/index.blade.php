@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        @component('components.breadcrumb')
            @slot('title') Lista de Comentarios @endslot
            @slot('li_1') Gestión de Comentarios @endslot
            @slot('li_2') {{ route('comentarios.create') }} @endslot
            @slot('li_3') Agregar Comentario @endslot
        @endcomponent

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card table-list-card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('comentarios.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Agregar Comentario
                    </a>
                </div>

                <div class="table-responsive p-3">
                    <table class="table table-striped table-hover datanew">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Comentario</th>
                                <th>Fecha de creación</th>
                                <th>Última modificación</th>
                                <th class="no-sort text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comentarios as $comentario)
                                <tr>
                                    <td>{{ $comentario->Id_Comentario }}</td>
                                    <td>{{ $comentario->Comentario }}</td>
                                    <td>{{ $comentario->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $comentario->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="action-table-data text-center">
                                        <div class="edit-delete-action d-flex justify-content-center gap-2">
                                            <a class="me-2 p-2" href="{{ route('comentarios.edit', $comentario->Id_Comentario) }}">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a href="{{ route('comentarios.cambiarEstado', $comentario->Id_Comentario) }}"
                                               onclick="return confirm('¿Estás seguro de que deseas desactivar este comentario?');"
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
