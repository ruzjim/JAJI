<?php $page = 'customers'; ?>
@extends('layout.mainlayout')
@section('content')
<style>
.dataTables_info {
    padding: 0px !important;
    margin: 0px !important;
    float: left;
    display: block;
}
.dataTables_length{
    display: none;
}
</style>
    @vite(['resources/js/test.js'])
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    Lista de Clientes
                @endslot
                @slot('li_1')
                    Administra tu lista de clientes
                @endslot
                @slot('li_2')
                    Agregar un nuevo cliente
                @endslot
            @endcomponent

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a href="" class="btn btn-searchset"><i data-feather="search"
                                        class="feather-search"></i></a>
                            </div>
                        </div>
                        <div class="search-path d-none">
                            <div class="d-flex align-items-center">
                                <a class="btn btn-filter" id="filter_search">
                                    <i data-feather="filter" class="filter-icon"></i>
                                    <span><img src="{{ URL::asset('/build/img/icons/closes.svg') }}" alt="img"></span>
                                </a>

                            </div>
                        </div>
                        <div class="form-sort d-none">
                            <i data-feather="sliders" class="info-img"></i>
                            <select class="select">
                                <option>Por fecha</option>
                                <option>Nuevo</option>
                                <option>Viejo</option>
                            </select>
                        </div>
                    </div>
      
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Cédula</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        
                                        <td>
                                            <div class="userimgname cust-imgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="{{ $customer->profile_photo_path }}"
                                                        alt="product">
                                                </a>
                                                <a href="javascript:void(0);">{{ $customer->name }}</a>
                                            </div>
                                        </td>
                                        <td>{{ $customer->cedula }}</td>
                                        <td>{{ $customer->telefono }}</td> 
                                        <td> {{ $customer->email }}</td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2" href="#">
                                                    <i data-feather="eye" class="feather-eye"></i>
                                                </a>
                                                <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit-units">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a class="confirm-text p-2" href="javascript:void(0);">
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
            <!-- /product list -->
        </div>
    </div>
@endsection
