<?php $page = 'add-product'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <form action="{{ route('guardar-producto') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingOne">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-controls="collapseOne">
                                        <div class="addproduct-icon">
                                            <h5><i data-feather="info" class="add-info"></i><span>Nuevo Producto</span></h5>
                                            <a href="javascript:void(0);"><i data-feather="chevron-down" class="chevron-down-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Nombre Producto</label>
                                                    <input type="text" name="Nombre_Producto" placeholder="Ej. Arroz Tío Pelón" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Marca</label>
                                                    <input type="text" name="Marca" placeholder="Ej. Black & Decker" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Stock</label>
                                                    <input type="number" name="Stock" placeholder="Ej. 25"class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Precio De Compra</label>
                                                    <input type="text" name="Precio_Compra" placeholder="Ej. 4500" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Precio De Venta</label>
                                                    <input type="text" name="Precio_Venta" placeholder="Ej. 4500" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Pasillo</label>
                                                    <input type="text" name="ubicacion" placeholder="Ej. Pasillo 1" class="form-control" required>
                                                </div>
                                            </div>
                                             <div class="col-lg-4 col-sm-6 col-12">
                                                 <div class="mb-3 add-product">
                                                    <label class="form-label">Fecha de Caducidad</label>
                                                    <input type="date" name="Fecha_De_Caducidad" class="form-control" required>
                                                   </div>
                                             </div>
                                         </div>
                                        <div class="col-lg-12">
                                            <div class="input-blocks summer-description-box transfer mb-3">
                                                <label>Description</label>
                                                <textarea name="Descripcion" placeholder="Descripción del producto" class="form-control h-100" rows="5" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary" style="margin-bottom: 15px;">Guardar Producto</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
