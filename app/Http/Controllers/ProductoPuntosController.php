<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoPunto;
use App\Models\punto;
use App\Models\producto;

class ProductoPuntosController extends Controller
{
    public function producto_puntosList()
    {
        $productos_puntos = ProductoPunto::with(['producto', 'punto'])->get();
        return view('producto_puntos', compact('productos_puntos'));
    }

    public function crearproductopunto()
    {
        $productos = Producto::all();
        $puntos = Punto::all();

        return view('crear-producto_puntos', compact('productos', 'puntos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:producto,Id_Producto', 
            'punto_id' => 'required|exists:puntos,Id_Puntos', 
        ]);

        ProductoPunto::create([
            'Id_ProductoFK' => $request->producto_id, 
            'Id_PuntosFK' => $request->punto_id, 
        ]);

        return redirect()->route('producto_puntos')->with('success', 'Punto asignado correctamente.');
    }

    public function editar($id)
    {
        $productoPunto = ProductoPunto::findOrFail($id);
        $puntos = Punto::all();
        return view('editar-producto_puntos', compact('productoPunto', 'puntos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'punto_id' => 'required|exists:puntos,Id_Puntos', 
        ]);

        $productoPunto = ProductoPunto::findOrFail($id);
        $productoPunto->Id_PuntosFK= $request->punto_id;
        $productoPunto->save();

        return redirect()->route('producto_puntos')->with('success', 'Punto asignado actualizado correctamente.');
    }

    public function cambiarEstadoProductosPuntos($id)
{
    $punto = ProductoPunto::findOrFail($id);
    $punto->Estado = !$punto->Estado; 
    $punto->save();
    return redirect()->route('producto_puntos')->with('success', 'Estado del producto actualizado correctamente.');
}

}
