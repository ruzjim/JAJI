<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use Carbon\Carbon;

class NotificacionController extends Controller
{
    // 1️⃣ Listar Notificaciones Activas
    public function index()
    {
        $notificaciones = Notificacion::orderBy('created_at', 'desc')->get();
        return view('notificaciones', compact('notificaciones'));
    }

    // 2️⃣ Crear una Nueva Notificación
    public function crear(Request $request)
    {
        $request->validate([
            'Tipo' => 'required|string|max:50',
            'Mensaje' => 'required|string|max:255',
            'Estado' => 'required|string|in:activo,inactivo'
        ]);

        Notificacion::create([
            'Tipo' => $request->Tipo,
            'Mensaje' => $request->Mensaje,
            'Estado' => $request->Estado,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('notificaciones')->with('success', 'Notificación creada correctamente.');
    }

    // 3️⃣ Cambiar Estado de una Notificación
    public function cambiarEstado($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->Estado = $notificacion->Estado == 'activo' ? 'inactivo' : 'activo';
        $notificacion->save();

        return redirect()->route('notificaciones')->with('success', 'Estado actualizado correctamente.');
    }

    // 4️⃣ Eliminar una Notificación
    public function eliminar($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->delete();

        return redirect()->route('notificaciones')->with('success', 'Notificación eliminada correctamente.');
    }

    public function actualizarMensaje(Request $request, $id)
    {
        $request->validate([
            'Mensaje' => 'required|string|max:255',
        ]);

        $notificacion = Notificacion::findOrFail($id);
        $notificacion->Mensaje = $request->Mensaje;
        $notificacion->updated_at = now();
        $notificacion->save();

        return response()->json(['success' => true, 'message' => 'Mensaje actualizado correctamente.']);
    }

}
