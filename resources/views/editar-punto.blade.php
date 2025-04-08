@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h2 class="mb-4">Editar Punto de Producto</h2>

        <!-- Edit Point Form -->
        <div class="card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <form action="{{ route('update-punto', $punto->Id_Puntos) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <label for="Nombre_Punto" class="col-md-2 col-form-label">Nombre del Punto</label>
                        <div class="col-md-10">
                            <input type="text" id="Nombre_Punto" name="Nombre_Punto" class="form-control" value="{{ old('Nombre_Punto', $punto->Nombre_Punto) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="Puntos_Obtenidos" class="col-md-2 col-form-label">Cantidad de Puntos</label>
                        <div class="col-md-10">
                            <input type="number" id="Puntos_Obtenidos" name="Puntos_Obtenidos" class="form-control" value="{{ old('Puntos_Obtenidos', $punto->Puntos_Obtenidos) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="Descripcion" class="col-md-2 col-form-label">Descripción</label>
                        <div class="col-md-10">
                            <textarea id="Descripcion" name="Descripcion" class="form-control" rows="4">{{ old('Descripcion', $punto->Descripcion) }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
    <label for="Fecha_De_Caducidad" class="col-md-2 col-form-label">Fecha Expiración</label>
    <div class="col-md-10">
        <input type="date" id="Fecha_De_Caducidad" name="Fecha_De_Caducidad" 
               class="form-control" 
               value="{{ old('Fecha_De_Caducidad', $punto->Fecha_De_Caducidad ? \Carbon\Carbon::parse($punto->Fecha_De_Caducidad)->format('Y-m-d') : '') }}"
               min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
    </div>
</div>

                    <div class="row mb-3">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
