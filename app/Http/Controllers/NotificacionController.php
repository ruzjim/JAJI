<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    /**
     * Muestra todas las notificaciones activas.
     */
    public function index()
    {
        $notificaciones = Notificacion::where('Estado', true)
                                       ->orderBy('created_at', 'desc')
                                       ->get();
        return view('notificaciones.index', compact('notificaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva notificación.
     */
    public function create()
    {
        return view('notificaciones.create');
    }

    /**
     * Guarda una nueva notificación en la base de datos.
     */
    public function store(Request $request)
{
    $request->validate([
        'Tipo' => 'required|string|max:50',
        'Mensaje' => 'required|string|max:500',
    ]);

    Notificacion::create([
        'Tipo' => $request->Tipo,
        'Mensaje' => $request->Mensaje,
        'Estado' => 1, // opcional, por si querés forzar que se cree como activo
    ]);

    return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
}


    /**
     * Muestra el formulario para editar una notificación existente.
     */
    public function edit($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        return view('notificaciones.edit', compact('notificacion'));
    }

    /**
     * Actualiza una notificación en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Mensaje' => 'required|string|max:500',
        ]);

        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update([
            'Mensaje' => $request->Mensaje,
        ]);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    /**
     * Cambia el estado de la notificación (soft delete).
     */
    public function cambiarEstado($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->Estado = 0;
        $notificacion->save();

        return redirect()->route('notificaciones.index')->with('success', 'Notificación desactivada correctamente.');
    }
}
