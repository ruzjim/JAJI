<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;

class POSController extends Controller
{
   public function index()
   {
        $productos = producto::where('Estado', 1)->get();
        return view('pos', compact('productos'));
   }
}
