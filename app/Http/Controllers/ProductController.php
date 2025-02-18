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
        ]);
    
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
            'Estado'             => 'nullable|integer|min:0',
        ]);

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
    
}
