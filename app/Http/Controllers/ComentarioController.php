<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    /**
     * Muestra todos los comentarios.
     */
    public function index()
    {
        $comentarios = Comentario::where('Estado', true)
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        return view('comentarios.index', compact('comentarios'));
    }
    

    /**
     * Muestra el formulario para crear un nuevo comentario.
     */
    public function create()
    {
        return view('comentarios.create');
    }

    /**
     * Guarda un nuevo comentario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Comentario' => 'required|string|max:500',
        ]);

        Comentario::create([
            'Comentario' => $request->Comentario,
            'Id_ClienteFK' => null, // Comentario anónimo
        ]);

        return redirect()->route('comentarios.index')->with('success', 'Comentario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un comentario existente.
     */
    public function edit($id)
    {
        $comentario = Comentario::findOrFail($id);
        return view('comentarios.edit', compact('comentario'));
    }

    /**
     * Actualiza un comentario en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Comentario' => 'required|string|max:500',
        ]);

        $comentario = Comentario::findOrFail($id);
        $comentario->update([
            'Comentario' => $request->Comentario,
        ]);

        return redirect()->route('comentarios.index')->with('success', 'Comentario actualizado correctamente.');
    }

    /**
     * Cambia el estado del comentario (activación/desactivación lógica).
     */
    public function cambiarEstado($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->Estado = 0; // solo desactiva
        $comentario->save();

        return redirect()->route('comentarios.index')->with('success', 'Comentario desactivado correctamente.');
    }

    /**
     * Elimina un comentario de la base de datos.
     */
    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return redirect()->route('comentarios.index')->with('success', 'Comentario eliminado correctamente.');
    }
}
