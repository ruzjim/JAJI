@extends('layout.mainlayout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Administrar Promociones</h2>

    {{-- Mensajes de sesión --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Formulario de subida de imagen --}}
    <form action="{{ route('promociones.subir') }}" method="POST" enctype="multipart/form-data" id="promoForm" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="promoImage" class="form-label">Seleccioná una imagen de promoción</label>
            <input type="file" name="imagen" class="form-control" id="promoImage" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir Promoción</button>
    </form>

    {{-- Lista de promociones actuales --}}
    <h4 class="mb-3">Promociones Actuales</h4>
    <div class="row">
        @forelse($imagenesPromociones as $imagen)
            <div class="col-md-4 text-center mb-4">
                <img src="{{ $imagen }}" alt="Promoción" class="img-fluid rounded border shadow-sm" style="max-height: 200px; object-fit: cover;">
                <form action="{{ route('promociones.borrar') }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="imagen" value="{{ $imagen }}">
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center">No hay imágenes cargadas.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
