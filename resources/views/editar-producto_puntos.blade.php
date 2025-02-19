@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h2 class="mb-4">Editar Punto Asignado al Producto</h2>

        <!-- Edit Product Point Form -->
        <div class="card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <form action="{{ route('editar-producto_puntos.update', $productoPunto->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <label for="producto" class="col-md-2 col-form-label">Producto</label>
                        <div class="col-md-10">
                            <input type="text" id="producto" class="form-control" value="{{ $productoPunto->producto->Nombre_Producto }} - {{ $productoPunto->producto->Marca }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="punto_id" class="col-md-2 col-form-label">Punto Para Asignar</label>
                        <div class="col-md-10">
                            <select id="punto_id" name="punto_id" class="form-control" required>
                                <option value="">Seleccione un Punto</option>
                                @foreach($puntos as $punto)
                                    <option value="{{ $punto->Id_Puntos }}" 
                                        {{ $productoPunto->Id_PuntosFK == $punto->Id_Puntos ? 'selected' : '' }}>
                                        {{ $punto->Nombre_Punto }}
                                    </option>
                                @endforeach
                            </select>
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
