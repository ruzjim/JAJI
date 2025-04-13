{{-- Vista: notificaciones/create.blade.php --}}
@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('components.breadcrumb')
            @slot('title') Crear Notificación @endslot
            @slot('li_1') Notificaciones @endslot
            @slot('li_2') {{ route('notificaciones.index') }} @endslot
            @slot('li_3') Lista de Notificaciones @endslot
        @endcomponent

        <div class="card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <form action="{{ route('notificaciones.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="Tipo" class="form-label">Tipo</label>
                        <input type="text" name="Tipo" id="Tipo" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Mensaje" class="form-label">Mensaje</label>
                        <textarea name="Mensaje" id="Mensaje" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection