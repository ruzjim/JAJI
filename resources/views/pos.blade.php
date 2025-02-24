<?php $page = 'pos'; ?>
@extends('layout.mainlayout')
@section('content')
    @vite(['resources/js/addproducts.js'])
    <style>
        .product-wrap{
            height: auto;
            overflow-y: auto;
        }
    </style>

    <div class="page-wrapper pos-pg-wrapper ms-0">
        <div class="content pos-design p-0">
            <div class="btn-row d-sm-flex align-items-center">
                <a href="javascript:void(0);" class="btn btn-secondary mb-xs-3" data-bs-toggle="modal"
                    data-bs-target="#orders"><span class="me-1 d-flex align-items-center"><i data-feather="shopping-cart"
                            class="feather-16"></i></span>View Orders</a>
                <a href="javascript:void(0);" class="btn btn-info"><span class="me-1 d-flex align-items-center"><i
                            data-feather="rotate-cw" class="feather-16"></i></span>Reset</a>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recents"><span
                        class="me-1 d-flex align-items-center"><i data-feather="refresh-ccw"
                            class="feather-16"></i></span>Transaction</a>
            </div>

            <div class="row align-items-start pos-wrapper">
                <div class="col-md-12 col-lg-8">
                    <div class="pos-categories tabs_wrapper">
                        <div class="d-none">
                            <h5>Categoria</h5>
                            <p>Seleccione una categoria</p>
                            <ul class="tabs owl-carousel pos-category">
                                <li id="all">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-01.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">All Categories</a></h6>
                                    <span>80 Items</span>
                                </li>
                                <li id="headphones">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-02.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Headphones</a></h6>
                                    <span>4 Items</span>
                                </li>
                                <li id="shoes">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-03.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Shoes</a></h6>
                                    <span>14 Items</span>
                                </li>
                                <li id="mobiles">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-04.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Mobiles</a></h6>
                                    <span>7 Items</span>
                                </li>
                                <li id="watches">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-05.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Watches</a></h6>
                                    <span>16 Items</span>
                                </li>
                                <li id="laptops">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-06.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Laptops</a></h6>
                                    <span>18 Items</span>
                                </li>
                                <li id="allcategory">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-01.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">All Categories</a></h6>
                                    <span>80 Items</span>
                                </li>
                                <li id="headphone">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-02.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Headphones</a></h6>
                                    <span>4 Items</span>
                                </li>
                                <li id="shoe">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-03.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Shoes</a></h6>
                                    <span>14 Items</span>
                                </li>
                                <li id="mobile">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-04.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Mobiles</a></h6>
                                    <span>7 Items</span>
                                </li>
                                <li id="watche">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-05.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Watches</a></h6>
                                    <span>16 Items</span>
                                </li>
                                <li id="laptop">
                                    <a href="javascript:void(0);">
                                        <img src="{{ URL::asset('/build/img/categories/category-06.png') }}"
                                            alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">Laptops</a></h6>
                                    <span>18 Items</span>
                                </li>
                            </ul>
                        </div>
                        <div class="pos-products">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-3">Productos</h5>
                            </div>
                            <div class="tabs_container">
                                <div class="tab_content active" data-tab="all">
                                    <div class="row">
                                        @foreach ($productos as $producto)
                                            <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                                            <div class="product-info default-cover card">
                                                <a href="javascript:void(0);" class="img-bg">
                                                    @if ($producto->imagen)
                                                        <img src="{{ $producto->imagen }}"
                                                            alt="Products" class="p-5" style="width: 70%;">
                                                    @else
                                                    <img src="https://icons.veryicon.com/png/o/miscellaneous/fu-jia-intranet/product-29.png"
                                                        alt="Products" class="p-5" style="width: 70%;">
                                                    @endif
                                                    <span><i data-feather="check" class="feather-16"></i></span>
                                                </a>
                                                <h6 class="cat-name"><a href="javascript:void(0);">{{ $producto->Marca }}</a></h6>
                                                <h6 class="product-name"><a href="javascript:void(0);">{{ $producto->Nombre_Producto }}</a>
                                                </h6>
                                                <div class="d-flex align-items-center justify-content-between price">
                                                    <span>{{ $producto->Stock }} uds</span>
                                                    <span class="d-none">{{ $producto->Id_Producto }}</span>
                                                    <p>₡ {{ $producto->Precio_Venta }}</p>
                                                </div>
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
                            <h6>Customer Information</h6>
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
                                    <input type="text" class="form-control" placeholder="Escanea el articulo" id="escaner" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="product-added block-section">
                            <div class="head-text d-flex align-items-center justify-content-between">
                                <h6 class="d-flex align-items-center mb-0">Productos Agregados<span class="count" id="contadorArticulos">0</span></h6>
                                <a href="javascript:void(0);" class="d-flex align-items-center text-danger"><span
                                        class="me-1"><i data-feather="x" class="feather-16"></i></span>Cancelar compra</a>
                            </div>
                            <div class="product-wrap" id="ListaProductos">

                                {{-- <div class="product-list d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                        data-bs-target="#products">
                                        <a href="javascript:void(0);" class="img-bg">
                                            <img src="{{ URL::asset('/build/img/products/pos-product-16.png') }}"
                                                alt="Products">
                                        </a>
                                        <div class="info">
                                            <span>PT0005</span>
                                            <h6><a href="javascript:void(0);">Red Nike Laser</a></h6>
                                            <p>$2000s</p>
                                        </div>
                                    </div>
                                    <div class="qty-item text-center">
                                        <a href="javascript:void(0);"
                                            class="dec d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i
                                                data-feather="minus-circle" class="feather-14"></i></a>
                                        <input type="text" class="form-control text-center" name="qty"
                                            value="4">
                                        <a href="javascript:void(0);"
                                            class="inc d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i
                                                data-feather="plus-circle" class="feather-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center action">
                                        <a class="btn-icon edit-icon me-2" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit-product">
                                            <i data-feather="edit" class="feather-14"></i>
                                        </a>
                                        <a class="btn-icon delete-icon confirm-text" href="javascript:void(0);">
                                            <i data-feather="trash-2" class="feather-14"></i>
                                        </a>
                                    </div>
                                </div> --}}


                            </div>
                        </div>
                        <div class="block-section">
                            <div class="selling-info">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="input-block">
                                            <label>Order Tax</label>
                                            <select class="select">
                                                <option>GST 5%</option>
                                                <option>GST 10%</option>
                                                <option>GST 15%</option>
                                                <option>GST 20%</option>
                                                <option>GST 25%</option>
                                                <option>GST 30%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="input-block">
                                            <label>Shipping</label>
                                            <select class="select">
                                                <option>15</option>
                                                <option>20</option>
                                                <option>25</option>
                                                <option>30</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="input-block">
                                            <label>Discount</label>
                                            <select class="select">
                                                <option>10%</option>
                                                <option>10%</option>
                                                <option>15%</option>
                                                <option>20%</option>
                                                <option>25%</option>
                                                <option>30%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-total">
                                <table class="table table-responsive table-borderless">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end">$60,454</td>
                                    </tr>
                                    <tr>
                                        <td>Tax (GST 5%)</td>
                                        <td class="text-end">$40.21</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping</td>
                                        <td class="text-end">$40.21</td>
                                    </tr>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end">$60,454</td>
                                    </tr>
                                    <tr>
                                        <td class="danger">Discount (10%)</td>
                                        <td class="danger text-end">$15.21</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-end">$64,024.5</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="block-section payment-method">
                            <h6>Payment Method</h6>
                            <div class="row d-flex align-items-center justify-content-center methods">
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);">
                                            <img src="{{ URL::asset('/build/img/icons/cash-pay.svg') }}"
                                                alt="Payment Method">
                                            <span>Cash</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);">
                                            <img src="{{ URL::asset('/build/img/icons/credit-card.svg') }}"
                                                alt="Payment Method">
                                            <span>Debit Card</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);">
                                            <img src="{{ URL::asset('/build/img/icons/qr-scan.svg') }}"
                                                alt="Payment Method">
                                            <span>Scan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid btn-block">
                            <a class="btn btn-secondary" href="javascript:void(0);">
                                Grand Total : $64,024.5
                            </a>
                        </div>
                        <div class="btn-row d-sm-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill"
                                data-bs-toggle="modal" data-bs-target="#hold-order"><span
                                    class="me-1 d-flex align-items-center"><i data-feather="pause"
                                        class="feather-16"></i></span>Hold</a>
                            <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill"><span
                                    class="me-1 d-flex align-items-center"><i data-feather="trash-2"
                                        class="feather-16"></i></span>Void</a>
                            <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill"
                                data-bs-toggle="modal" data-bs-target="#payment-completed"><span
                                    class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                        class="feather-16"></i></span>Payment</a>
                        </div>

                    </aside>
                </div>
            </div>
        </div>
    </div>
    <script>
        let productos = @json($productos);
    </script>
@endsection
