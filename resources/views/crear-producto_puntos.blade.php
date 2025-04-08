@extends('layout.mainlayout')

@section('content')
@vite(['resources/js/productoSearch.js'])
<div class="page-wrapper">
    <div class="content">
        <h4>Asignar Punto a Producto</h4>
        <form action="{{ route('producto_puntos.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Seleccionar Producto <span class="text-danger">*</span></label>
                                <select name="producto_id" class="form-control" required>
                                    <option value="">Seleccione un producto</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->Id_Producto }}">{{ $producto->Nombre_Producto }} - {{ $producto->Marca }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Seleccionar Punto <span class="text-danger">*</span></label>
                                <select name="punto_id" class="form-control" required>
                                    <option value="">Seleccione un punto</option>
                                    @foreach ($puntos as $punto)
                                        <option value="{{ $punto->Id_Puntos}}">{{ $punto->Nombre_Punto }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de Expiración <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="Fecha_De_Caducidad" 
                                       class="form-control"
                                       min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                       required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Asignar Punto</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection