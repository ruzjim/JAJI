<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\producto;

class ProductController extends Controller
{
    public function producto()
    {
                $producto = Producto::all();
                return view('product-list', compact('producto'));
    }
    
    public function guardarProducto(Request $request)
    {
        $validatedData = $request->validate([
            'Nombre_Producto' => 'required|string|max:100',
            'Marca' => 'required|string|max:100',
            'Stock' => 'nullable|integer|min:0',
            'Descripcion' => 'required|string|max:300',
            'Precio_Compra' => 'required|numeric|min:0',
            'Precio_Venta' => 'required|numeric|min:0',
            'ubicacion' => 'required|string|max:100',
            'Fecha_De_Caducidad' => 'nullable|date|after_or_equal:today',
        ]);

        if ($request->has('Fecha_De_Caducidad')) {
            $validatedData['Fecha_De_Caducidad'] = \Carbon\Carbon::parse($request->Fecha_De_Caducidad)->format('Y-m-d');
        }
    
        Producto::create($validatedData);
    
        return redirect()->route('product-list')->with('success', 'Producto creado correctamente.');
    }
    
    
    public function editarProductoGet($Id_Producto)
    {
        $producto = Producto::findOrFail($Id_Producto);
        return view('edit-product', compact('producto'));
    }

    public function actualizarProducto(Request $request, $Id_Producto)
    {
        $producto = Producto::findOrFail($Id_Producto);

        $validatedData = $request->validate([
            'Nombre_Producto'   => 'required|string|max:100',
            'Marca'             => 'required|string|max:100',
            'Stock'             => 'nullable|integer|min:0',
            'Descripcion'       => 'required|string|max:300',
            'Precio_Compra'      => 'required|numeric|min:0',
            'Precio_Venta'      => 'required|numeric|min:0',
            'ubicacion'         => 'required|string|max:255',
            'Fecha_De_Caducidad' => 'nullable|date|after_or_equal:today',
            'Estado'             => 'nullable|integer|min:0',
            'Expirado' => 'nullable|integer|min:0|max:1',


        ]);

        if ($request->has('Fecha_De_Caducidad')) {
            $validatedData['Fecha_De_Caducidad'] = \Carbon\Carbon::parse($request->Fecha_De_Caducidad)->format('Y-m-d');
        }

        $producto->update($validatedData);
        
        return redirect()->route('product-list')->with('success', 'Producto actualizado correctamente.');
    }
    
    public function cambiarEstado($Id_Producto)
    {
        $producto = Producto::findOrFail($Id_Producto);
        $producto->Estado = !$producto->Estado; 
        $producto->save();
        return redirect()->route('product-list')->with('success', 'Estado del producto actualizado correctamente.');
    }

    public function productosExpirados()
{
    $productos = Producto::where('Expirado', 1)->get();
    return view('productos-expirados', compact('productos'));
}

//Juan Pa - Filtrar productos con stock menor a 5 en el backend
public function stockCritico()
{
    // Obtener productos con stock menor a 5
    $productos = Producto::where('Stock', '<', 5)->get();
    
    return view('stock-critico', compact('productos'));
}

// Método para descargar en CSV
public function descargarCsv()
{
    $productos = Producto::where('Stock', '<', 5)->get();

    $csvFileName = 'reporte_stock_critico.csv';
    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$csvFileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $callback = function () use ($productos) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['ID', 'Producto', 'Marca', 'Stock', 'Ubicación']);

        foreach ($productos as $producto) {
            fputcsv($file, [
                $producto->Id_Producto,
                $producto->Nombre_Producto,
                $producto->Marca,
                $producto->Stock,
                $producto->ubicacion
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


}
