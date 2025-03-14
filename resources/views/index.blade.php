<?php $page = 'index'; ?>
@extends('layout.mainlayout')
@section('content')
@vite(['resources/js/estadisticas.js'])
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4 id="total-usuarios">0</h4> 
                        <h5>Usuarios</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4 id="total-productos-expirados">0</h4>
                        <h5>Total De Productos Expirados</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="alert-triangle"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h4 id="total-productos-stock-bajo">0</h4>
                        <h5>Productos Con Bajo Stock</h5>
                    </div>
                    <div class="dash-imgs">
                       <i data-feather="archive"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4 id="total-productos-por-vencer">0</h4> 
                        <h5>Productos Pronto A Expirar</h5>
                    </div>
                    <div class="dash-imgs">
                       <i data-feather="clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->

        <div class="row">
            <div class="col-xl-7 col-sm-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Clientes Con Más Puntos</h4>
                                </div>
                                <div class="card-body">
                                    <div id="topclientes" class="chart-set"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-sm-12 col-12 d-flex">
                <div class="card flex-fill default-cover mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Productos Con Stock Bajo</h4>
                        <div class="view-all-link">
                            <a href="{{ url('stockbajo') }}" class="view-all d-flex align-items-center">
                                Ver Todo<span class="ps-2 d-flex align-items-center">
                                    <i data-feather="arrow-right" class="feather-16"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-list-card shadow-lg rounded-3 border-0">
                        <div class="table-responsive producto p-3" id="productos-stock-bajo">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Marca</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card table-list-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Productos A Punto De Expirar</h4>
        <div class="view-all-link">
            <a href="{{ url('productos_a_vencer') }}" class="view-all d-flex align-items-center">
                Ver Todo<span class="ps-2 d-flex align-items-center">
                    <i data-feather="arrow-right" class="feather-16"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="productos-expiran">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Marca</th>
                        <th>Fecha de Expiración</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


        </div>
    </div>
@endsection
