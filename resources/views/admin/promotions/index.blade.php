@extends('layout.mainlayout')

@section('content')
<div class="container">
    <h2>Manage Promotions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Upload Form --}}
<form action="{{ route('promotions.store') }}" method="POST" enctype="multipart/form-data" id="promoForm">
    @csrf
    <input type="file" name="image" class="form-control" id="promoImage">
    <button type="submit" class="btn btn-primary">Upload Promotion</button>
</form>



<div class="alert alert-warning text-center" role="alert">
    🔴 <strong>¡Aviso Importante!</strong> Para la compra de productos como <strong>cigarrillos y cerveza</strong>, se solicitará identificación. ¡Gracias por su comprensión! 🔴
</div>

<style>
    .alert-warning {
        background-color: #ffcc00;
        color: #000;
        font-size: 18px;
        font-weight: bold;
        padding: 15px;
        border-radius: 8px;
        border: 2px solid #ff9900;
        margin-bottom: 20px;
    }
</style>



    {{-- Display Active Promotions --}}
    <h3 class="mt-4">Active Promotions</h3>
    <div class="row">
        @foreach($promotionImages as $image)
            <div class="col-md-4 text-center mt-3">
                <img src="{{ $image }}" class="img-fluid" style="max-width: 300px;">
                <form action="{{ route('promotions.destroy') }}" method="POST">
                    @csrf
                    <input type="hidden" name="image" value="{{ $image }}">
                    <button type="submit" class="btn btn-danger mt-2">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
</div>

{{-- JavaScript to Debug Issues --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('promoForm');
        const fileInput = document.getElementById('promoImage');

        if (!form) {
            console.error("Error: Form with ID 'promoForm' not found!");
            return;
        }

        if (!fileInput) {
            console.error("Error: File input with ID 'promoImage' not found!");
            return;
        }

        fileInput.addEventListener('change', function () {
            console.log("File selected:", fileInput.files[0]); // ✅ Log file selection
            // form.submit(); // ❌ Temporarily disabled for debugging
        });
    });
</script>


@endsection
