@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        @component('components.breadcrumb')
            @slot('title') Crear Comentario @endslot
            @slot('li_1') Comentarios @endslot
            @slot('li_2') {{ route('comentarios.index') }} @endslot
            @slot('li_3') Volver a la lista @endslot
        @endcomponent

        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body">
                <form action="{{ route('comentarios.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="Comentario" class="form-label">Comentario</label>
                        <textarea name="Comentario" class="form-control @error('Comentario') is-invalid @enderror" rows="4" required>{{ old('Comentario') }}</textarea>
                        @error('Comentario')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                    <a href="{{ route('comentarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
