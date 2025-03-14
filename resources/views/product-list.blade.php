<?php $page = 'product-list'; ?>
@extends('layout.mainlayout')

@section('content')
@vite(['resources/js/productos.js'])
    <div class="page-wrapper">
        <div class="content">
            <!-- Breadcrumb Component -->
            @component('components.breadcrumb')
                @slot('title') Lista De Productos @endslot
                @slot('li_1') Maneja tus productos @endslot
                @slot('li_2') {{ url('add-product') }} @endslot
                @slot('li_3') Agregar Nuevo Producto @endslot
            @endcomponent

            <!-- Product List Table -->
            <div class="card table-list-card shadow-lg rounded-3 border-0">
                <div class="card-body">
                    <div class="table-responsive producto p-3">
                        <table class="table table-striped table-hover datanew">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Precio De Compra</th>
                                    <th>Precio De Venta</th>
                                    <th>Fecha De Creación</th>
                                    <th>Fecha De Modificación</th>
                                    <th>Ubicación</th>
                                    <th>Estado</th>
                                    <th>¿Expirado?</th>
                                    <th class="no-sort">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($producto as $producto)
                                    <tr>
                                        <td>{{ $producto->Nombre_Producto }}</td>
                                        <td>{{ $producto->Marca }}</td>
                                        <td>{{ $producto->Stock ?? 'N/A' }}</td>
                                        <td>{{ $producto->Descripcion }}</td>
                                        <td class="text-success fw-bold">₡ {{ number_format($producto->Precio_Compra, 2) }}</td>
                                        <td class="text-warning fw-bold">₡ {{ number_format($producto->Precio_Venta, 2) }}</td>
                                        <td>{{ $producto->created_at ? \Carbon\Carbon::parse($producto->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td>{{ $producto->updated_at ? \Carbon\Carbon::parse($producto->updated_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td>{{ $producto->ubicacion ?? 'N/A' }}</td>
                                        <td><span class="badge {{ $producto->Estado ? 'bg-success' : 'bg-danger' }}">{{ $producto->Estado ? 'Activo' : 'Inactivo' }}</span></td>
                                        <td><span class="badge {{ $producto->Expirado ? 'bg-danger' : 'bg-success' }}">{{ $producto->Expirado ? 'Si' : 'No' }}</span></td>
                                        <td class="action-table-data text-center">
                                            <div class="edit-delete-action d-flex justify-content-center gap-2">
                                                <a class="me-2 edit-icon  p-2" href="{{ url('product-details') }}">
                                                    <i data-feather="eye" class="feather-eye"></i>
                                                </a>
                                                <a class="me-2 p-2" href="{{ route('edit-product', $producto->Id_Producto) }}">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a href="#" class="btn-change-state" 
                                                   data-id="{{ $producto->Id_Producto }}" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#confirmStateModal">
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
            <!-- /Product List -->
        </div>
        <div id="stateChangeRoute" data-route="{{ route('cambiar-estado', ':id') }}" style="display: none;"></div>
    </div>
    <div class="modal fade" id="confirmStateModal" tabindex="-1" aria-labelledby="confirmStateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStateModalLabel">Confirmar cambio de estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas cambiar el estado de este producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmChangeButton" href="#" class="btn btn-primary">Confirmar</a>
                </div>
            </div>
        </div>
    </div>
@endsection