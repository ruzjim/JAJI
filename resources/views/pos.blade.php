<?php $page = 'pos'; ?>
@extends('layout.mainlayout')
@section('content')
    @vite(['resources/js/addproducts.js'])
    <style>
        .product-wrap {
            height: auto;
            overflow-y: auto;
        }
    </style>

    <div class="page-wrapper pos-pg-wrapper ms-0">
        <div class="content pos-design p-0">
            <div class="row align-items-start pos-wrapper">
                <div class="col-md-12 col-lg-8">
                    <div class="pos-categories tabs_wrapper">

                        <div class="pos-products">
                        {{-- Banner de advertencia legal --}}
<div class="alert alert-warning d-flex align-items-center gap-2" role="alert">
    <i class="fa-solid fa-id-card fa-lg"></i>
    <div>
        Por ley se solicitará documento de identidad para la compra de cigarrillos, licor y productos restringidos.
    </div>
</div>
{{-- Carrusel de Promociones (versión mediana) --}}
<div id="promoCarousel" class="carousel slide mb-3 mx-auto" data-bs-ride="carousel" data-bs-interval="5000" style="max-width: 600px;">
    <div class="carousel-inner rounded" style="height: 200px; overflow: hidden;">
        <div class="carousel-item active">
            <img src="{{ asset('storage/promociones/banner.jpg') }}" class="d-block w-100" alt="Promoción 1" style="object-fit: cover; height: 100%;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('storage/promociones/banner2.jpg') }}" class="d-block w-100" alt="Promoción 2" style="object-fit: cover; height: 100%;">
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-3">Productos</h5>
                            </div>
                            <div class="tabs_container">
                                <div class="tab_content active" data-tab="all">
                                    <div class="row">
                                        @foreach ($productos as $producto)
                                            <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                                                <div class="product-info default-cover card producto-card"
                                                    data-id="{{ $producto->Id_Producto }}">
                                                    <a href="javascript:void(0);" class="img-bg">
                                                        @if ($producto->imagen)
                                                            <img src="{{ $producto->imagen }}" alt="Products" class="p-5"
                                                                style="width: 70%;">
                                                        @else
                                                            <img src="https://icons.veryicon.com/png/o/miscellaneous/fu-jia-intranet/product-29.png"
                                                                alt="Products" class="p-5" style="width: 70%;">
                                                        @endif
                                                        <span><i data-feather="check" class="feather-16"></i></span>
                                                    </a>
                                                    <h6 class="cat-name"><a
                                                            href="javascript:void(0);">{{ $producto->Marca }}</a></h6>
                                                    <h6 class="product-name"><a
                                                            href="javascript:void(0);">{{ $producto->Nombre_Producto }}</a>
                                                    </h6>
                                                    <span>{{ $producto->barcode }}</span>
                                                    <div class="d-flex align-items-center justify-content-between price">
                                                        <span>{{ $producto->Stock }} uds</span>
                                                        <span class="d-none">{{ $producto->Id_Producto }}</span>
                                                        <p>₡ {{ $producto->Precio_Venta }}</p>
                                                    </div>
                                                    @if ($producto->descuento > 0)
                                                        <span
                                                            class="badge bg-success p-2 text-dark bg-opacity-50 position-absolute top-1 start-1 rounded-circle p-2">-{{ $producto->descuento }}%</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @dump($productos) --}}
                <div class="col-md-12 col-lg-4 ps-0">
                    <aside class="product-order-list">
                        <div class="customer-info block-section">
                            <h6>Información del cliente</h6>
                            <div class="input-block d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control" placeholder="Cédula de Cliente">
                                </div>
                                <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#create"><i data-feather="user-plus" class="feather-16"></i></a>
                            </div>
                            <p><strong>Nombre del Cliente Encontrado</strong></p>
                        </div>
                        <div class="customer-info block-section">
                            <h6>Escanear Artículos</h6>
                            <div class="input-block d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control" placeholder="Escanea el articulo"
                                        id="escaner" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="product-added block-section">
                            <div class="head-text d-flex align-items-center justify-content-between">
                                <h6 class="d-flex align-items-center mb-0">Productos Agregados<span class="count"
                                        id="contadorArticulos">0</span></h6>
                                <a href="javascript:void(0);" class="d-flex align-items-center text-danger"><span
                                        class="me-1"><i data-feather="x" class="feather-16"></i></span>Cancelar compra</a>
                            </div>
                            <div class="product-wrap" id="ListaProductos">
                            </div>
                        </div>
                        <div class="block-section">

                            <div class="order-total">
                                <table class="table table-responsive table-borderless">
                                    <tr>
                                        <td class="text-success fw-bold">Total Descuento (Usted Ahorra)</td>
                                        <!-- Juan Pa Aquí: Cambiamos a color verde y negrita -->
                                        <td class="text-success text-end fw-bold" id="totalDescuento">-₡ 0</td>
                                        <!-- Juan Pa Aquí: Aplicamos el mismo estilo -->
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-end" id="totalCompra">₡ 0</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="block-section payment-method">
                            <h6>Payment Method</h6>
                            <input type="hidden" id="paymentMethod" name="paymentMethod" value="">

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const paymentMethodInput = document.getElementById('paymentMethod');
                                    const metodoRecibo = document.getElementById('metodoRecibo');
                                    const paymentMethods = document.querySelectorAll('.methods .item a');

                                    paymentMethods.forEach(method => {
                                        method.addEventListener('click', function () {
                                            paymentMethods.forEach(m => m.classList.remove('selected'));
                                            this.classList.add('selected');
                                            const selectedMethod = this.querySelector('span').innerText;
                                            paymentMethodInput.value = selectedMethod;
                                            metodoRecibo.innerText = selectedMethod;
                                        });
                                    });
                                });
                            </script>

                            <style>
                                .methods .item a.selected {
                                    border: 2px solid #007bff;
                                    border-radius: 5px;
                                }
                            </style>
                            <div class="row d-flex align-items-center justify-content-center methods">
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);" class="metodo-pago" data-id="1">
                                            <img src="{{ URL::asset('/build/img/icons/cash-pay.svg') }}" width="20"
                                                alt="Payment Method">
                                            <span>Efectivo</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);" class="metodo-pago" data-id="2">
                                            <img src="{{ URL::asset('/build/img/icons/credit-card.svg') }}" width="20"
                                                alt="Payment Method">
                                            <span>Tarjeta Cred/Debito</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);" class="metodo-pago" data-id="3">
                                            <img src="{{ URL::asset('/build/img/icons/sinpe.png') }}" width="20"
                                                alt="Payment Method">
                                            <span>Sinpe Movil</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid btn-block">
                            <span class="btn btn-secondary" id="totalPagar">
                                Total A Pagar: ₡ 0
                            </span>
                            <button class="btn btn-primary mt-2" id="contadorPuntosBtn" disabled>
                                 Puntos Obtenidos: <span id="totalPuntos">0</span>
                            </button>
                </div>
                <div class="btn-row d-sm-flex align-items-center justify-content-between">
                    <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill"><span
                            class="me-1 d-flex align-items-center"><i data-feather="trash-2"
                                class="feather-16"></i></span>Cancelar Compra</a>

                                <a href="javascript:void(0);" class="btn btn-warning btn-icon flex-fill"  id="abrirModalPuntosBtn">
                                  <span class="me-1 d-flex align-items-center">
                                  <i class="fa-solid fa-coins fa-lg"></i>&nbsp;&nbsp;
                                  </span>Agregar Puntos
                                 </a>
                                 
                    <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill cargaElementos" id="procesarPago"><span class="me-1 d-flex align-items-center"><i
                                data-feather="credit-card" class="feather-16"></i></span>Proceder al Pago</a>
                </div>
                </aside>
            </div>
        </div>
    </div>

    <div class="modal fade" id="puntosModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Puntos al Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPuntos">
                    <div class="mb-3">
                        <label class="form-label">Cédula del Cliente</label>
                        <input type="text" class="form-control" id="cedula" required>
                    </div>
                    <input type="hidden" id="venta_id" value="{{ $ventaActual->Id_Venta ?? '' }}">
                    <button type="submit" class="btn btn-primary">Agregar Puntos</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
    <script>
        let productos = @json($productos);
    </script>
@endsection
