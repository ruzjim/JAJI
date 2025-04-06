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
        ProductoPunto::whereNotNull('Fecha_De_Caducidad')
        ->where('Fecha_De_Caducidad', '<', now()->toDateString())
        ->where('Estado', 1)
        ->update(['Estado' => 0]);

        $productos_puntos = ProductoPunto::with(['producto', 'punto'])->get();
        return view('producto_puntos', compact('productos_puntos'));
    }

    public function crearproductopunto()
    {
        $productos = Producto::all();
        $puntos = Punto::where('Estado', 1)->get();

        return view('crear-producto_puntos', compact('productos', 'puntos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:producto,Id_Producto', 
            'punto_id' => 'required|exists:puntos,Id_Puntos', 
            'Fecha_De_Caducidad' => 'nullable|date|after_or_equal:today',
        ]);

        $fechaCaducidad = $request->Fecha_De_Caducidad 
        ? \Carbon\Carbon::parse($request->Fecha_De_Caducidad)
        : null;

        ProductoPunto::create([
            'Id_ProductoFK' => $request->producto_id, 
            'Id_PuntosFK' => $request->punto_id, 
            'Fecha_De_Caducidad' => $fechaCaducidad,
            'Estado' => ($fechaCaducidad && ($fechaCaducidad->isToday() || $fechaCaducidad->isFuture())) ? 1 : 0,

        ]);

        return redirect()->route('producto_puntos')->with('success', 'Punto asignado correctamente.');
    }

    public function editar($id)
    {
        $productoPunto = ProductoPunto::findOrFail($id);
        $puntos = Punto::where('Estado', 1)->get();
        return view('editar-producto_puntos', compact('productoPunto', 'puntos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'punto_id' => 'required|exists:puntos,Id_Puntos', 
            'Fecha_De_Caducidad' => 'nullable|date|after_or_equal:today',
        ]);

        $productoPunto = ProductoPunto::findOrFail($id);
        $productoPunto->Id_PuntosFK= $request->punto_id;

        if ($request->has('Fecha_De_Caducidad')) {
            $fechaCaducidad = \Carbon\Carbon::parse($request->Fecha_De_Caducidad);
            $productoPunto->Fecha_De_Caducidad = $fechaCaducidad;
            $productoPunto->Estado = ($fechaCaducidad->isToday() || $fechaCaducidad->isFuture()) ? 1 : 0;

        }
    

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

public function obtenerPuntosPorProducto($producto_id)
{
    $productoPunto = ProductoPunto::where('Id_ProductoFK', $producto_id)
                                   ->where('Estado', 1)
                                   ->first();

    if ($productoPunto) {
        $punto = Punto::find($productoPunto->Id_PuntosFK);

        if ($punto) {
            return response()->json([
                'success' => true,
                'puntos_obtenidos' => $punto->Puntos_Obtenidos,
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'No se encontraron puntos asociados.',
    ]);
}



}
