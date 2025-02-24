<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
   public function index()
   {
        // $productos = producto::where('Estado', 1)->get();
        $productos = DB::select('CALL GetProductsWithDiscount()');
        return view('pos', compact('productos'));
   }
}
