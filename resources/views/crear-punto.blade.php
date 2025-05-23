<?php $page = 'create-point'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <form action="{{ route('guardar-punto') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingOne">
                                    <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-controls="collapseOne">
                                        <div class="addproduct-icon">
                                            <h5><i data-feather="info" class="add-info"></i><span>Nuevo Punto</span></h5>
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
                                                    <label class="form-label">Nombre del Punto</label>
                                                    <input type="text" name="Nombre_Punto" placeholder="Ej. Punto A" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Cantidad De Puntos</label>
                                                    <input type="number" name="Puntos_Obtenidos" placeholder="Ej. 150" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                    <div class="mb-3 add-product">
                                                     <label class="form-label">Fecha de Expiración</label>
                                                     <input type="date" name="Fecha_De_Caducidad" class="form-control" 
                                                     min="{{ date('Y-m-d') }}" 
                                                      placeholder="Seleccione fecha (opcional)">
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-blocks summer-description-box transfer mb-3">
                                                <label>Descripción</label>
                                                <textarea name="Descripcion" placeholder="Descripción del punto" class="form-control h-100" rows="5" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary" style="margin-bottom: 15px;">Guardar Punto</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
