@extends('layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <!-- Breadcrumb Component -->
            @component('components.breadcrumb')
                @slot('title') Crear Notificación @endslot
                @slot('li_1') Maneja tus notificaciones @endslot
                @slot('li_2') {{ url('notificaciones') }} @endslot
                @slot('li_3') Ver Notificaciones @endslot
            @endcomponent

            <div class="card shadow-lg rounded-3 border-0">
                <div class="card-body">
                    <h4 class="card-title">Nueva Notificación</h4>
                    <form method="POST" action="{{ route('guardar_notificacion') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="Tipo" class="form-label">Tipo de Notificación</label>
                            <select name="Tipo" class="form-control" required>
                                <option value="descuento">Descuento</option>
                                <option value="anuncio">Anuncio</option>
                                <option value="horario">Horario</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="Mensaje" class="form-label">Mensaje</label>
                            <textarea name="Mensaje" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="Estado" class="form-label">Estado</label>
                            <select name="Estado" class="form-control" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Notificación</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
