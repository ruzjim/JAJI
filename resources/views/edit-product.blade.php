<?php $page = 'edit-product'; ?>
@extends('layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
        <form action="{{ route('update-product', $producto->Id_Producto) }}" method="POST">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingOne">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-controls="collapseOne">
                                        <div class="addproduct-icon">
                                            <h5><i data-feather="info" class="add-info"></i><span>Editar Producto</span></h5>
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
                                                    <input type="text" name="Nombre_Producto" value="{{ old('Nombre_Producto', $producto->Nombre_Producto) }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Marca</label>
                                                    <input type="text" name="Marca" value="{{ old('Marca', $producto->Marca) }}" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Stock</label>
                                                    <input type="number" name="Stock" value="{{ old('Stock', $producto->Stock) }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Precio De Compra</label>
                                                    <input type="text" name="Precio_Compra" value="{{ old('Precio_Compra', $producto->Precio_Compra) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Precio De Venta</label>
                                                    <input type="text" name="Precio_Venta" value="{{ old('Precio_Venta', $producto->Precio_Venta) }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Pasillo</label>
                                                    <input type="text" name="ubicacion" value="{{ old('ubicacion', $producto->ubicacion) }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                 <div class="mb-3 add-product">
                                                    <label class="form-label">Fecha de Caducidad</label>
                                                    <input type="date" name="Fecha_De_Caducidad" value="{{ old('Fecha_De_Caducidad', $producto->Fecha_De_Caducidad) }}" class="form-control" required>
                                                   </div>
                                             </div>
                                             <div class="col-lg-4 col-sm-6 col-12">
                                                  <div class="mb-3 add-product">
                                                     <label class="form-label">¿Expirado?</label>
                                                     <input type="hidden" name="Expirado" value="0">
                                                     <select name="Expirado" class="form-control" required>
                                                     <option value="0" {{ $producto->Expirado == 0 ? 'selected' : '' }}>No</option>
                                                     <option value ="1" {{ $producto->Expirado == 1 ? 'selected' : '' }}>Si</option>
                                                                             </select>
                                                     </div>
                                             </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-blocks summer-description-box transfer mb-3">
                                                <label>Descripción</label>
                                                <textarea name="Descripcion" class="form-control h-100" rows="5" required>{{ $producto->Descripcion }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary" style="margin-bottom: 15px;">Actualizar Producto</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
