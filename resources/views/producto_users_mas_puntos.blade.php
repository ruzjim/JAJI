@extends('layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title') Clientes con más puntos @endslot
                @slot('li_1') Listado de clientes por puntos acumulados @endslot
            @endcomponent

            <div class="card table-list-card shadow-lg rounded-3 border-0">
                <div class="card-body">
                    <div class="table-responsive producto p-3">
                        <table class="table table-striped table-hover datanew">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Cédula</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Puntos Activos</th>
                                    <th>Estado</th>
                                    <th>Fecha de Expiración</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $usuario->name }}</td>
                                        <td>{{ $usuario->cedula }}</td>
                                        <td>{{ $usuario->telefono }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td class="fw-bold">{{ number_format($usuario->total_puntos) }}</td>
                                        <td>
                                            <span class="badge {{ $usuario->total_puntos > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $usuario->total_puntos > 0 ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
    @php
        $fechaCaducidad = $usuario->puntos()
            ->where('puntos_users.Estado', 1)
            ->whereRaw('YEAR(puntos_users.Fecha_De_Caducidad) >= YEAR(NOW())')
            ->max('Fecha_De_Caducidad');
    @endphp

    @if($fechaCaducidad)
        {{ \Carbon\Carbon::parse($fechaCaducidad)->format('d/m/Y') }} {{-- Formatear fecha --}}
    @else
        N/A {{-- Mostrar "N/A" si no hay fecha --}}
    @endif
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection