@extends('layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <!-- Breadcrumb Component -->
            @component('components.breadcrumb')
                @slot('title') Productos con Stock Bajo @endslot
                @slot('li_1') Ver Productos con Stock Bajo @endslot
            @endcomponent

            <!-- Product List Table -->
            <div class="card table-list-card shadow-lg rounded-3 border-0">
                <div class="card-body">
                    <div class="table-responsive producto p-3">
                        <table class="table table-striped table-hover datanew">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $producto->Nombre_Producto }}</td>
                                        <td>{{ $producto->Marca }}</td>
                                        <td>{{ $producto->Stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Product List -->
        </div>
    </div>
@endsection
