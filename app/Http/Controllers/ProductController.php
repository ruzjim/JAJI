<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\producto;

class ProductController extends Controller
{
    public function producto()
{
    // Paginate the products, showing 10 products per page
    $producto = Producto::paginate(10);
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

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('query');  // Get the search query from the request
            
            // Search for products by name or brand
            $products = Producto::where('Nombre_Producto', 'like', '%' . $search . '%')
                                ->orWhere('Marca', 'like', '%' . $search . '%')  // You can add more fields here if needed
                                ->get();
            
            // Log the result for debugging purposes
            \Log::info($products); // This will log the products to the storage/logs/laravel.log file
            
            // Return the products as a JSON response
            return response()->json($products);
        }
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

    public function updateDiscount(Request $request, $Id_Producto)
{
    $producto = Producto::findOrFail($Id_Producto);

    // Validate the discount value
    $validatedData = $request->validate([
        'descuento' => 'required|numeric|min:0|max:100',
    ]);

    // Update the discount for the product
    $producto->descuento = $validatedData['descuento'];
    $producto->save();

    // Redirect back to the product list with a success message
    return redirect()->route('product-list')->with('success', 'Descuento aplicado correctamente.');
}

    
    public function cambiarEstado($Id_Producto)
    {
        $producto = Producto::findOrFail($Id_Producto);
        $producto->Estado = !$producto->Estado; 
        $producto->save();
        return redirect()->route('product-list')->with('success', 'Estado del producto actualizado correctamente.');
    }
    
}
