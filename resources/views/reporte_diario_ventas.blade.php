@extends('layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <!-- Breadcrumb con total de ventas -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                @component('components.breadcrumb')
                    @slot('title') Reporte Diario de Ventas @endslot
                    @slot('li_1') Resumen de ventas del día actual @endslot
                @endcomponent
                <div class="bg-success text-white p-3 rounded">
                    <h4 class="m-0">Total del día: ₡{{ number_format($totalVentas, 2) }}</h4>
                </div>
            </div>

            <!-- Tabla de productos vendidos -->
            <div class="card table-list-card shadow-lg rounded-3 border-0">
                <div class="card-body">
                    <div class="table-responsive producto p-3">
                        <table id="ventasDiariasTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Cantidad Vendida</th>
                                    <th>Total (₡)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productosVendidos as $producto)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $producto->barcode ?? 'N/A' }}</td>
                                        <td>{{ $producto->Nombre_Producto ?? 'N/A' }}</td>
                                        <td>{{ $producto->Marca ?? 'N/A' }}</td>
                                        <td>{{ $producto->cantidad_vendida ?? 0 }}</td>
                                        <td>₡{{ number_format($producto->total_producto ?? 0, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No hay ventas registradas hoy</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
<script>
    $(document).ready(function() {
        @if($productosVendidos->isNotEmpty())
            $('#ventasDiariasTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0] }, 
                    { "className": "dt-right", "targets": [4, 5] } 
                ],
                "order": [[4, 'desc']]
            });
        @endif
    });
</script>
@endsection
@endsection
