<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\punto;

class PuntoController extends Controller
{

   public function puntos()
   {
       
       $puntos = Punto::all(); 
       return view('puntos', compact('puntos'));
   }

   public function editarPuntoGet($Id_Puntos)
   {
       $punto = Punto::findOrFail($Id_Puntos);  
       return view('editar-punto', compact('punto')); 
   }

   public function actualizarPunto(Request $request, $Id_Puntos)
   {
       $punto = Punto::findOrFail($Id_Puntos);
       $validatedData = $request->validate([
           'Nombre_Punto'     => 'required|string|max:100',
           'Puntos_Obtenidos' => 'required|integer|min:0',
           'Descripcion'      => 'nullable|string|max:300',
       ]);

       $punto->update($validatedData);
       return redirect()->route('puntos')->with('success', 'Punto actualizado correctamente.');
   }

   public function guardarPunto(Request $request)
{
    $validatedData = $request->validate([
        'Nombre_Punto' => 'required|string|max:100',
        'Puntos_Obtenidos' => 'required|integer|min:0',
        'Descripcion' => 'required|string|max:300',
    ]);

    punto::create($validatedData);

    return redirect()->route('puntos')->with('success', 'Punto creado correctamente.');
}

public function cambiarEstadoPuntos($Id_puntos)
{
    $punto = Punto::findOrFail($Id_puntos);
    $punto->Estado = !$punto->Estado; 
    $punto->save();
    return redirect()->route('puntos')->with('success', 'Estado del producto actualizado correctamente.');
}


}
