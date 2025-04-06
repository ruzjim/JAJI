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

       // Calcular 'Expirado'
    $validatedData['Expirado'] = 0; // La validación asegura que la fecha es futura o no existe

    // Calcular 'Estado'
    $validatedData['Estado'] = (($validatedData['Stock'] ?? 0) > 0) ? 1 : 0;

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
        'Nombre_Producto' => 'required|string|max:100',
        'Marca' => 'required|string|max:100',
        'Stock' => 'nullable|integer|min:0',
        'Descripcion' => 'required|string|max:300',
        'Precio_Compra' => 'required|numeric|min:0',
        'Precio_Venta' => 'required|numeric|min:0',
        'ubicacion' => 'required|string|max:255',
        'Fecha_De_Caducidad' => 'nullable|date|after_or_equal:today',
    ]);

    // 1. Calcular 'Expirado'
    if ($request->has('Fecha_De_Caducidad')) {
        $fecha = \Carbon\Carbon::parse($request->Fecha_De_Caducidad);
        $validatedData['Expirado'] = $fecha->isPast() ? 1 : 0;
    } else {
        $fechaExistente = $producto->Fecha_De_Caducidad 
            ? \Carbon\Carbon::parse($producto->Fecha_De_Caducidad) 
            : null;
            
        $validatedData['Expirado'] = ($fechaExistente && $fechaExistente->isPast()) ? 1 : 0;
    }

    // 2. Si no hay fecha, no está expirado
    if (empty($validatedData['Fecha_De_Caducidad'])) {
        $validatedData['Expirado'] = 0;
    }

    // 3. Obtener el stock actualizado o el existente
    $stock = isset($validatedData['Stock']) 
        ? $validatedData['Stock'] 
        : $producto->Stock;

    // 4. Calcular estado: inactivo si está expirado o sin stock
    $validatedData['Estado'] = ($validatedData['Expirado'] == 1 || $stock <= 0) ? 0 : 1;

    $producto->update($validatedData);

    return redirect()->route('product-list')->with('success', 'Producto actualizado correctamente.');
}
    
    public function cambiarEstado($Id_Producto)
    {
        $producto = Producto::findOrFail($Id_Producto);
        if ($producto->Estado == 0 && $producto->Stock <= 0) {
            return redirect()->route('product-list')->with('error', 'No se puede activar un producto sin stock.');
        }
        
        $producto->Estado = !$producto->Estado; 
        $producto->save();
        return redirect()->route('product-list')->with('success', 'Estado del producto actualizado correctamente.');
    }

    public function productosExpirados()
{
    $productos = Producto::where('Expirado', 1)->get();
    return view('productos-expirados', compact('productos'));
}

}
