@extends('layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title') Reporte de Inventario Crítico @endslot
                @slot('li_1') Inventario @endslot
            @endcomponent

            <div class="card table-list-card shadow-lg rounded-3 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="card-title">Productos con Stock Bajo</h4>
                        <a href="{{ route('descargar_csv') }}" class="btn btn-success">Descargar CSV</a>
                    </div>

                    <div class="table-responsive producto p-3">
                        <table class="table table-striped table-hover datanew">
                            <thead class="bg-danger text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Stock</th>
                                    <th>Ubicación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $producto->Nombre_Producto }}</td>
                                        <td>{{ $producto->Marca }}</td>
                                        <td class="text-danger fw-bold">{{ $producto->Stock }}</td>
                                        <td>{{ $producto->ubicacion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($productos->isEmpty())
                        <p class="text-center text-muted">No hay productos con stock crítico.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
