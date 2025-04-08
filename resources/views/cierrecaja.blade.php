<?php $page = 'cierrecaja'; ?>
@extends('layout.mainlayout')
@section('content')
    @vite(['resources/js/cierrecaja.js'])
    <style>
        .dataTables_info {
            padding: 0px !important;
            margin: 0px !important;
            float: left;
            display: block;
        }

        .dataTables_length {
            display: none;
        }
    </style>
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    Cierre de Caja
                @endslot
                @slot('li_1')
                    Gestión de Cierre de Caja
                @endslot
                @slot('li_2')
                    Agregar un nuevo cliente
                @endslot
            @endcomponent

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    @if (empty($ventasSinCierre))
                        <div class="alert alert-primary" role="alert">
                            No hay ventas pendientes de cierre.
                        </div>
                    @else
                    <div class="table-top">
                        @foreach ($metodosPagoSuma as $metodo => $suma)
                            <div class="col-md-3">
                                <div class="">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $metodo }}</h5>
                                        <p class="card-text">Monto: <b>₡{{ number_format($suma, 2) }}</b> </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="col-md-3">
                            <div class="">
                                <div class="card-body">
                                    <button class="btn btn-primary" id="completeCierreBtn" data-bs-toggle="modal"
                                        data-bs-target="#confirmCierreModal">Completar Cierre</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="confirmCierreModal" tabindex="-1"
                                        aria-labelledby="confirmCierreModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmCierreModalLabel">Confirmar Cierre de
                                                        Caja</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Por favor, confirme que los montos están completos:</p>
                                                    @foreach ($metodosPagoSuma as $metodo => $suma)
                                                        <p><strong>{{ $metodo }}:</strong> ₡
                                                            {{ number_format($suma, 2) }}</p>
                                                        <p>
                                                            <label for="montoCaja{{ $metodo }}">Monto en caja para
                                                                {{ $metodo }}:</label>
                                                            <input type="number" class="form-control iFaltante"
                                                                id="montoCaja{{ $metodo }}"
                                                                name="montoCaja[{{ $metodo }}]" step="0.01"
                                                                required>
                                                        </p>

                                                        <p id="faltanteText{{ $metodo }}">
                                                            Diferencia para {{ $metodo }}: ₡<span
                                                                class="montofaltante"
                                                                id="faltanteMonto{{ $metodo }}">{{ number_format($suma, 2) }}</span>
                                                        </p>

                                                        <script>
                                                            document.getElementById('montoCaja{{ $metodo }}').addEventListener('input', function() {
                                                                const inputMonto = parseFloat(this.value) || 0;
                                                                const faltante = {{ $suma }} - inputMonto;
                                                                document.getElementById('faltanteMonto{{ $metodo }}').innerText = faltante.toFixed(2);
                                                            });
                                                        </script>
                                                    @endforeach
                                                    <p>
                                                        <label for="comentariosCierre">Comentarios:</label>
                                                        <textarea class="form-control" id="comentariosCierre" name="comentariosCierre" rows="3"></textarea>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="confirmCierreBtn">Continuar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="table-responsive">
                        <h5 class="card-title">Detalles de ventas</h5>

                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>Venta</th>
                                    <th>Monto</th>
                                    <th>Metodo</th>
                                    <th>Vendedor</th>
                                    <th>Fecha y hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    const idVentas = "{{ implode(',', collect($ventasSinCierre)->pluck('Id_Venta')->toArray()) }}";
                                    const totalMetodosPago = "{{ array_sum($metodosPagoSuma) }}";
                                </script>
                                @foreach ($ventasSinCierre as $venta)
                                    <tr>

                                        
                                        <td>{{ $venta->Id_Venta }}</td>
                                        <td>{{ $venta->Monto_Total }}</td>
                                        <td>{{ $venta->Metodo_Pago }}</td>
                                        <td> {{ $venta->Usuario_Cedula }}</td>
                                        <td> {{ $venta->Created_At }}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>
@endsection
