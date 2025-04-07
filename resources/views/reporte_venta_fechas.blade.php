@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Encabezado y total -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            @component('components.breadcrumb')
                @slot('title') Reporte de Ventas por Rango @endslot
                @slot('li_1') Ventas desde {{ $fechaInicio->format('d/m/Y') }} hasta {{ $fechaFin->format('d/m/Y') }} @endslot
            @endcomponent
            <div class="bg-primary text-white p-3 rounded">
                <h4 class="m-0">Total del período: ₡{{ number_format($totalVentas, 2) }}</h4>
            </div>
        </div>

        <!-- Filtro de fechas -->
        <div class="card mb-4 shadow-lg rounded-3 border-0">
            <div class="card-body">
                <form action="{{ route('reporte.ventas.fechas') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" 
                               class="form-control" 
                               name="fecha_inicio" 
                               value="{{ $fechaInicio->format('Y-m-d') }}"
                               required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha Fin</label>
                        <input type="date" 
                               class="form-control" 
                               name="fecha_fin" 
                               value="{{ $fechaFin->format('Y-m-d') }}"
                               required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla Unificada -->
        <div class="card table-list-card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <div class="table-responsive p-3">
                    <table id="ventasTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th># Venta</th>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Método Pago</th>
                                <th>Productos Vendidos</th>
                                <th>Cantidad Total</th>
                                <th>Total Venta (₡)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventas as $venta)
                            <tr>
                                <td>{{ $venta->Id_Venta }}</td>
                                <td>{{ $venta->Created_At->format('d/m/Y H:i') }}</td>
                                <td>{{ $venta->usuario->name ?? 'N/A' }}</td>
                                <td>{{ $venta->pago->metodo_pago ?? 'N/A' }}</td>
                                <td>
                                    @foreach($venta->productos as $producto)
                                        • {{ $producto->producto->Nombre_Producto ?? 'N/A' }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($venta->productos as $producto)
                                        {{ $producto->Cantidad }}<br>
                                    @endforeach
                                </td>
                                <td>₡{{ number_format($venta->Monto_Total, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No hay ventas en este período</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        @if($ventas->isNotEmpty())
            $('#ventasTable').DataTable({
                "order": [[1, 'desc']],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                },
                "columnDefs": [
                    { "className": "dt-center", "targets": [0, 3] },
                    { "className": "dt-right", "targets": [5, 6] }
                ]
            });
        @endif
    });
</script>
@endsection