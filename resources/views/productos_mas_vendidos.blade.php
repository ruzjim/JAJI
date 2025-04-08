@extends('layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title') Productos Más Vendidos @endslot
                @slot('li_1') Reporte de Productos Más Vendidos @endslot
            @endcomponent

            <div class="card table-list-card shadow-lg rounded-3 border-0">
                <div class="card-body">
                    <div class="table-responsive producto p-3">
                        <table class="table table-striped table-hover datanew">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Total Vendido</th>
                                    <th>Stock Actual</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($productos as $producto)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $producto->Nombre_Producto }}</td>
        <td>{{ $producto->Marca }}</td>
        <td>{{ $producto->total_vendido ?? 0 }}</td>
        <td>{{ $producto->Stock }}</td>
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