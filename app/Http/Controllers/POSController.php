<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class POSController extends Controller
{
    public function index()
    {
        // Obtener productos desde el procedimiento almacenado
        $productos = DB::select('CALL GetProductsWithDiscount()');

        // Obtener imágenes de promociones desde storage
        $archivos = File::files(storage_path('app/public/promociones'));
        $promociones = collect($archivos)->map(function ($archivo) {
            return asset('storage/promociones/' . basename($archivo));
        });

        return view('pos', compact('productos', 'promociones'));
    }
}